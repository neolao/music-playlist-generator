<?php
/**
 * @package Playlist\Writer
 */
namespace Playlist\Writer;

/**
 * Writer of a playlist m3u8
 */
class M3u8 extends WriterAbstract implements WriterInterface
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
        parent::setFilePath($path);

        fwrite($this->_fileResource, "#EXTM3U\n");
    }

    /**
     * Add a file
     *
     * @param   string      $filePath       File path
     * @param   stdClass    $metadata       File metadata
     */
    public function addFile($filePath, $metadata)
    {
        $duration   = 0;
        $artist     = '';
        $title      = '';

        if (isset($metadata->Duration)) {
            $duration = $metadata->Duration;
        }
        if (isset($metadata->Artist)) {
            $artist = $metadata->Artist;
        }
        if (isset($metadata->Title)) {
            $title = $metadata->Title;
        }

        fwrite($this->_fileResource, "#EXTINF:$duration,$artist - $title\n");
        fwrite($this->_fileResource, "$filePath\n");
    }
}
