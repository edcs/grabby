<?php

namespace Edcs\Grabby\Tests;

use Edcs\Grabby\FindPhantomJs;
use PHPUnit_Framework_TestCase;

trait FindPhantomJsWindowsStub
{
    use FindPhantomJs;

    /**
     * Returns the location of the version of PhantomJS installed on this server, or null if no version is available.
     *
     * @return null|string
     */
    protected function phantomServer()
    {
    }

    /**
     * Returns a Linux uname.
     *
     * @return string
     */
    protected function getUname()
    {
        return 'windows';
    }
}

class FindPhantomJsWindowsTest extends PHPUnit_Framework_TestCase
{
    use FindPhantomJsWindowsStub;

    /**
     * Ensures that the windows phantom js binary is returned if the uname contains windows.
     *
     * @throws \Exception
     */
    public function testOsxPackageIsReturned()
    {
        $this->assertContains('bin/windows/phantomjs.exe', $this->getPhantomInstallation());
    }
}
