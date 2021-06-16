<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Traits;

use TYPO3\CMS\Extbase\Property\PropertyMapper;

trait PropertyMapperInjectionTrait
{
    /**
     * A property mapper instance.
     *
     * @var PropertyMapper
     */
    protected ?PropertyMapper $propertyMapper = null;

    /**
     * TYPO3/Symfony DI auto injection.
     *
     * @param PropertyMapper $propertyMapper
     * @return void
     */
    public function injectPropertyMapper(PropertyMapper $propertyMapper): void
    {
        $this->propertyMapper = $propertyMapper;
    }
}
