<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Command;

use Doctrine\DBAL\DBALException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Description of CleanupDeletedRecordsCommand
 */
class CleanupDeletedRecordsCommand extends Command
{
    /**
     * @var string
     */
    protected const OPTION_TABLE = 'table';

    /**
     * @var string
     */
    protected const OPTION_MAX_AGE = 'maxAge';

    /**
     * @var string
     */
    protected const OPTION_MAX_COUNT = 'maxCount';

    /**
     *
     * @var ConnectionPool
     */
    protected ?ConnectionPool $connectionPool = null;

    /**
     * Prepare command and initialize required objects.
     *
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setDescription('Deletes deleted records from the given tables.');
        $this->setHelp('Specify some table names');

        $this->addOption(
            self::OPTION_TABLE,
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'A table that will be searched and cleaned'
        );
        $this->addOption(
            self::OPTION_MAX_AGE,
            null,
            InputOption::VALUE_OPTIONAL,
            'Number of seconds',
            0
        );
        $this->addOption(
            self::OPTION_MAX_COUNT,
            null,
            InputOption::VALUE_OPTIONAL,
            'Only process this number of records in total',
            0
        );

        $this->connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
    }

    /**
     * Run the actual command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null Returns 0 or null on success or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        /* Parse the parameters */
        $tables = $input->getOption(self::OPTION_TABLE);
        $maxAge = (int) $input->getOption(self::OPTION_MAX_AGE);
        $maxCount = (int) $input->getOption(self::OPTION_MAX_COUNT);

        /* Prepare return value with ok code */
        $return = 0;

        foreach ($tables as $table) {
            try {
                /* Actual processing */
                $count = $this->processTable($table, $maxAge, $maxCount);

                /* Write status when command is run with -v */
                $output->writeln(
                    'Processed ' . $table . '. Deleted ' . $count . ' records',
                    OutputInterface::VERBOSITY_VERBOSE
                );
            } catch (DBALException $e) {
                $output->writeln($e->getMessage());
                $return = 1; // indicate that an error occured
            } catch (Exception $e) {
                $output->writeln($e->getMessage());
                $return = 1; // indicate that an error occured
            }
        }

        return $return;
    }

    /**
     * Deletes records from the given table name and returns the number of
     * affected rows.
     *
     * @param string $table A table name
     * @param int $maxAge Age of last record access in seconds
     * @param int $maxCount Limit the query to only delete this number of records
     * @return int The number of rows affected by the last query
     * @throws DBALException When the query preparation goes wrong
     * @throws Exception When the query execution fails
     */
    protected function processTable(string $table, int $maxAge, int $maxCount): int
    {
        /* Get connection for table */
        $connection = $this->connectionPool->getConnectionForTable($table);

        /* Prepare basic statement */
        $sql = 'DELETE FROM ' . $table . ' WHERE deleted=1';

        if ($maxAge > 0) {
            /* Generate the interval timestamp */
            $sql .= ' AND crdate < ' . (time() - $maxAge);
        }

        if ($maxCount > 0) {
            $sql .= ' LIMIT ' . $maxCount;
        }

        try {
            $statement = $connection->prepare($sql);
        } catch (DBALException $e) {
            throw $e;
        }

        $result = $statement->execute();

        /* Throw exception when the execution fails */
        if ($result === false) {
            throw new Exception($statement->errorInfo());
        }

        return $statement->rowCount();
    }
}
