<?php
/**
 * @package Playlist\Writer
 */
namespace Playlist\Writer;

/**
 * Writer of a playlist PLS
 */
class Pls extends WriterAbstract implements WriterInterface
{
    /**
     * File count
     *
     * @var int
     */
    protected $_fileCount = 0;

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
        $fileIndex  = $this->_fileCount + 1;

        // Get the metadatas
        if (isset($metadata->Duration)) {
            $duration = $metadata->Duration;
        }
        if (isset($metadata->Artist)) {
            $artist = $metadata->Artist;
        }
        if (isset($metadata->Title)) {
            $title = $metadata->Title;
        }

        // Write the media informations
        $this->_append("File$fileIndex=$mediaPath\n");
        $this->_append("Title$fileIndex=$artist - $title\n");
        $this->_append("Length$fileIndex=$duration\n");
        $this->_append("\n");

        // Increase the file count
        $this->_fileCount++;
    }

    /**
     * Close the writer
     */
    public function close()
    {
        // Write the header
        $this->_prepend("[playlist]\nNumberOfEntries=" . $this->_fileCount . "\n\n");

        // Write the footer
        $this->_append("Version=2");

        parent::close();
    }
}
