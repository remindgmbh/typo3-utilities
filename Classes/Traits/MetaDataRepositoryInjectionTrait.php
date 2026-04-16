<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Core\Resource\Index\MetaDataRepository;

trait MetaDataRepositoryInjectionTrait
{
    protected ?MetaDataRepository $metaDataRepository = null;

    /**
     * TYPO3/Symfony DI auto injection.
     * @param MetaDataRepository $metaDataRepository A meta data repository instance
     * @return void
     */
    public function injectMetaDataRepository(MetaDataRepository $metaDataRepository): void
    {
        $this->metaDataRepository = $metaDataRepository;
    }
}
