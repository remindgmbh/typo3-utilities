<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Helper;

use function preg_match;

/**
 * Description of YouTubeHelper
 */
class YouTubeHelper
{
    /**
     * @param string $url
     * @return string
     */
    public function parseVideoId(string $url): string
    {
        /* Initialize the video id return variable */
        $videoId = '';

        /* Define the regex pattern for matching all youtube urls */
        $pattern = '%'
            . '(?:youtube'
            . '(?:-nocookie)?'
            . '\.com\/'
            . '(?:[^/]+\/.+\/|(?:v|e(?:mbed)?)'
            . '\/|.*[?&]v=)|youtu\.be\/)'
            . '([^"&?/ ]{11})'
            . '%i';

        /* Initialize the matches array */
        $match = [];

        /* If the regex worked */
        if (preg_match($pattern, $url, $match)) {
            /* Assign the video id to the return varialbe */
            $videoId = $match[1] ?? '';
        }

        return (string) $videoId;
    }
}
