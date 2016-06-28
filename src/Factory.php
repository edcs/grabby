<?php

namespace Edcs\Grabby;

use PhantomInstaller\PhantomBinary;
use RuntimeException;
use Symfony\Component\Process\Process;

class Factory
{
    /**
     * The name of the generated image file.
     *
     * @var string
     */
    private $filename;

    /**
     * The name of the path where the generated image file will be stored.
     *
     * @var string
     */
    private $storagePath;

    /**
     * The URL of the page which is going to be screen grabbed.
     *
     * @var string
     */
    private $url;

    private $config;

    /**
     * An array of allowed image types.
     *
     * @var array
     */
    private $allowedExtensions = [
        'png',
        'jpg',
        'pdf',
    ];

    /**
     * The name of the PhantomJS script used to generate screenshot.
     */
    const GRABBY_JS = 'grabby.js';

    /**
     * The number of seconds the PhantomJS should excecute for before failing.
     */
    const TIMEOUT = 120;

    /**
     * Creates a new Grabby instance.
     *
     * @param string $url
     * @param string $filename
     * @param string $storagePath
     * @param array  $config
     */
    public function __construct(
        $url,
        $filename = 'grabby.png',
        $storagePath = __DIR__,
        array $config = ['viewportSize' => ['width' => 1920, 'height' => 1080]]
    ) {
        $this->setFilename($filename);
        $this->setStoragePath($storagePath);

        $this->url = $url;
        $this->config = $config;
    }

    /**
     * Setter for filename property.
     *
     * @param string $filename
     *
     * @throws RuntimeException
     */
    public function setFilename($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array($extension, $this->allowedExtensions)) {
            $this->filename = $filename;
        } else {
            throw new RuntimeException('Invalid file extension.');
        }
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
     * Setter for storage path property.
     *
     * @param $storagePath
     *
     * @throws RuntimeException
     */
    public function setStoragePath($storagePath)
    {
        $storagePath = rtrim($storagePath, '/').'/';

        if (file_exists($storagePath)) {
            $this->storagePath = $storagePath;
        } else {
            throw new RuntimeException('Storage path doesn\'t seem to exist.');
        }
    }

    /**
     * Getter for storage path property.
     *
     * @return string
     */
    public function getStoragePath()
    {
        return $this->storagePath;
    }

    /**
     * Creates a screengrab of the given URL.
     *
     * @return Factory
     */
    public function grab()
    {
        $this->phantomProcess()->setTimeout(self::TIMEOUT)->run();

        return $this;
    }

    /**
     * Returns the path of the generated screengrab.
     *
     * @return string
     */
    public function getScreengrabLocation()
    {
        return $this->storagePath.$this->filename;
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

    /**
     * Get the PhantomJS Process instance.
     *
     * @throws RuntimeException
     *
     * @return Process
     */
    protected function phantomProcess()
    {
        $command = $this->createPhantomCommand();

        return new Process($command);
    }

    /**
     * Creates the command string used to trigger PhantomJS.
     *
     * @return string
     */
    protected function createPhantomCommand()
    {
        $command = [
            PhantomBinary::BIN,
            self::GRABBY_JS,
            $this->url,
            $this->storagePath.$this->filename,
            urlencode(json_encode($this->config)),
        ];

        return implode(' ', $command);
    }
}
