<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional\Isolate\PersistenceContext\Transaction;

use Isolate\PersistenceContext\Transaction;

final class DummyTransaction implements Transaction
{
    /**
     * @return void
     */
    public function commit()
    {
    }

    /**
     * @return void
     */
    public function rollback()
    {
    }

    /**
     * @param mixed $entity
     * @return boolean
     */
    public function contains($entity)
    {
    }

    /**
     * @param mixed $entity
     */
    public function persist($entity)
    {
    }

    /**
     * @param mixed $entity
     */
    public function delete($entity)
    {
    }
}
