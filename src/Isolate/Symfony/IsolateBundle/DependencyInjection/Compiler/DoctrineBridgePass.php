<?php

namespace Isolate\Symfony\IsolateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class DoctrineBridgePass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        if (!class_exists('Isolate\PersistenceContext\Transaction\DoctrineFactory') || !$container->has('doctrine')) {
            return ;
        }

        $doctrineTransactionFactory = $container->register(
            'isolate.doctrine.transaction.factory',
            'Isolate\PersistenceContext\Transaction\DoctrineFactory'
        );

        $doctrineTransactionFactory->setArguments([new Reference('doctrine')]);
    }
}
