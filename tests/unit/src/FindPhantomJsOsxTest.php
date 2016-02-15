<?php

namespace Edcs\Grabby\Tests;

use AspectMock\Test as test;
use Edcs\Grabby\FindPhantomJs;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Process\Process;

trait FindPhantomJsOsxStub
{
    use FindPhantomJs;

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
        test::double(Process::class, ['isSuccessful' => false]);

        $this->assertContains('bin/macosx/phantomjs', $this->getPhantomInstallation());
    }
}
