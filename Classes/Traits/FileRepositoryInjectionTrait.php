<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Core\Resource\FileRepository;

trait FileRepositoryInjectionTrait
{
    protected ?FileRepository $fileRepository = null;

    /**
     * TYPO3/Symfony DI auto injection.
     * @param FileRepository $fileRepository A file repository instance
     * @return void
     */
    public function injectFileRepository(FileRepository $fileRepository): void
    {
        $this->fileRepository = $fileRepository;
    }
}
