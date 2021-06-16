<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Url;

use function preg_replace;
use function str_replace;
use function strtolower;

/**
 * Description of StringConverter
 */
class StringConverter
{
    /**
     * Makes the given string url compatible by replacing non-valid characters.
     *
     * @param string $input An input string to use as the url
     * @return string
     */
    public function urlize(string $input): string
    {
        /* Replace chars */
        $replaced = str_replace([' ', 'ä', 'ö', 'ü'], ['-', 'ae', 'oe', 'ue'], $input);

        /* Lowercase text */
        $lowered = strtolower($replaced);

        // Removes special chars.
        $result = preg_replace('/[^A-Za-z0-9\-]/', '', $lowered);

        /* Final test for return value on error */
        return $result === null ? '' : $result;
    }
}
