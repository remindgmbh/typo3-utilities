<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 *
 */
trait DispatcherInjectionTrait
{
    /**
     * A dispatcher instance.
     *
     * @var Dispatcher
     */
    protected ?Dispatcher $dispatcher = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param Dispatcher $dispatcher A dispatcher instance
     * @return void
     */
    public function injectDispatcher(Dispatcher $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
    }
}
