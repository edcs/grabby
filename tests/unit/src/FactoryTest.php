<?php

namespace Edcs\Grabby\Tests;

use Edcs\Grabby\Factory;
use Exception;
use PhantomInstaller\PhantomBinary;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * The directory any output images should be stored.
     */
    const OUTPUT = __DIR__.'/../../output/';

    /**
     * The URL which we'll use for these tests.
     */
    const URL = 'https://httpbin.org/user-agent';

    /**
     * Makes sure Grabby can be instatiated.
     *
     * @return void
     */
    public function testFactoryCanBeConstructed()
    {
        $grabby = new Factory(self::URL);

        $this->assertInstanceOf(Factory::class, $grabby);
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
        new Factory(self::URL, 'grabby.fail');
    }

    /**
     * Makes sure Grabby accepts valid directories.
     *
     * @return void
     */
    public function testValidPathIsAccepted()
    {
        $dir = rtrim(__DIR__, '/').'/';

        new Factory(self::URL, 'grabby.png', $dir);
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
        new Factory(self::URL, 'grabby.png', 'this is not a valid directory');
    }

    /**
     * Ensures that Grabby can create a file from a website.
     *
     * @return void
     */
    public function testScreenshotCanBeGrabbed()
    {
        $grabby = new Factory(self::URL, 'grabby.png', self::OUTPUT);

        $grabby->grab();

        $this->assertFileExists(self::OUTPUT.'grabby.png');
    }

    /**
     * Ensures that Grabby can create a pdf from a website.
     *
     * @return void
     */
    public function testPdfScreenshotCanBeGrabbed()
    {
        $grabby = new Factory(self::URL, 'grabby.pdf', self::OUTPUT, [
            'paperSize' => [
                'format'      => 'A4',
                'orientation' => 'portrait',
                'margin'      => '1cm',
            ],
        ]);

        $grabby->grab();

        $this->assertFileExists(self::OUTPUT.'grabby.pdf');
    }

    /**
     * Ensures that Grabby can create a screengrab and that the file location can be chained.
     *
     * @return void
     */
    public function testFileLocationCanBeChained()
    {
        $grabby = new Factory(self::URL, 'grabby.png', self::OUTPUT);

        $this->assertEquals(self::OUTPUT.'grabby.png', $grabby->grab()->getScreengrabLocation());
    }

    /**
     * Ensures that Grabby can create a screengrab and that the file contents can be chained.
     *
     * @return void
     */
    public function testFileContentsCanBeChained()
    {
        $grabby = new Factory(self::URL, 'grabby.png', self::OUTPUT);

        $this->assertNotNull($grabby->grab()->getScreengrab());
    }

    /**
     * Ensures that an exceptoion is thrown if the PhantomJS command fails for some reason.
     *
     * @return void
     */
    public function testInvalidCommandIsHandled()
    {
        $filesystem = new Filesystem;

        $filesystem->rename(PhantomBinary::BIN, PhantomBinary::BIN.'_');

        $grabby = new Factory(self::URL, 'grabby.png', self::OUTPUT);
        $exceptionThrown = false;

        try {
            $grabby->grab();
        } catch (Exception $ex) {
            $this->assertInstanceOf(ProcessFailedException::class, $ex);
            $exceptionThrown = true;
        }

        $this->assertTrue($exceptionThrown);

        $filesystem->rename(PhantomBinary::BIN.'_', PhantomBinary::BIN);
    }
}
