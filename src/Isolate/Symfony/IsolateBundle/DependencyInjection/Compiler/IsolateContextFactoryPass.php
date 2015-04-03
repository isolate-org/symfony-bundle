<?php

namespace Isolate\Symfony\IsolateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class IsolateContextFactoryPass implements CompilerPassInterface
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
        $defaultTransactionFactory = $container->getParameter('isolate.default_transaction_factory');

        if (!$container->has($defaultTransactionFactory)) {
            throw new \RuntimeException(sprintf("Can't find service with id: \"%s\"", $defaultTransactionFactory));
        }

        $isolateContextFactory = $container->getDefinition('isolate.context.factory');
        $isolateContextFactory->replaceArgument(0, new Reference($defaultTransactionFactory));

        $persistenceContexts = $container->getParameter('isolate.persistence_contexts');

        if (count($persistenceContexts)) {
            $transactionFactoryMap = $container->getDefinition('isolate.transaction.factory.map');

            foreach ($persistenceContexts as $name => $configuration) {
                $transactionFactoryMap->addMethodCall('addFactory', [
                    new Definition("Isolate\\PersistenceContext\\Name", [$name]),
                    new Reference($configuration['transaction_factory'])
                ]);
            }
        }
    }
}
