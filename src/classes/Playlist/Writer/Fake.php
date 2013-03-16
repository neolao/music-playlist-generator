<?php
/**
 * @package Playlist\Writer
 */
namespace Playlist\Writer;

/**
 * Fake writer
 */
class Fake extends WriterAbstract implements WriterInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Set the target file path
     *
     * @param   string      $path           File path
     */
    public function setFilePath($path)
    {
    }

    /**
     * Add a file
     *
     * @param   string      $filePath       File path
     * @param   stdClass    $metadata       File metadata
     */
    public function addFile($filePath, $metadata)
    {
    }
}
