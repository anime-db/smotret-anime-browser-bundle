<?php

/**
 * AnimeDb package.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\SmotretAnimeBrowserBundle\Tests\Service;

use AnimeDb\Bundle\SmotretAnimeBrowserBundle\Service\Browser;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class BrowserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $host = 'example.org';

    /**
     * @var string
     */
    private $prefix = '/api/';

    /**
     * @var string
     */
    private $app_client = 'My Custom Bot 1.0';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|HttpClient
     */
    private $client;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|StreamInterface
     */
    private $stream;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|MessageInterface
     */
    private $message;

    /**
     * @var Browser
     */
    private $browser;

    protected function setUp()
    {
        $this->client = $this->getMock(HttpClient::class);
        $this->stream = $this->getMock(StreamInterface::class);
        $this->message = $this->getMock(MessageInterface::class);

        $this->browser = new Browser($this->client, $this->host, $this->prefix, $this->app_client);
    }

    public function testGet()
    {
        $path = '/foo';
        $params = ['bar' => 'baz'];
        $options = $params + [
            'headers' => [
                'User-Agent' => $this->app_client,
            ],
        ];
        $expected = ['Hello, world!'];
        $content = json_encode($expected);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->will($this->returnValue($content))
        ;

        $this->message
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($this->stream))
        ;

        $this->client
            ->expects($this->once())
            ->method('request')
            ->with('GET', $this->host.$this->prefix.$path, $options)
            ->will($this->returnValue($this->message))
        ;

        $this->assertEquals($expected, $this->browser->get($path, $params));
    }
}
