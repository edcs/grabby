<?php

namespace Edcs\Grabby\Tests;

use Edcs\Grabby\Factory;
use PHPUnit_Framework_TestCase;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Makes sure Grabby can be instatiated.
     *
     * @return void
     */
    public function testFactoryCanBeConstructed()
    {
        $grabby = new Factory('http://github.com');

        $this->assertInstanceOf('Edcs\Grabby\Factory', $grabby);
    }

    /**
     * Makes sure Grabby accepts valid file extesions.
     *
     * @return void
     */
    public function testValidFilenameIsAccepted()
    {
        $grabby = new Factory('http://github.com', 'grabby.jpg');

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
        new Factory('http://github.com', 'grabby.fail');
    }

    /**
     * Makes sure Grabby accepts valid directories.
     *
     * @return void
     */
    public function testValidPathIsAccepted()
    {
        $dir = rtrim(__DIR__, '/').'/';

        $grabby = new Factory('http://github.com', 'grabby.png', $dir);

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
        new Factory('http://github.com', 'grabby.png', 'this is not a valid directory');
    }

    /**
     * Makes sure Grabby generates a valid location for the generated screenshot.
     *
     * @return void
     */
    public function testValidFileLocationIsReturned()
    {
        $dir = rtrim(__DIR__, '/').'/';

        $grabby = new Factory('http://github.com', 'grabby.png', $dir);

        $this->assertEquals($dir.'grabby.png', $grabby->getScreengrabLocation());
    }
}
