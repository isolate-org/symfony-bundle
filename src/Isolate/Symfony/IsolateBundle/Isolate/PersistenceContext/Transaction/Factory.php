<?php

namespace Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext\Transaction;

use Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext\Transaction;
use Isolate\PersistenceContext\Transaction\Factory as TransactionFactory;
use Isolate\UnitOfWork\Factory as UOWFactory;

class Factory implements TransactionFactory
{
    /**
     * @var UOWFactory
     */
    private $uowFactory;

    /**
     * @param UOWFactory $uowFactory
     */
    public function __construct(UOWFactory $uowFactory)
    {
        $this->uowFactory = $uowFactory;
    }

    /**
     * @return Transaction
     */
    public function create()
    {
        return new Transaction($this->uowFactory->create());
    }
}
