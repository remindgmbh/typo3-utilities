<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Tests\Unit\Helper;

use Remind\RmndUtil\Helper\YouTubeHelper;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Description of YouTubeHelperTest
 */
final class YouTubeHelperTest extends UnitTestCase
{
    /**
     *
     * @return void
     */
    public function testCompleteUrlWithArguments(): void
    {
        $url = 'https://www.youtube.com/watch?v=DFYRQ_zQ-gk&feature=featured';

        $subject = new YouTubeHelper();
        $this->assertEquals('DFYRQ_zQ-gk', $subject->parseVideoId($url));
    }

    public function testCompleteUrlWithoutArguments(): void
    {
        $url = 'https://www.youtube.com/watch?v=DFYRQ_zQ-gk';

        $subject = new YouTubeHelper();
        $this->assertEquals('DFYRQ_zQ-gk', $subject->parseVideoId($url));
    }

    public function testCompleteHttpUrlWithoutArguments(): void
    {
        $url = 'http://www.youtube.com/watch?v=DFYRQ_zQ-gk';

        $subject = new YouTubeHelper();
        $this->assertEquals('DFYRQ_zQ-gk', $subject->parseVideoId($url));
    }

    public function testProtocolNeutralUrlWithoutArguments(): void
    {
        $url = '//www.youtube.com/watch?v=DFYRQ_zQ-gk';

        $subject = new YouTubeHelper();
        $this->assertEquals('DFYRQ_zQ-gk', $subject->parseVideoId($url));
    }

    public function testInvalidWwwOnlyUrlWithoutArguments(): void
    {
        $url = 'www.youtube.com/watch?v=DFYRQ_zQ-gk';

        $subject = new YouTubeHelper();
        $this->assertEquals('DFYRQ_zQ-gk', $subject->parseVideoId($url));
    }

    public function testUrlWithoutWwwAndArguments(): void
    {
        $url = 'https://youtube.com/watch?v=DFYRQ_zQ-gk';

        $subject = new YouTubeHelper();
        $this->assertEquals('DFYRQ_zQ-gk', $subject->parseVideoId($url));
    }

    public function testUrlWithoutWwwAndSslAndArguments(): void
    {
        $url = 'http://youtube.com/watch?v=DFYRQ_zQ-gk';

        $subject = new YouTubeHelper();
        $this->assertEquals('DFYRQ_zQ-gk', $subject->parseVideoId($url));
    }

    public function tesProtocolNeutralUrlWithoudWwwAndArguments(): void
    {
        $url = '//youtube.com/watch?v=DFYRQ_zQ-gk';

        $subject = new YouTubeHelper();
        $this->assertEquals('DFYRQ_zQ-gk', $subject->parseVideoId($url));
    }

    public function testUrlWithoutProtocolAndWwwAndArguments(): void
    {
        $url = 'youtube.com/watch?v=DFYRQ_zQ-gk';

        $subject = new YouTubeHelper();
        $this->assertEquals('DFYRQ_zQ-gk', $subject->parseVideoId($url));
    }

    /*
    Further test Urls:

    https://m.youtube.com/watch?v=DFYRQ_zQ-gk
    http://m.youtube.com/watch?v=DFYRQ_zQ-gk
    //m.youtube.com/watch?v=DFYRQ_zQ-gk
    m.youtube.com/watch?v=DFYRQ_zQ-gk

    https://www.youtube.com/v/DFYRQ_zQ-gk?fs=1&hl=en_US
    http://www.youtube.com/v/DFYRQ_zQ-gk?fs=1&hl=en_US
    //www.youtube.com/v/DFYRQ_zQ-gk?fs=1&hl=en_US
    www.youtube.com/v/DFYRQ_zQ-gk?fs=1&hl=en_US
    youtube.com/v/DFYRQ_zQ-gk?fs=1&hl=en_US

    https://www.youtube.com/embed/DFYRQ_zQ-gk?autoplay=1
    https://www.youtube.com/embed/DFYRQ_zQ-gk
    http://www.youtube.com/embed/DFYRQ_zQ-gk
    //www.youtube.com/embed/DFYRQ_zQ-gk
    www.youtube.com/embed/DFYRQ_zQ-gk
    https://youtube.com/embed/DFYRQ_zQ-gk
    http://youtube.com/embed/DFYRQ_zQ-gk
    //youtube.com/embed/DFYRQ_zQ-gk
    youtube.com/embed/DFYRQ_zQ-gk

    https://youtu.be/DFYRQ_zQ-gk?t=120
    https://youtu.be/DFYRQ_zQ-gk
    http://youtu.be/DFYRQ_zQ-gk
    //youtu.be/DFYRQ_zQ-gk
    youtu.be/DFYRQ_zQ-gk
    */
}
