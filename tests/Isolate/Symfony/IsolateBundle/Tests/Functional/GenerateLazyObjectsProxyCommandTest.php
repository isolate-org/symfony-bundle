<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

use Isolate\Symfony\IsolateBundle\Command\GenerateLazyObjectProxyCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class GenerateLazyObjectsProxyCommandTest extends BundleTestCase
{
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }

    public function test_clearing_proxy_cache_during_cache_clear()
    {
        $fs = new Filesystem();
        $fs->remove($this->getProxyCacheDir());
        $fs->mkdir($this->getProxyCacheDir());

        $this->getGeneraterProxiesCommandTester()->execute(array('command' => 'isolate:lazy-objects:generate:proxies'));

        $this->assertEquals(1, $this->getProxyClassesInCacheCount());
    }


    /**
     * @return CommandTester
     */
    private function getGeneraterProxiesCommandTester()
    {
        $application = new Application(static::$kernel);
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
