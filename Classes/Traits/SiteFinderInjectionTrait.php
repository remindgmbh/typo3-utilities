<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Core\Site\SiteFinder;

/**
 * Implements the Symfony DI auto-injection for the TYPO3 SiteFinder.
 */
trait SiteFinderInjectionTrait
{
    protected ?SiteFinder $siteFinder = null;

    /**
     * TYPO3/Symfony DI auto injection.
     * @param SiteFinder $siteFinder The SiteFinder instance.
     * @return void
     */
    public function injectSiteFinder(SiteFinder $siteFinder): void
    {
        $this->siteFinder = $siteFinder;
    }
}
