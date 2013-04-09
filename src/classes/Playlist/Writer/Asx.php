<?php
/**
 * @package Playlist\Writer
 */
namespace Playlist\Writer;

/**
 * Writer of a playlist ASX
 */
class Asx extends WriterAbstract implements WriterInterface
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
        $this->_append('<asx version="3.0">' . "\n");
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
            $duration = $metadata->Duration;
        }
        if (isset($metadata->Artist)) {
            $artist = $metadata->Artist;
        }
        if (isset($metadata->Title)) {
            $title = $metadata->Title;
        }

        // Write the media informations
        $hours = floor($duration / (60 * 60));
        $minutes = ($duration / 60) % 60;
        $secondes = $duration % 60;
        $this->_append("    <entry>\n");
        $this->_append("        <title><![CDATA[$artist - $title]]></title>\n");
        $this->_append("        <ref href=\"$mediaPath\"/>\n");
        $this->_append("        <duration value=\"$hours:$minutes:$secondes.00\"/>\n");
        $this->_append("    </entry>\n");
    }

    /**
     * Close the writer
     */
    public function close()
    {
        // Write the footer
        $this->_append("</asx>");

        parent::close();
    }
}
