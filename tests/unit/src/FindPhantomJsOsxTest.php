<?php

namespace Edcs\Grabby\Tests;

use Edcs\Grabby\FindPhantomJs;
use PHPUnit_Framework_TestCase;

trait FindPhantomJsOsxStub
{
    use FindPhantomJs;

    /**
     * Returns the location of the version of PhantomJS installed on this server, or null if no version is available.
     *
     * @return null|string
     */
    protected function phantomServer()
    {
        return;
    }

    /**
     * Returns a Linux uname.
     *
     * @return string
     */
    protected function getUname()
    {
        return 'darwin';
    }
}

class FindPhantomJsOsxTest extends PHPUnit_Framework_TestCase
{
    use FindPhantomJsOsxStub;

    /**
     * Ensures that the osx phantom js binary is returned if the uname contains darwin.
     *
     * @throws \Exception
     */
    public function testOsxPackageIsReturned()
    {
        $this->assertContains('bin/macosx/phantomjs', $this->getPhantomInstallation());
    }
}
