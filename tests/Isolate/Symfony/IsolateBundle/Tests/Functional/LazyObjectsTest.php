<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

use Isolate\Symfony\IsolateBundle\Tests\Functional\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Bundle\FrameworkBundle\Command\CacheWarmupCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Finder\Finder;

class LazyObjectsTest extends BundleTestCase
{
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }

    public function test_checking_if_can_wrap_class_that_has_definition()
    {
        $entity = new User("norbert@orzechowicz.pl");

        $this->assertTrue(static::$kernel->getContainer()->has('test.lazy_object.factory.user'));
        $this->assertTrue(static::$kernel->getContainer()->get('isolate.lazy_objects.wrapper')->canWrap($entity));
    }

    public function test_wrapping_an_object()
    {
        $entity = new User("norbert@orzechowicz.pl");

        $proxy = static::$kernel->getContainer()->get('isolate.lazy_objects.wrapper')->wrap($entity);
    }

    public function test_clearing_proxy_cache_during_cache_clear()
    {
        $entity = new User("norbert@orzechowicz.pl");
        static::$kernel->getContainer()->get('isolate.lazy_objects.wrapper')->wrap($entity);

        $this->assertEquals(1, $this->getProxyClassesInCacheCount());

        $this->getCacheClearCommandTester()->execute(array('command' => 'cache:clear'));

        static::$kernel->getContainer()->get('isolate.lazy_objects.wrapper')->wrap($entity);

        $this->assertEquals(0, $this->getProxyClassesInCacheCount());
    }

    /**
     * @return CommandTester
     */
    private function getCacheClearCommandTester()
    {
        $application = new Application(static::$kernel);
        $application->add(new CacheClearCommand());

        $command = $application->find('cache:clear');
        return new CommandTester($command);
    }

    /**
     * @return CommandTester
     */
    private function getCacheWarmupCommandTester()
    {
        $application = new Application(static::$kernel);
        $application->add(new CacheWarmupCommand());

        $command = $application->find('cache:warmup');
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
