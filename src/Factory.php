<?php

namespace Edcs\Grabby;

use PhantomInstaller\PhantomBinary;
use RuntimeException;
use Symfony\Component\Process\Exception\ProcessFailedException;
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

    /**
     * An array containing cofiguration for PhantomJS.
     *
     * @var array
     */
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
    const GRABBY_JS = __DIR__.'/../grabby.js';

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
     *
     * @return string
     */
    public function setFilename($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array($extension, $this->allowedExtensions)) {
            return $this->filename = $filename;
        }

        throw new RuntimeException('Invalid file extension.');
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
     * Creates a screengrab of the given URL.
     *
     * @return Grab
     */
    public function grab()
    {
        $process = $this->phantomProcess();

        $process->setTimeout(self::TIMEOUT)->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return new Grab($this->storagePath, $this->filename);
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
