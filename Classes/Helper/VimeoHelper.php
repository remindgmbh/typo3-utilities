<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Helper;

use function array_filter;
use function array_values;
use function count;
use function explode;
use function parse_url;

/**
 * Description of VimeoHelper
 */
class VimeoHelper
{
    /**
     * @param string $url
     */
    public function parseVideoId(string $url): string
    {
        /* Initialize the video id return variable */
        $videoId = '';

        /* Get the path from the url */
        $path = parse_url($url, PHP_URL_PATH);

        /* If the path is not empty */
        if (!empty($path)) {
            /* Split path by delimiter */
            $segments = explode('/', $path);

            /* Function used for array_filter to delete empty valus */
            $filterFunction = fn($value) => $value !== null && $value !== '';

            /* Filter and reindex the array */
            $values = array_values(array_filter($segments, $filterFunction));

            /* For the most default case this is the correct path segment */
            $videoId = $values[0];

            /* Check the size of the path segments */
            $size = count($values);

            /* If it wasn't the default url format there are more segments */
            if ($size > 1) {
                /* The id is always in the last path segment */
                $videoId = $values[$size - 1];
            }
        }

        return '' . $videoId;
    }
}
