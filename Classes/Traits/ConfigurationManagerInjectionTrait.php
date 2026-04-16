<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

/**
 *
 */
trait ConfigurationManagerInjectionTrait
{
    protected ?ConfigurationManager $configurationManager = null;

    /**
     * TYPO3/Symfony DI auto injection.
     * @param ConfigurationManager $configurationManager A configuration manager instance
     * @return void
     */
    public function injectConfigurationManager(ConfigurationManager $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }
}
