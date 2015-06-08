<?php namespace Edcs\Grabby;

use RuntimeException;
use Symfony\Component\Process\Process;

class Factory
{
    use FindPhantomJs;

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

    /**
     * The width of the screengrab viewport.
     *
     * @var int
     */
    private $viewportWidth;

    /**
     * The height of the screengrab viewport.
     *
     * @var int
     */
    private $viewportHeight;

    /**
     * An array of allowed image types.
     *
     * @var array
     */
    private $allowedExtensions = [
        'png',
        'jpg',
        'pdf'
    ];

    /**
     * The name of the PhantomJS script used to generate screenshot.
     */
    const GRABBY_JS = 'grabby.js';

    /**
     * Creates a new Grabby instance.
     *
     * @param string $url
     * @param string $filename
     * @param string $storagePath
     * @param int $viewportWidth
     * @param int $viewportHeight
     */
    public function __construct(
        $url,
        $filename = 'grabby.png',
        $storagePath = __DIR__,
        $viewportWidth = 1920,
        $viewportHeight = 1080
    ) {
        $this->setFilename($filename);
        $this->setStoragePath($storagePath);

        $this->url = $url;
        $this->viewportWidth = $viewportWidth;
        $this->viewportHeight = $viewportHeight;
    }

    /**
     * Setter for filename property.
     *
     * @param string $filename
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
     * @throws RuntimeException
     */
    public function setStoragePath($storagePath)
    {
        $storagePath = rtrim($storagePath, '/') . '/';

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
        $this->phantomProcess()->setTimeout(10)->run();

        return $this;
    }

    /**
     * Returns the path of the generated screengrab.
     *
     * @return string
     */
    public function getScreengrabLocation()
    {
        return $this->storagePath . $this->filename;
    }

    /**
     * Returns the contents of the generated screengrab.
     *
     * @return string
     */
    public function getScreengrab()
    {
        return file_get_contents($this->getFullFilename());
    }

    /**
     * Get the PhantomJS Process instance.
     *
     * @return Process
     * @throws RuntimeException
     */
    protected function phantomProcess()
    {
        $phantom = $this->getPhantomInstallation();
        $command = $this->createPhantomCommand($phantom);

        return new Process($command);
    }

    /**
     * Creates the command string used to trigger PhantomJS.
     *
     * @param string command
     * @return string
     */
    protected function createPhantomCommand($phantomPath)
    {
        $command = [
            $phantomPath,
            self::GRABBY_JS,
            $this->url,
            $this->storagePath . $this->filename,
            $this->viewportWidth,
            $this->viewportHeight
        ];

        return implode(' ', $command);
    }
}
