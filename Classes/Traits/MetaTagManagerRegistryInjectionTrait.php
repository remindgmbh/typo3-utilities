<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;

trait MetaTagManagerRegistryInjectionTrait
{
    /**
     * A meta tag manager registry instance.
     *
     * @var MetaTagManagerRegistry|null
     */
    protected ?MetaTagManagerRegistry $metaTagManagerRegistry = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param MetaTagManagerRegistry $metaTagManagerRegistry A meta tag manager registry instance
     * @return void
     */
    public function injectMetaTagManagerRegistry(MetaTagManagerRegistry $metaTagManagerRegistry): void
    {
        $this->metaTagManagerRegistry = $metaTagManagerRegistry;
    }
}
