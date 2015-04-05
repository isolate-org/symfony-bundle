<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

class IsolateDoctrineBridgeTest extends BundleTestCase
{
    public function setUp()
    {
        $this->bootKernel(['suite' => 'DoctrineBridge']);
    }

    public function test_doctrine_orm_transaction()
    {
        $isolate = static::$kernel->getContainer()->get('isolate');
        $transaction = $isolate->getContext('doctrine_orm')->openTransaction();

        $this->assertInstanceOf(
            'Isolate\PersistenceContext\Transaction\Doctrine\ORMTransaction',
            $transaction
        );
    }
}
