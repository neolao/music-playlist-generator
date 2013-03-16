<?php
/**
 * @package Playlist\Writer
 */
namespace Playlist\Writer;

/**
 * Abstract writer
 */
abstract class WriterAbstract
{
    /**
     * Target file path
     *
     * @var string
     */
    protected $_filePath;

    /**
     * Target file resource
     *
     * @var resource
     */
    protected $_fileResource;

    /**
     * Destructor
     */
    public function __destruct()
    {
        fclose($this->_fileResource);
    }

    /**
     * Set the target file path
     *
     * @param   string      $path           File path
     */
    public function setFilePath($path)
    {
        $this->_filePath = $path;
        $this->_fileResource = fopen($path, 'w+');
    }

    /**
     * Append content to the target file
     *
     * @param   string      $content        Content
     */
    protected function _append($content)
    {
        fwrite($this->_fileResource, $content);
    }
}
