<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Core\Resource\Index\MetaDataRepository;

trait MetaDataRepositoryInjectionTrait
{
    /**
     * A meta data repository instance.
     *
     * @var MetaDataRepository|null
     */
    protected ?MetaDataRepository $metaDataRepository = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param MetaDataRepository $metaDataRepository
     * @return void
     */
    public function injectMetaDataRepository(MetaDataRepository $metaDataRepository): void
    {
        $this->metaDataRepository = $metaDataRepository;
    }
}
