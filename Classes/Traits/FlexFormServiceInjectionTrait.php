<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Core\Service\FlexFormService;

/**
 *
 */
trait FlexFormServiceInjectionTrait
{
    /**
     * A flex form service instance.
     *
     * @var FlexFormService
     */
    protected ?FlexFormService $flexformService = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param FlexFormService $flexFormService A flex form service instance
     * @return void
     */
    public function injectFlexFormService(FlexFormService $flexFormService): void
    {
        $this->flexformService = $flexFormService;
    }
}
