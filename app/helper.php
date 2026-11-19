<?php

declare(strict_types=1);

use Illuminate\Support\Collection;

if (!function_exists('env')) {
    /**
     * Get an environment variable (from the real environment or .env) or return default.
     * Empty values are treated as not set.
     */
    function env(string $varName, mixed $default = null): mixed
    {
        $value = $_ENV[$varName] ?? $_SERVER[$varName] ?? getenv($varName);
        $isSet = $value !== false && $value !== null && $value !== '';
        throw_when(!$isSet && $default === null, "{$varName} is not a defined .env variable and has no default value");
        return $isSet ? $value : $default;
    }
}


if (!function_exists('throw_when')) {
    /**
     * Throw an exception on a specific condition
     * 
     * @param bool $condition
     * @param string $message
     * @param string $exception
     * 
     * @throws Exception
     */
    function throw_when(bool $condition, string $message, string $exception = Exception::class): void
    {
        if (!$condition) return;

        throw new $exception($message);
    }
}

if (!function_exists('base_path')) {
    /**
     * Return absolute path
     * 
     * @param string $path
     * 
     */
    function base_path(string $path = ''): string
    {
        return dirname(__DIR__) . ($path === '' ? '' : "/{$path}");
    }
}

if (!function_exists('collect')) {
    /**
     * Get a new collection with array items
     */
    function collect($items)
    {
        return new Collection($items);
    }
}

/**
 * String functions
 */

if (!function_exists('str_after')) {

    function str_after($str, $search)
    {
        return $search === '' ? $str : array_reverse(explode($search, $str, 2))[0];
    }
}

if (!function_exists('str_after_last')) {
    function str_after_last($str, $search)
    {
        if ($search === '') {
            return $str;
        }

        $position = strrpos($str, (string) $search);

        if ($position === false) {
            return $str;
        }

        return mb_substr($str, $position + strlen($search), NULL, 'UTF-8');
    }
}

if (!function_exists('str_before')) {
    function str_before($str, $search)
    {
        return $search === '' ? $str : explode($search, $str)[0];
    }
}

if (!function_exists('str_before_last')) {
    function str_before_last($str, $search)
    {
        if ($search === '') {
            return $str;
        }

        $pos = mb_strrpos($str, $search);

        if ($pos === false) {
            return $str;
        }

        return mb_substr($str, 0, $pos, 'UTF-8');
    }
}

if (!function_exists('str_between')) {
    function str_between($str, $from, $to)
    {
        if ($from === '' || $to === '') {
            return $str;
        }

        return str_before_last(str_after($str, $from), $to);
    }
}
