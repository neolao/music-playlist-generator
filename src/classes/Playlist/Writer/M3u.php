<?php
/**
 * @package Playlist\Writer
 */
namespace Playlist\Writer;

/**
 * Writer of a playlist M3U
 */
class M3u extends WriterAbstract implements WriterInterface
{
    /**
     * Set the target file path
     *
     * @param   string      $path           File path
     */
    public function setFilePath($path)
    {
        parent::setFilePath($path);

        // Write the header
        $this->_append("#EXTM3U\n");
    }

    /**
     * Add a file
     *
     * @param   string      $filePath       File path
     * @param   stdClass    $metadata       File metadata
     */
    public function addFile($filePath, $metadata)
    {
        $duration   = -1;
        $artist     = '';
        $title      = '';
        $mediaPath  = $this->_getMediaPath($filePath);

        // Get the metadatas
        if (isset($metadata->Duration)) {
            $duration = $metadata->Duration;
        }
        if (isset($metadata->Artist)) {
            $artist = utf8_decode($metadata->Artist);
        }
        if (isset($metadata->Title)) {
            $title = utf8_decode($metadata->Title);
        }

        // Write the media informations
        $this->_append("#EXTINF:$duration,$artist - $title\n");
        $this->_append("$mediaPath\n");
    }
}
