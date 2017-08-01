<?php

/**
 * AnimeDb package.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\SmotretAnimeBrowserBundle\Service;

use AnimeDb\Bundle\SmotretAnimeBrowserBundle\Exception\ErrorException;
use AnimeDb\Bundle\SmotretAnimeBrowserBundle\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;

class ErrorDetector
{
    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    public function detect(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 404) {
            throw NotFoundException::page();
        }

        $content = $response->getBody()->getContents();

        // http://smotret-anime.ru/api/episodes/100000000000
        if ($content == '') {
            throw NotFoundException::page();
        }

        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw ErrorException::invalidResponse(json_last_error_msg(), json_last_error());
        }

        if (isset($data['error'])) {
            $code = isset($data['error']['code']) ? $data['error']['code'] : 0;
            if ($code == 404) {
                throw NotFoundException::page();
            } else {
                throw ErrorException::failed(
                    isset($data['error']['message']) ? $data['error']['message'] : '',
                    $code
                );
            }
        }

        return (array) $data;
    }
}
