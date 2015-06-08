<?php namespace Edcs\Grabby;

use Symfony\Component\Process\Process;

trait FindPhantomJs
{
    /**
     * Returns the command needed to access PhantomJS.
     *
     * @return string
     */
    public function getPhantomInstallation()
    {
        $server = $this->phantomServer();

        return is_null($server) ? $this->phantomPackage() : $server;
    }

    /**
     * Returns the location of the version of PhantomJS installed on this server, or null if no version is available.
     *
     * @return null|string
     */
    private function phantomServer()
    {
        $phantom = new Process('which phantomjs');
        $phantom->run();

        if ($phantom->isSuccessful()) {
            return trim($phantom->getOutput());
        }

        return null;
    }

    /**
     * Returns the location of the correct bundled version of PhantonJS to be used if no server installation is
     * available.
     *
     * @return string
     */
    private function phantomPackage()
    {
        $system = $this->getSystem();

        return  __DIR__ . '/../bin/' . $system . '/phantomjs' . $this->getExtension($system);
    }

    /**
     * Get the operating system for the current platform.
     *
     * @return string
     */
    private function getSystem()
    {
        $uname = strtolower(php_uname());

        if (strpos($uname, 'darwin') !== false) {
            return 'macosx';
        } elseif (strpos($uname, 'win') !== false) {
            return 'windows';
        } elseif (strpos($uname, 'linux') !== false) {
            return PHP_INT_SIZE === 4 ? 'linux-i686' : 'linux-x86_64';
        } else {
            throw new \RuntimeException("Unknown operating system.");
        }
    }

    /**
     * Get the binary extension for the system.
     *
     * @param string $system
     * @return string
     */
    private function getExtension($system)
    {
        return $system == 'windows' ? '.exe' : '';
    }
}
