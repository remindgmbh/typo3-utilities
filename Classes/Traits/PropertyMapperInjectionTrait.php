<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Extbase\Property\PropertyMapper;

trait PropertyMapperInjectionTrait
{
    protected ?PropertyMapper $propertyMapper = null;

    /**
     * TYPO3/Symfony DI auto injection.
     * @param PropertyMapper $propertyMapper A property mapper instance
     * @return void
     */
    public function injectPropertyMapper(PropertyMapper $propertyMapper): void
    {
        $this->propertyMapper = $propertyMapper;
    }
}
