<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 *
 */
trait PageRepositoryInjectionTrait
{
    /**
     * A page repository instance.
     *
     * @var PageRepository
     */
    protected ?PageRepository $pageRepository = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param PageRepository $pageRepository A page repository instance.
     * @return void
     */
    public function injectPageRepository(PageRepository $pageRepository): void
    {
        $this->pageRepository = $pageRepository;
    }
}
