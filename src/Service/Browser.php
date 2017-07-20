<?php

/**
 * AnimeDb package.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\SmotretAnimeBrowserBundle\Service;

use GuzzleHttp\Client;

class Browser
{
    /**
     * @var Client
     */
    private $client;

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
     * @param Client $client
     * @param string $host
     * @param string $prefix
     * @param string $app_client
     */
    public function __construct(Client $client, $host, $prefix, $app_client)
    {
        $this->client = $client;
        $this->host = $host;
        $this->prefix = $prefix;
        $this->app_client = $app_client;
    }

    /**
     * @param string $path
     * @param array  $options
     *
     * @return string
     */
    public function get($path, array $options = [])
    {
        $options['headers'] = isset($options['headers']) ? $options['headers'] : [];
        $options['headers']['User-Agent'] = $this->app_client;

        $response = $this->client->request('GET', $this->host.$this->prefix.$path, $options);

        $content = $response->getBody()->getContents();

        return json_decode($content, true);
    }
}
