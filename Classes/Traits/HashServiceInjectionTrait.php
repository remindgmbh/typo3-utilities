<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Extbase\Security\Cryptography\HashService;

trait HashServiceInjectionTrait
{
    /**
     * A hash service instance.
     *
     * @var HashService
     */
    protected ?HashService $hashService = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param HashService $hashService
     * @return void
     */
    public function injectHashService(HashService $hashService): void
    {
        $this->hashService = $hashService;
    }
}
