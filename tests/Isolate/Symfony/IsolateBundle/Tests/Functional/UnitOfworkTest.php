<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

use Isolate\Symfony\IsolateBundle\Tests\Functional\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Bundle\FrameworkBundle\Command\CacheWarmupCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Finder\Finder;

class UnitOfWorkTest extends BundleTestCase
{
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }

    public function test_checking_if_can_wrap_class_that_has_definition()
    {
        $entity = new User("norbert@orzechowicz.pl");

        static::$kernel->getContainer()->get('isolate.unit_of_work')->register($entity);

        $this->assertTrue(static::$kernel->getContainer()->get('isolate.unit_of_work')->isRegistered($entity));
    }
}
