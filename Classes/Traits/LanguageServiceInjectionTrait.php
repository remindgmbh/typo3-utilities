<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Lang\LanguageService;

trait LanguageServiceInjectionTrait
{
    protected ?LanguageService $languageService = null;

    /**
     * TYPO3/Symfony DI auto injection.
     * @param LanguageService $languageService A language service instance
     * @return void
     */
    public function injectLanguageService(LanguageService $languageService): void
    {
        $this->languageService = $languageService;
    }
}
