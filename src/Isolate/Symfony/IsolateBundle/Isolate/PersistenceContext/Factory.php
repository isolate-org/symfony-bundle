<?php

namespace Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext;

use Isolate\PersistenceContext;
use Isolate\PersistenceContext\Factory as ContextFactory;
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
     * @param string $name
     * @return PersistenceContext
     */
    public function create($name)
    {
        return new IsolateContext($this->transactionFactory);
    }
}
