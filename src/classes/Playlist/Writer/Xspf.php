<?php
/**
 * @package Playlist\Writer
 */
namespace Playlist\Writer;

/**
 * Writer of a playlist XSPF
 */
class Xspf extends WriterAbstract implements WriterInterface
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
        $this->_append('<?xml version="1.0" encoding="UTF-8"?' . ">\n");
        $this->_append('<playlist version="1" xmlns="http://xspf.org/ns/0/">' . "\n");
        $this->_append('    <trackList>' . "\n");
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
        $mediaPath  = $this->_getMediaPath($filePath);

        // Get the metadatas
        if (isset($metadata->Duration)) {
            $duration = $metadata->Duration * 1000; // Milliseconds
        }
        if (isset($metadata->Artist)) {
            $artist = $metadata->Artist;
        }
        if (isset($metadata->Title)) {
            $title = $metadata->Title;
        }

        // Write the media informations
        $this->_append("        <track>\n");
        $this->_append("            <location><![CDATA[$mediaPath]]></location>\n");
        $this->_append("            <title><![CDATA[$artist - $title]]></title>\n");
        $this->_append("            <duration>$duration</duration>\n");
        $this->_append("        </track>\n");
    }

    /**
     * Close the writer
     */
    public function close()
    {
        // Write the footer
        $this->_append("    </tracklist>\n");
        $this->_append("</playlist>");

        parent::close();
    }
}
