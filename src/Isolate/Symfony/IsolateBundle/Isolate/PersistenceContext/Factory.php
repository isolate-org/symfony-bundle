<?php

namespace Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext;

use Isolate\PersistenceContext;
use Isolate\PersistenceContext\Factory as ContextFactory;
use Isolate\PersistenceContext\Name;
use Isolate\PersistenceContext\Transaction\Factory as TransactionFactory;
use Isolate\PersistenceContext\IsolateContext;
use Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext\Transaction\FactoryMap;

class Factory implements ContextFactory
{
    /**
     * @var TransactionFactory
     */
    private $defaultTransactionFactory;

    /**
     * @var FactoryMap
     */
    private $factoryMap;

    /**
     * @param TransactionFactory $defaultTransactionFactory
     * @param FactoryMap $factoryMap
     */
    public function __construct(TransactionFactory $defaultTransactionFactory, FactoryMap $factoryMap)
    {
        $this->defaultTransactionFactory = $defaultTransactionFactory;
        $this->factoryMap = $factoryMap;
    }

    /**
     * @param Name $name
     * @return PersistenceContext
     */
    public function create(Name $name)
    {
        $factory = $this->factoryMap->hasFactory($name)
            ? $this->factoryMap->getFactory($name)
            : $this->defaultTransactionFactory;

        return new IsolateContext($name, $factory);
    }
}
