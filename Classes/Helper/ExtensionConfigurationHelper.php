<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Helper;

use function is_array;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * An ExtensionConfiguration API wrapper.
 */
class ExtensionConfigurationHelper
{
    use LoggerAwareTrait;

    /**
     * Wrapper function to acces the ExtensionConfiguration API.
     * Returns the requested configuration value as an array. It will wrap a
     * non array value in an array where the returned value is at key [0].
     *
     * @param string $extensionKey The extension e.g. `my_extension`
     * @param string $path Some value inside the extension config `myvalue`
     * @return array The extension configuration or wrapped value
     */
    public function get(string $extensionKey, string $path = ''): array
    {
        try {
            $config = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get($extensionKey, $path);
        } catch (ExtensionConfigurationExtensionNotConfiguredException $e) {
            $this->logger->warning($e->getMessage(), [ 'extensionKey' => $extensionKey, 'path' => $path ]);

            return [];
        } catch (ExtensionConfigurationPathDoesNotExistException $e) {
            $this->logger->warning($e->getMessage(), [ 'extensionKey' => $extensionKey, 'path' => $path ]);

            return [];
        }

        if (!is_array($config)) {
            return [ $config ];
        }

        return $config;
    }
}
