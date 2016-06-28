<?php

namespace Edcs\Grabby\Tests;

use Edcs\Grabby\Factory;
use PHPUnit_Framework_TestCase;
use RuntimeException;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Makes sure Grabby can be instatiated.
     *
     * @return void
     */
    public function testFactoryCanBeConstructed()
    {
        $grabby = new Factory('https://httpbin.org/user-agent');

        $this->assertInstanceOf('Edcs\Grabby\Factory', $grabby);
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
        $grabby = new Factory('https://httpbin.org/user-agent', 'grabby.png', __DIR__.'/../../output/');

        $grabby->grab();

        $this->assertFileExists(__DIR__.'/../../output/grabby.png');
    }

    /**
     * Ensures that Grabby can create a screengrab and that the file location can be chained.
     *
     * @return void
     */
    public function testFileLocationCanBeChained()
    {
        $grabby = new Factory('https://httpbin.org/user-agent', 'grabby.png', __DIR__.'/../../output/');

        $this->assertEquals(
            __DIR__.'/../../output/grabby.png',
            $grabby->grab()->getScreengrabLocation()
        );
    }

    /**
     * Ensures that Grabby can create a screengrab and that the file contents can be chained.
     *
     * @return void
     */
    public function testFileContentsCanBeChained()
    {
        $grabby = new Factory('https://httpbin.org/user-agent', 'grabby.png', __DIR__.'/../../output/');

        $this->assertNotNull(
            $grabby->grab()->getScreengrab()
        );
    }
}
