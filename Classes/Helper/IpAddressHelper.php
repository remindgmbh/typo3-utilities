<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Helper;

use function filter_input;
use function gethostbyname;

use const INPUT_SERVER;

/**
 * Description of IpAddressHelper
 */
class IpAddressHelper
{
    /**
     *
     * @return string
     */
    public function getRemoteAddr(): string
    {
        $address = filter_input(INPUT_SERVER, 'REMOTE_ADDR') ?? '';

        if (!empty(filter_input(INPUT_SERVER, 'TYPO3_DB'))) {
            $address = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP') ?? '';
        } elseif (!empty(filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR'))) {
            $address = filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR') ?? '';
        }

        return $address;
    }

    /**
     *
     * @param string $name
     * @return string
     */
    public function getIpByHostname(string $name): string
    {
        return gethostbyname($name) ?? '';
    }
}
