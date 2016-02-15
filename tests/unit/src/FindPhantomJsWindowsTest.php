<?php

namespace Edcs\Grabby\Tests;

use AspectMock\Test as test;
use Edcs\Grabby\FindPhantomJs;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Process\Process;

trait FindPhantomJsWindowsStub
{
    use FindPhantomJs;

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
        test::double(Process::class, ['isSuccessful' => false]);

        $this->assertContains('bin/windows/phantomjs.exe', $this->getPhantomInstallation());
    }
}
