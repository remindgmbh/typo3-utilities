<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

/**
 *
 */
trait ConfigurationManagerInjectionTrait
{
    /**
     * A configuration manager instance.
     *
     * @var ConfigurationManager|null
     */
    protected ?ConfigurationManager $configurationManager = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param ConfigurationManager $configurationManager
     * @return void
     */
    public function injectConfigurationManager(ConfigurationManager $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }
}
