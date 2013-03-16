<?php
/**
 * @package Playlist\Writer
 */
namespace Playlist\Writer;

/**
 * Interface of a writer
 */
interface WriterInterface
{
    /**
     * Set the directory separator
     *
     * @param   string      $separator      Separator
     */
    function setDirectorySeparator($separator);

    /**
     * Enable the relative path of the medias
     */
    function enableRelativePath();

    /**
     * Disable the relative path pf the medias
     */
    function disableRelativePath();

    /**
     * Set the target file path
     *
     * @param   string      $path           File path
     */
    function setFilePath($path);

    /**
     * Add a file
     *
     * @param   string      $filePath       File path
     * @param   stdClass    $metadata       File metadata
     */
    function addFile($filePath, $metadata);
}
