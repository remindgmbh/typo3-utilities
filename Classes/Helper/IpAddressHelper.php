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
        $address = isset($_SERVER['REMOTE_ADDR']) ? filter_var($_SERVER['REMOTE_ADDR']) : '';

        if (!empty($_SERVER['TYPO3_DB'])) {
            $address = isset($_SERVER['HTTP_CLIENT_IP']) ? filter_var($_SERVER['HTTP_CLIENT_IP']) : '';
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $address = filter_var($_SERVER['HTTP_X_FORWARDED_FOR']) ?? '';
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
