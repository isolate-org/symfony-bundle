<?php

namespace Isolate\Symfony\IsolateBundle\Isolate;

use Isolate\Symfony\IsolateBundle\Entity\DefinitionCollection;
use Isolate\UnitOfWork\CommandBus\SilentBus;
use Isolate\UnitOfWork\Entity\ChangeBuilder;
use Isolate\UnitOfWork\Entity\Definition\Repository\InMemory;
use Isolate\UnitOfWork\Entity\IsolateComparer;
use Isolate\UnitOfWork\Entity\IsolateIdentifier;
use Isolate\UnitOfWork\Factory as UnitOfWorkFactory;
use Isolate\UnitOfWork\Object\IsolateRegistry;
use Isolate\UnitOfWork\Object\RecoveryPoint;
use Isolate\UnitOfWork\Object\SnapshotMaker\Adapter\DeepCopy\SnapshotMaker;
use Isolate\UnitOfWork\UnitOfWork;

class Factory implements UnitOfWorkFactory
{
    /**
     * @var DefinitionCollection
     */
    private $entityDefinitions;

    /**
     * @param DefinitionCollection $entityDefinitions
     */
    public function __construct(DefinitionCollection $entityDefinitions)
    {
        $this->entityDefinitions = $entityDefinitions;
    }

    /**
     * @return UnitOfWork
     */
    public function create()
    {
        $definitionRepository = new InMemory($this->entityDefinitions);
        $snapshotMaker = new SnapshotMaker();
        $recoveryPoint = new RecoveryPoint();
        $objectRegistry = new IsolateRegistry($snapshotMaker, $recoveryPoint);
        $identifier = new IsolateIdentifier($definitionRepository);
        $changeBuilder = new ChangeBuilder($definitionRepository, $identifier);
        $comparer = new IsolateComparer($definitionRepository);
        $commandBus = new SilentBus($definitionRepository);

        return new UnitOfWork(
            $objectRegistry,
            $identifier,
            $changeBuilder,
            $comparer,
            $commandBus
        );
    }
}
