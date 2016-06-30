<?php

namespace Edcs\Grabby\Tests;

use Edcs\Grabby\Grab;
use PHPUnit_Framework_TestCase;

class GrabTest extends PHPUnit_Framework_TestCase
{
    /**
     * Makes sure Grab returns filename.
     *
     * @return void
     */
    public function testValidFilenameIsAccepted()
    {
        $grab = new Grab('path/to/screengrab/', 'grabby.jpg');

        $this->assertEquals('grabby.jpg', $grab->getFilename());
    }

    /**
     * Makes sure Grabby accepts valid directories.
     *
     * @return void
     */
    public function testValidPathIsAccepted()
    {
        $grab = new Grab('path/to/screengrab/', 'grabby.jpg');

        $this->assertEquals('path/to/screengrab/', $grab->getStoragePath());
    }

    /**
     * Makes sure Grabby generates a valid location for the generated screenshot.
     *
     * @return void
     */
    public function testValidFileLocationIsReturned()
    {
        $grab = new Grab('path/to/screengrab/', 'grabby.jpg');

        $this->assertEquals('path/to/screengrab/grabby.jpg', $grab->getScreengrabLocation());
    }
}
