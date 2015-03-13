<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

use Isolate\Symfony\IsolateBundle\Tests\Functional\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Bundle\FrameworkBundle\Command\CacheWarmupCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Finder\Finder;

/**
 * Entity definitions used in this test case are created from factory
 * registered in tests/Isolate/Symfony/IsolateBundle/Tests/Functional/app/config/config.yml
 */
class IsolateTest extends BundleTestCase
{
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }

    public function test_persisting_entity_in_transaction_opened_by_persistence_context()
    {
        $entity = new User("norbert@orzechowicz.pl");

        $isolate = static::$kernel->getContainer()->get('isolate');
        $transaction = $isolate->getContext('default')->openTransaction();

        $transaction->persist($entity);

        $this->assertTrue($transaction->contains($entity));
    }
}
