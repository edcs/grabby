<?php

namespace Edcs\Grabby;

class Grab
{
    /**
     * The path where the screengrab was stored.
     *
     * @var string
     */
    private $storagePath;

    /**
     * The name of the file containing the screengrab.
     *
     * @var string
     */
    private $filename;

    /**
     * Grab constructor.
     *
     * @param string $storagePath
     * @param string $filename
     */
    public function __construct($storagePath, $filename)
    {
        $this->storagePath = $storagePath;
        $this->filename = $filename;
    }

    /**
     * Getter for filename property.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Getter for storage path property.
     *
     * @return string
     */
    public function getStoragePath()
    {
        return rtrim($this->storagePath, '/').'/';
    }

    /**
     * Returns the path of the generated screengrab.
     *
     * @return string
     */
    public function getScreengrabLocation()
    {
        return $this->getStoragePath().$this->getFilename();
    }

    /**
     * Returns the contents of the generated screengrab.
     *
     * @return string
     */
    public function getScreengrab()
    {
        return file_get_contents($this->getScreengrabLocation());
    }
}
