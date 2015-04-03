<?php

namespace Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext\Transaction;

use Isolate\PersistenceContext\Name;
use Isolate\PersistenceContext\Transaction\Factory;

final class FactoryMap
{
    /**
     * @var array|Factory
     */
    private $factories;

    public function __construct()
    {
        $this->factories = [];
    }

    /**
     * @param Factory $transactionFactory
     * @param Name $contextName
     */
    public function addFactory(Name $contextName, Factory $transactionFactory)
    {
        $this->factories[(string) $contextName] = $transactionFactory;
    }

    /**
     * @param Name $contextName
     * @return bool
     */
    public function hasFactory(Name $contextName)
    {
        return array_key_exists((string) $contextName, $this->factories);
    }

    /**
     * @param Name $contextName
     * @return Factory
     */
    public function getFactory(Name $contextName)
    {
        return $this->factories[(string) $contextName];
    }
}
