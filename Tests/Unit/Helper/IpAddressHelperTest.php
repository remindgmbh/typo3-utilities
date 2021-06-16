<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Tests\Unit\Helper;

use Remind\RmndUtil\Helper\IpAddressHelper;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Description of IpAddressHelperTest
 */
final class IpAddressHelperTest extends UnitTestCase
{
    public function testReturnsEmptyIpAddressWithoutWebContext(): void
    {
        $ip = new IpAddressHelper();

        $this->assertEquals('', $ip->getRemoteAddr());
    }

    public function testReturnsIpForHostname(): void
    {
        $ip = new IpAddressHelper();

        $this->assertContains($ip->getIpByHostname('one.one.one.one'), ['1.1.1.1', '1.0.0.1']);
    }
}
