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
     * Directory separator of the media paths
     *
     * @var string
     */
    protected $_directorySeparator;

    /**
     * Indicates that the file paths are relative
     *
     * @var bool
     */
    protected $_withRelativePath;

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
     * Constructor
     */
    public function __construct()
    {
        $this->_directorySeparator  = '/';
        $this->_withRelativePath    = false;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        if (is_resource($this->_fileResource)) {
            fclose($this->_fileResource);
        }
    }

    /**
     * Set the directory separator
     *
     * @param   string      $separator      Separator
     */
    public function setDirectorySeparator($separator)
    {
        $this->_directorySeparator = $separator;
    }

    /**
     * Enable the relative path of the medias
     */
    public function enableRelativePath()
    {
        $this->_withRelativePath = true;
    }

    /**
     * Disable the relative path pf the medias
     */
    public function disableRelativePath()
    {
        $this->_withRelativePath = false;
    }

    /**
     * Set the target file path
     *
     * @param   string      $path           File path
     */
    public function setFilePath($path)
    {
        $this->_filePath = $path;
        $this->_fileResource = fopen($path, 'w');
    }

    /**
     * Close the writer
     */
    public function close()
    {
        if (is_resource($this->_fileResource)) {
            fclose($this->_fileResource);
        }
    }

    /**
     * Add content to the beginning of the target file
     *
     * @param   string      $content        Content
     */
    protected function _prepend($content)
    {
        fclose($this->_fileResource);

        $fileContent = file_get_contents($this->_filePath);
        file_put_contents($this->_filePath, $content . $fileContent);

        $this->_fileResource = fopen($this->_filePath, 'a');
    }

    /**
     * Add content to the end of the target file
     *
     * @param   string      $content        Content
     */
    protected function _append($content)
    {
        fseek($this->_fileResource, 0, SEEK_END);
        fwrite($this->_fileResource, $content);
    }

    /**
     * Get the media path
     *
     * @return  string                      Media path
     */
    protected function _getMediaPath($filePath)
    {
        $filePath               = realpath($filePath);
        $filePathArray          = explode('/', $filePath);

        // Return the absolute path
        if (!$this->_withRelativePath) {
            return implode($this->_directorySeparator, $filePathArray);
        }


        // Return the relative path
        $playlistPath           = realpath($this->_filePath);
        $playlistDirectory      = pathinfo($playlistPath, PATHINFO_DIRNAME);
        $playlistDirectoryArray = explode('/', $playlistDirectory);

        // Remove the common path
        while (!empty($filePathArray) && !empty($playlistDirectoryArray)) {
            if ($filePathArray[0] !== $playlistDirectoryArray[0]) {
                break;
            }
            array_shift($filePathArray);
            array_shift($playlistDirectoryArray);
        }

        // Create the relative path
        foreach ($playlistDirectoryArray as $directoryName) {
            array_unshift($filePathArray, '..');
        }
        return implode($this->_directorySeparator, $filePathArray);
    }
}
