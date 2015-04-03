<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional\Isolate\PersistenceContext\Transaction;

use Isolate\PersistenceContext;
use Isolate\PersistenceContext\Transaction;
use Isolate\PersistenceContext\Transaction\Factory;

final class DummyTransactionFactory implements Factory
{
    /**
     * @param PersistenceContext $context
     * @return Transaction
     */
    public function create(PersistenceContext $context)
    {
        return new DummyTransaction();
    }
}
