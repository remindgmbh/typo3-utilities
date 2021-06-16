<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

trait PersistenceManagerInjectionTrait
{
    /**
     * A persistence manager instance.
     *
     * @var PersistenceManager
     */
    protected ?PersistenceManager $persistenceManager = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param PersistenceManager $persistenceManager
     * @return void
     */
    public function injectPersistenceManager(PersistenceManager $persistenceManager): void
    {
        $this->persistenceManager = $persistenceManager;
    }
}
