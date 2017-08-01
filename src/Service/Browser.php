<?php

/**
 * AnimeDb package.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\SmotretAnimeBrowserBundle\Service;

use GuzzleHttp\Client as HttpClient;

class Browser
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var ErrorDetector
     */
    private $detector;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $app_client;

    /**
     * @param HttpClient    $client
     * @param ErrorDetector $detector
     * @param string        $host
     * @param string        $prefix
     * @param string        $app_client
     */
    public function __construct(HttpClient $client, ErrorDetector $detector, $host, $prefix, $app_client)
    {
        $this->client = $client;
        $this->detector = $detector;
        $this->host = $host;
        $this->prefix = $prefix;
        $this->app_client = $app_client;
    }

    /**
     * @param string $path
     * @param array  $options
     *
     * @return array
     */
    public function get($path, array $options = [])
    {
        $options['headers'] = array_merge(
            ['User-Agent' => $this->app_client],
            isset($options['headers']) ? $options['headers'] : []
        );

        $response = $this->client->request('GET', $this->host.$this->prefix.$path, $options);

        return $this->detector->detect($response);
    }
}
