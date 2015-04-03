<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

use Isolate\Symfony\IsolateBundle\Tests\Functional\Entity\User;

class IsolateTest extends BundleTestCase
{
    public function setUp()
    {
        self::$kernel = $this->createKernel();
        self::$kernel->boot();
    }

    public function test_persisting_entity_in_transaction_opened_by_persistence_context()
    {
        $entity = new User("norbert@orzechowicz.pl");

        $isolate = self::$kernel->getContainer()->get('isolate');
        $transaction = $isolate->getContext('default')->openTransaction();

        $transaction->persist($entity);

        $this->assertTrue($transaction->contains($entity));
    }

    public function test_creating_transactions_for_specific_contexts_with_specific_factories()
    {
        $isolate = self::$kernel->getContainer()->get('isolate');
        $transaction = $isolate->getContext('dummy')->openTransaction();

        $this->assertInstanceOf(
            'Isolate\Symfony\IsolateBundle\Tests\Functional\Isolate\PersistenceContext\Transaction\DummyTransaction',
            $transaction
        );
    }
}
