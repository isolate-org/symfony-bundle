<?php

namespace Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext\Transaction;

use Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext\Transaction;
use Isolate\PersistenceContext\Transaction\Factory as TransactionFactory;
use Isolate\UnitOfWork\UnitOfWork;

class Factory implements TransactionFactory
{
    /**
     * @param UnitOfWork $unitOfWork
     * @return Transaction
     */
    public function create(UnitOfWork $unitOfWork)
    {
        return new Transaction($unitOfWork);
    }
}
