<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

use Isolate\Symfony\IsolateBundle\Command\GenerateLazyObjectProxyCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Lazy objects definitions used in this test case are created from factory
 * registered in tests/Isolate/Symfony/IsolateBundle/Tests/Functional/app/config/config.yml
 */
class GenerateLazyObjectsProxyCommandTest extends BundleTestCase
{
    public function setUp()
    {
        self::bootKernel();
    }

    public function test_clearing_proxy_cache_during_cache_clear()
    {
        $fs = new Filesystem();
        $fs->remove($this->getProxyCacheDir());
        $fs->mkdir($this->getProxyCacheDir());

        $tester = $this->getGeneraterProxiesCommandTester();
        $tester->execute(array('command' => 'isolate:lazy-objects:generate:proxies'));

        $this->assertSame(
            PHP_EOL . "Proxy class generated for \"Isolate\\Symfony\\IsolateBundle\\Tests\\Functional\\Entity\\User\"" . PHP_EOL ,
            $tester->getDisplay()
        );
        $this->assertEquals(1, $this->getProxyClassesInCacheCount());
    }

    /**
     * @return CommandTester
     */
    private function getGeneraterProxiesCommandTester()
    {
        $application = new Application(self::$kernel);
        $application->add(new GenerateLazyObjectProxyCommand());

        $command = $application->find('isolate:lazy-objects:generate:proxies');
        return new CommandTester($command);
    }

    private function getProxyClassesInCacheCount()
    {
        $finder = new Finder();
        return $finder->in($this->getProxyCacheDir())->name("*.php")->count();
    }

    /**
     * @return mixed
     */
    private function getProxyCacheDir()
    {
        return static::$kernel->getContainer()->getParameter('isolate.lazy_objects.proxy_dir');
    }
}
