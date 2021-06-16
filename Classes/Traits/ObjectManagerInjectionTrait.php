<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Extbase\Object\ObjectManager;

trait ObjectManagerInjectionTrait
{
    /**
     * An object manager instance.
     *
     * @var ObjectManager
     */
    protected ?ObjectManager $objectManager = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param ObjectManager $objectManager
     * @return void
     */
    public function injectObjectManager(ObjectManager $objectManager): void
    {
        $this->objectManager = $objectManager;
    }
}
