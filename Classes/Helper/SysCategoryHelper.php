<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Helper;

use function array_search;
use function is_array;
use function is_object;

use PDO;
use TYPO3\CMS\Core\Category\Collection\CategoryCollection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ComparisonInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Description of SysCategory
 * @deprecated
 */
class SysCategoryHelper
{
    /**
     * Table name of the category table.
     * @var string
     */
    public const CATEGORY_TABLE = 'sys_category';

    /**
     * Table name of the MM-relation table.
     * @var string
     */
    public const RELATION_TABLE = 'sys_category_record_mm';

    /**
     * Name of the default category field.
     * @var string
     */
    public const CATEGORY_FIELD = 'categories';

    /**
     * A TYPO3 object manager instance.
     *
     * @var ObjectManager|null
     */
    protected ?ObjectManager $objectManager = null;

    /**
     * The table name of the referenced record.
     *
     * @var string
     */
    protected string $tableName = '';

    /**
     * The UID of the referenced record.
     *
     * @var int
     */
    protected int $uid = 0;

    /**
     * category field in foreign table
     *
     * @var string
     */
    protected string $field = 'categories';

    /**
     * A system category repository instance.
     *
     * @var CategoryRepository
     */
    protected ?CategoryRepository $categoryRepository = null;

    /**
     * A query builder instance.
     *
     * @var QueryBuilder
     */
    protected ?QueryBuilder $queryBuilder = null;

    /**
     * The array of sys_category UIDs found for the referenced record.
     *
     * @var int[]
     */
    protected array $categories = [];

    /**
     * Creates a new instance of the SysCategoryHelper.
     *
     * @param int $uid The uid of the record.
     * @param string $table The table name of the record.
     * @param string $field field in table for categories
     */
    public function __construct(int $uid, string $table, string $field = self::CATEGORY_FIELD)
    {
        /* Assign and sanitize the parameter */
        $this->uid = (int) $uid;

        /* Assign the parameter */
        $this->tableName = $table;
        $this->field = $field;

        $this->categories = [];
        $this->categoryRepository = null;
        $this->objectManager = null;
        $this->queryBuilder = null;

        /* Call the initialization method */
        $this->initialize();
    }

    /**
     * Initializes the TYPO3 stuff.
     *
     * @return void
     */
    protected function initialize(): void
    {
        /* Use the TYPO3 way to create an instance */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /* Get an instance of the repository from the object manager */
        $this->categoryRepository = $this->objectManager->get(
            CategoryRepository::class
        );

        $this->queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::CATEGORY_TABLE);

        /* Try to find categories */
        $this->parseResult();
    }

    /**
     * Prepares the QueryBuilder with the select from statement.
     *
     * @return void
     */
    protected function prepareQuery(): void
    {
        /* Prepare the most basic select from statement */
        $this->queryBuilder
            ->select(self::CATEGORY_TABLE . '.uid')
            ->from(self::CATEGORY_TABLE);

        $this->addJoinStatement();
    }

    /**
     * Applies mm-join statement to QueryBuilder.
     *
     * @return void
     */
    protected function addJoinStatement(): void
    {
        /* Apply MM-join to query */
        $this->queryBuilder->join(
            self::CATEGORY_TABLE,
            self::RELATION_TABLE,
            self::RELATION_TABLE,
            $this->queryBuilder->expr()->eq(
                self::RELATION_TABLE . '.uid_local',
                self::CATEGORY_TABLE . '.uid'
            )
        )
        ->join(
            self::RELATION_TABLE,
            $this->tableName,
            $this->tableName,
            $this->queryBuilder->expr()->eq(
                self::RELATION_TABLE . '.uid_foreign',
                $this->tableName . '.uid'
            )
        );

        $this->addWhereStatement();
    }

    /**
     * Applies the complicated expression to the QueryBuilder that is required
     * to select the sys_category.uid(s) by using the mm-table fields.
     *
     * @return void
     */
    protected function addWhereStatement(): void
    {
        /* Apply more complicated where expression to query */
        $this->queryBuilder->where(
            $this->tableName . '.uid=' . $this->uid,
            $this->queryBuilder->expr()->eq(
                self::RELATION_TABLE . '.fieldname',
                $this->queryBuilder->createNamedParameter($this->field, PDO::PARAM_STR)
            ),
            $this->queryBuilder->expr()->eq(
                self::RELATION_TABLE . '.tablenames',
                $this->queryBuilder->createNamedParameter($this->tableName, PDO::PARAM_STR)
            )
        );
    }

    /**
     * Parses the mysqli_result into the categories member variable.
     *
     * @return void
     */
    protected function parseResult(): void
    {
        /* Apply all constraints to the querybuilder */
        $this->prepareQuery();

        /* Get the statement for the prepared query */
        $statement = $this->queryBuilder->execute();

        /* Iterate results returned from query */
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) {
            $this->categories[] = (int) $row['uid'];
        }
    }

    /**
     * Creates <code>equals</code> constraints for the query from the queried
     * sys_category UIDs saved in the categories member varaible.
     *
     * @param QueryInterface $query The query to create the constraints for
     * @return ComparisonInterface[] An array containing constraints
     */
    protected function createConstraints(QueryInterface $query): array
    {
        /* Prepare the return variable */
        $constraints = [];

        /* Iterate the sys_category UIDs */
        foreach ($this->categories as $uid) {
            /* Create an equals constraint for each UID */
            $constraints[] = $query->equals('uid', $uid);
        }

        return $constraints;
    }

    /**
     *
     * @param array $categories An array of sys_category UIDs
     * @return bool Returns true if all UIDs are found
     */
    public function hasCategories(array $categories): bool
    {
        /* Iterate the UIDs */
        foreach ($categories as $uid) {
            /* Search the categories member if the UID value exists */
            $hasCategory = array_search($uid, $this->categories);

            /* If array search returns false the UID does not exist */
            if ($hasCategory === false) {
                return false; // No need to continue
            }
        }

        /* Only if all UIDs were found we return true */
        return true;
    }

    /**
     * Returns the array of sys_category UIDs found for the record.
     *
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * Returns actual TYPO3 sys_category objects as a query result set.
     *
     * @return QueryResultInterface|null
     */
    public function getCategoryObjects(): ?QueryResultInterface
    {
        /* Create the query */
        $query = $this->categoryRepository->createQuery();

        /* Create constraints for the sys_categorys of the referenced object */
        $constraints = $this->createConstraints($query);

        if (empty($constraints)) {
            return null;
        }

        /* Return the query result */
        return $query->matching(
            $query->logicalAnd(              // All constraints required
                $query->logicalOr(           // Any of the given constraints
                    $constraints             // sys_category UIDs
                ),
                $query->equals('hidden', 0), // Not hidden
                $query->equals('deleted', 0) // Not deleted
            )
        )->execute();                        // Execute the query
    }

    /**
     * Get records for category as array
     *
     * @author Marco Wegner <m.wegner@remind.de>
     * @return array Records as array
     */
    public static function getRecordsForCategory($uid, $table, $onlyUids = false, $field = 'categories'): array
    {
        if ($uid == 0) {
            return [];
        }

        /* TYPO3 libraries for categories */
        $collection = CategoryCollection::load($uid, true, $table, $field);

        $records = [];

        if ($collection == null) {
            return [];
        }

        /* parse collection result to array */
        if ($collection->count() > 0) {
            foreach ($collection as $item) {
                if (is_object($item)) {
                    $uidItem = $item->getUid();
                }

                if (is_array($item)) {
                    $uidItem = $item['uid'];
                }

                if ($onlyUids) {
                    $records[] = $uidItem;
                } else {
                    $records[$uidItem] = $item;
                }
            }
        }

        return $records;
    }
}
