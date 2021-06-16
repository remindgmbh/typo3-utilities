<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * Description of PageRendererInjectionTrait
 */
trait PageRendererInjectionTrait
{
    /**
     * A page renderer instance.
     *
     * @var PageRenderer
     */
    protected ?PageRenderer $pageRenderer = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param PageRenderer $pageRenderer A page renderer instance.
     * @return void
     */
    public function injectPageRenderer(PageRenderer $pageRenderer): void
    {
        $this->pageRenderer = $pageRenderer;
    }
}
