<?php

namespace Isolate\Symfony\IsolateBundle\Isolate\PersistenceContext;

use Isolate\PersistenceContext\Transaction as BaseTransaction;
use Isolate\UnitOfWork\UnitOfWork;

class Transaction implements BaseTransaction
{
    /**
     * @var UnitOfWork
     */
    private $unitOfWork;

    /**
     * @param UnitOfWork $unitOfWork
     */
    public function __construct(UnitOfWork $unitOfWork)
    {
        $this->unitOfWork = $unitOfWork;
    }

    /**
     * @return void
     */
    public function commit()
    {
        $this->unitOfWork->commit();
    }

    /**
     * @return void
     */
    public function rollback()
    {
        $this->unitOfWork->rollback();
    }

    /**
     * @param mixed $entity
     * @return boolean
     */
    public function contains($entity)
    {
        return $this->unitOfWork->isRegistered($entity);
    }

    /**
     * @param mixed $entity
     */
    public function persist($entity)
    {
        $this->unitOfWork->register($entity);
    }

    /**
     * @param mixed $entity
     */
    public function delete($entity)
    {
        $this->unitOfWork->remove($entity);
    }
}
