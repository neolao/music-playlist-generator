<?php
/**
 * @package Playlist\Util
 */
namespace Playlist\Util;

/**
 * Class utility to work with the file system
 */
class FileSystem
{
    /**
     * Recurvise glob (see glob function)
     *
     * @param   string  $pattern    The file pattern
     * @param   string  $path       The base path
     * @return  array               File list matching the pattern
     */
    public static function rglob($pattern, $path)
    {
        $paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
        $files = glob($path.$pattern, GLOB_MARK|GLOB_BRACE);
        foreach ($paths as $path) {
            $files = array_merge($files, self::rglob($pattern, $path));
        }
        return $files;
    }
}

