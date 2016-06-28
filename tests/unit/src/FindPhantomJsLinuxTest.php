<?php

namespace Edcs\Grabby\Tests;

use Edcs\Grabby\FindPhantomJs;
use PHPUnit_Framework_TestCase;

trait FindPhantomJsLinuxStub
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
        return 'linux';
    }
}

class FindPhantomJsLinuxTest extends PHPUnit_Framework_TestCase
{
    use FindPhantomJsLinuxStub;

    /**
     * Ensures that the linux phantom js binary is returned if the uname contains linux.
     *
     * @throws \Exception
     */
    public function testLinux64PackageIsReturned()
    {
        $this->assertContains('bin/linux-x86_64/phantomjs', $this->getPhantomInstallation());
    }
}
