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
use AnimeDb\Bundle\SmotretAnimeBrowserBundle\Service\ErrorDetector;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

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
     * @var \PHPUnit_Framework_MockObject_MockObject|ErrorDetector
     */
    private $detector;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ResponseInterface
     */
    private $response;

    /**
     * @var Browser
     */
    private $browser;

    protected function setUp()
    {
        $this->client = $this->getMock(HttpClient::class);
        $this->detector = $this->getMock(ErrorDetector::class);
        $this->response = $this->getMock(ResponseInterface::class);

        $this->browser = new Browser($this->client, $this->detector, $this->host, $this->prefix, $this->app_client);
    }

    /**
     * @return array
     */
    public function appClients()
    {
        return [
            [''],
            ['Override User Agent'],
        ];
    }

    /**
     * @dataProvider appClients
     *
     * @param string $app_client
     */
    public function testGet($app_client)
    {
        $path = '/foo';
        $params = ['bar' => 'baz'];
        $options = $params + [
            'headers' => [
                'User-Agent' => $this->app_client,
            ],
        ];

        if ($app_client) {
            $options['headers']['User-Agent'] = $app_client;
            $params['headers']['User-Agent'] = $app_client;
        }

        $data = ['Hello, world!'];

        $this->client
            ->expects($this->once())
            ->method('request')
            ->with('GET', $this->host.$this->prefix.$path, $options)
            ->will($this->returnValue($this->response))
        ;

        $this->detector
            ->expects($this->once())
            ->method('detect')
            ->with($this->response)
            ->will($this->returnValue($data))
        ;

        $this->assertEquals($data, $this->browser->get($path, $params));
    }
}
