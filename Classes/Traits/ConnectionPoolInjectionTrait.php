<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 *
 */
trait ConnectionPoolInjectionTrait
{
    /**
     * A connection pool instance.
     *
     * @var ConnectionPool
     */
    protected ?ConnectionPool $connectionPool = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param ConnectionPool $connectionPool A connection pool instance
     * @return void
     */
    public function injectConnectionPool(ConnectionPool $connectionPool): void
    {
        $this->connectionPool = $connectionPool;
    }
}
