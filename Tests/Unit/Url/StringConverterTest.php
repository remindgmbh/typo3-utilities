<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Tests\Unit\Url;

use Remind\RmndUtil\Url\StringConverter;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Description of StringConverterTest
 */
final class StringConverterTest extends UnitTestCase
{
    public function testInputGeneratesCorrectUrl(): void
    {
        $subject = new StringConverter();

        $out = $subject->urlize('Soylent grün ist menschenfleisch / äöü');

        $this->assertEquals('soylent-gruen-ist-menschenfleisch--aeoeue', $out);
    }
}
