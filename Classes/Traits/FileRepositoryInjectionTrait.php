<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Core\Resource\FileRepository;

trait FileRepositoryInjectionTrait
{
    /**
     * A file repository instance.
     *
     * @var FileRepository|null
     */
    protected ?FileRepository $fileRepository = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param FileRepository $fileRepository
     * @return void
     */
    public function injectFileRepository(FileRepository $fileRepository): void
    {
        $this->fileRepository = $fileRepository;
    }
}
