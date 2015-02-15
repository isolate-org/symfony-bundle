<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

class ServicesTest extends BundleTestCase
{
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }

    public function test_unit_of_work_service()
    {
        $this->assertTrue(static::$kernel->getContainer()->has('isolate.unit_of_work'));
    }

    public function test_lazy_objects_service()
    {
        $this->assertTrue(static::$kernel->getContainer()->has('isolate.lazy_objects.wrapper'));
    }

    public function test_lazy_objects_default_configuration()
    {
        $kernelCacheDir = static::$kernel->getContainer()->getParameter('kernel.cache_dir');

        $this->assertSame(
            $kernelCacheDir . '/isolate/lazy_objects',
            self::$kernel->getContainer()->getParameter('isolate.lazy_objects.proxy_dir')
        );
    }
}
