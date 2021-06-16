<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Tests\Unit\Helper;

use Remind\RmndUtil\Helper\VimeoHelper;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Description of VimeoHelperTest
 *  https://vimeo.com/11111111?param=test
 *  http://vimeo.com/11111111?param=test
 */
final class VimeoHelperTest extends UnitTestCase
{
    public function testEmptyStringResultsInEmptyReturn(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEmpty($vimeo->parseVideoId(''));
    }

    public function testUrlWithHttpsAndNoWww(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('https://vimeo.com/12345678'));
    }

    public function testUrlWithHttpsAndNoWwwWithTrailingSlash(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('https://vimeo.com/12345678/'));
    }

    public function testUrlWithHttpAndNoWww(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('http://vimeo.com/12345678'));
    }

    public function testUrlWithHttpAndNoWwwWithTrailingSlash(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('http://vimeo.com/12345678/'));
    }

    public function testUrlWithHttpsAndWww(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('https://www.vimeo.com/12345678'));
    }

    public function testUrlWithHttpsAndWwwWithTrailingSlash(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('https://www.vimeo.com/12345678/'));
    }

    public function testUrlWithHttpAndWww(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('http://www.vimeo.com/12345678'));
    }

    public function testUrlWithHttpAndWwwWithTrailingSlash(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('http://www.vimeo.com/12345678/'));
    }

    public function testChannelUrlWithHttpsAndNoWww(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('https://vimeo.com/channels/12345678'));
    }

    public function testChannelUrlWithHttpsAndNoWwwWithTrailingSlash(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('https://vimeo.com/channels/12345678/'));
    }

    public function testChannelUrlWithHttpAndNoWww(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('http://vimeo.com/channels/12345678'));
    }

    public function testChannelUrlWithHttpAndNoWwwWithTrailingSlash(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('http://vimeo.com/channels/12345678/'));
    }

    public function testGroupUrlWithHttpsAndNoWww(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('https://vimeo.com/groups/name/videos/12345678'));
    }

    public function testGroupUrlWithHttpsAndNoWwwWithTrailingSlash(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('https://vimeo.com/groups/name/videos/12345678/'));
    }

    public function testGroupUrlWithHttpAndNoWww(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('http://vimeo.com/groups/name/videos/12345678'));
    }

    public function testGroupUrlWithHttpAndNoWwwWithTrailingSlash(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('http://vimeo.com/groups/name/videos/12345678/'));
    }

    public function testAlbumUrlWithHttpsAndNoWww(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('https://vimeo.com/album/2222222/video/12345678'));
    }

    public function testAlbumUrlWithHttpsAndNoWwwWithTrailingSlash(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('https://vimeo.com/album/2222222/video/12345678/'));
    }

    public function testAlbumUrlWithHttpAndNoWww(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('http://vimeo.com/album/2222222/video/12345678'));
    }

    public function testAlbumUrlWithHttpAndNoWwwWithTrailingSlash(): void
    {
        $vimeo = new VimeoHelper();

        $this->assertEquals('12345678', $vimeo->parseVideoId('http://vimeo.com/album/2222222/video/12345678/'));
    }
}
