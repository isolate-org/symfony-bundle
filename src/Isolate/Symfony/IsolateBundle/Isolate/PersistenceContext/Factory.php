<?php

namespace Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext;

use Isolate\PersistenceContext;
use Isolate\PersistenceContext\Factory as ContextFactory;
use Isolate\PersistenceContext\Name;
use Isolate\PersistenceContext\Transaction\Factory as TransactionFactory;
use Isolate\PersistenceContext\IsolateContext;

class Factory implements ContextFactory
{
    /**
     * @var TransactionFactory
     */
    private $transactionFactory;

    /**
     * @param TransactionFactory $transactionFactory
     */
    public function __construct(TransactionFactory $transactionFactory)
    {
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @param Name $name
     * @return PersistenceContext
     */
    public function create(Name $name)
    {
        return new IsolateContext($name, $this->transactionFactory);
    }
}
