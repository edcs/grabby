<?php

namespace Edcs\Grabby\Tests;

use AspectMock\Test as test;
use Edcs\Grabby\FindPhantomJs;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Process\Process;

trait FindPhantomJsLinuxStub
{
    use FindPhantomJs;

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
    public function testLinuxx64PackageIsReturned()
    {
        test::double(Process::class, ['isSuccessful' => false]);

        $this->assertContains('bin/linux-x86_64/phantomjs', $this->getPhantomInstallation());
    }
}
