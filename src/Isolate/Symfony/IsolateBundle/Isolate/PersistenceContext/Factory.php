<?php

namespace Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext;

use Isolate\PersistenceContext;
use Isolate\PersistenceContext\Factory as ContextFactory;
use Isolate\UnitOfWork\Factory as UnitOfWorkFactory;
use Isolate\PersistenceContext\Transaction\Factory as TransactionFactory;
use Isolate\PersistenceContext\IsolateContext;

class Factory implements ContextFactory
{
    /**
     * @var UnitOfWorkFactory
     */
    private $unitOfWorkFactory;

    /**
     * @var TransactionFactory
     */
    private $transactionFactory;

    /**
     * @param UnitOfWorkFactory $unitOfWorkFactory
     * @param TransactionFactory $transactionFactory
     */
    public function __construct(UnitOfWorkFactory $unitOfWorkFactory, TransactionFactory $transactionFactory)
    {
        $this->unitOfWorkFactory = $unitOfWorkFactory;
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @param string $name
     * @return PersistenceContext
     */
    public function create($name)
    {
        return new IsolateContext($name, $this->unitOfWorkFactory, $this->transactionFactory);
    }
}
