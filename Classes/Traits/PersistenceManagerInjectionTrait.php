<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

trait PersistenceManagerInjectionTrait
{
    protected ?PersistenceManager $persistenceManager = null;

    /**
     * TYPO3/Symfony DI auto injection.
     * @param PersistenceManager $persistenceManager A persistence manager instance
     * @return void
     */
    public function injectPersistenceManager(PersistenceManager $persistenceManager): void
    {
        $this->persistenceManager = $persistenceManager;
    }
}
