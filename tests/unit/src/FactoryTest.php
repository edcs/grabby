<?php

namespace Edcs\Grabby\Tests;

use Edcs\Grabby\Factory;
use PHPUnit_Framework_TestCase;
use RuntimeException;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    const OUTPUT = __DIR__.'/../../output/';

    /**
     * Makes sure Grabby can be instatiated.
     *
     * @return void
     */
    public function testFactoryCanBeConstructed()
    {
        $grabby = new Factory('https://httpbin.org/user-agent');

        $this->assertInstanceOf(Factory::class, $grabby);
    }

    /**
     * Makes sure Grabby accepts valid file extesions.
     *
     * @return void
     */
    public function testValidFilenameIsAccepted()
    {
        $grabby = new Factory('https://httpbin.org/user-agent', 'grabby.jpg');

        $this->assertEquals('grabby.jpg', $grabby->getFilename());
    }

    /**
     * Makes sure Grabby throws an exception if an invalid file extention is used.
     *
     * @expectedException RuntimeException
     *
     * @return void
     */
    public function testInvalidFilenameIsRejected()
    {
        new Factory('https://httpbin.org/user-agent', 'grabby.fail');
    }

    /**
     * Makes sure Grabby accepts valid directories.
     *
     * @return void
     */
    public function testValidPathIsAccepted()
    {
        $dir = rtrim(__DIR__, '/').'/';

        $grabby = new Factory('https://httpbin.org/user-agent', 'grabby.png', $dir);

        $this->assertEquals($dir, $grabby->getStoragePath());
    }

    /**
     * Makes sure Grabby throws an exception if an invalid storage path is used.
     *
     * @expectedException RuntimeException
     *
     * @return void
     */
    public function testInvalidPathIsRejected()
    {
        new Factory('https://httpbin.org/user-agent', 'grabby.png', 'this is not a valid directory');
    }

    /**
     * Makes sure Grabby generates a valid location for the generated screenshot.
     *
     * @return void
     */
    public function testValidFileLocationIsReturned()
    {
        $dir = rtrim(__DIR__, '/').'/';

        $grabby = new Factory('https://httpbin.org/user-agent', 'grabby.png', $dir);

        $this->assertEquals($dir.'grabby.png', $grabby->getScreengrabLocation());
    }

    /**
     * Ensures that Grabby can create a file from a website.
     *
     * @return void
     */
    public function testScreenshotCanBeGrabbed()
    {
        $grabby = new Factory('https://httpbin.org/user-agent', 'grabby.png', self::OUTPUT);

        $grabby->grab();

        $this->assertFileExists(self::OUTPUT.'grabby.png');
    }

    /**
     * @group f
     */
    public function testPdfScreenshotCanBeGrabbed()
    {
        $grabby = new Factory('https://httpbin.org/user-agent', 'grabby.pdf', self::OUTPUT, [
            'paperSize' => [
                'format'      => 'A4',
                'orientation' => 'portrait',
                'margin'      => '1cm'
            ]
        ]);

        $grabby->grab();

        $this->assertFileExists(self::OUTPUT.'grabby.pdf');
    }

    /**
     * Ensures that Grabby can create a screengrab and that the file location can be chained.
     *
     * @return void
     */
    public function testFileLocationCanBeChained()
    {
        $grabby = new Factory('https://httpbin.org/user-agent', 'grabby.png', self::OUTPUT);

        $this->assertEquals(self::OUTPUT.'grabby.png', $grabby->grab()->getScreengrabLocation());
    }

    /**
     * Ensures that Grabby can create a screengrab and that the file contents can be chained.
     *
     * @return void
     */
    public function testFileContentsCanBeChained()
    {
        $grabby = new Factory('https://httpbin.org/user-agent', 'grabby.png', self::OUTPUT);

        $this->assertNotNull($grabby->grab()->getScreengrab());
    }
}
