<?php namespace Edcs\Grabby;

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
     * The name of the PhantomJS script used to generate screenshot.
     */
    const GRABBY_JS = 'grabby.js';

    /**
     * Creates a new Grabby instance.
     *
     * @param string $filename
     * @param string $storagePath
     * @param string $url
     */
    public function __construct($filename, $storagePath, $url)
    {
        $this->filename = $filename;
        $this->storagePath = $storagePath;
        $this->url = $url;
    }

    public function grab()
    {
        $this->phantomProcess()->setTimeout(10)->run();
    }

    /**
     * Get the PhantomJS Process instance.
     *
     * @return Process
     * @throws RuntimeException
     */
    private function phantomProcess()
    {
        $command = $this->getPhantomInstallation();

        var_dump($command . ' ' . self::GRABBY_JS . ' ' . $this->url);

        return new Process($command . ' ' . self::GRABBY_JS . ' ' . $this->url, __DIR__);
    }
}
