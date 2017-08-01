<?php

/**
 * AnimeDb package.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\SmotretAnimeBrowserBundle\Exception;

class ErrorException extends \RuntimeException
{
    /**
     * @param string $massage
     * @param int    $code
     *
     * @return ErrorException
     */
    public static function failed($massage, $code)
    {
        if ($massage) {
            return new self(sprintf('Server returned error "%s".', $massage), $code);
        } else {
            return new self('Server returned an error.', $code);
        }
    }

    /**
     * @param string $massage
     * @param int    $code
     *
     * @return ErrorException
     */
    public static function invalidResponse($massage, $code)
    {
        return new self(sprintf('Failed to parse response due to "%s" error.', $massage), $code);
    }
}
