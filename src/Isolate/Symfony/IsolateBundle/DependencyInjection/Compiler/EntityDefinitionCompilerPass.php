<?php

namespace Isolate\Symfony\IsolateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EntityDefinitionCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definitionFactoriesId = $container->findTaggedServiceIds("isolate.entity.definition.factory");
        $factories = [];
        foreach ($definitionFactoriesId as $id => $tag) {
            $factories[] = new Reference($id);
        }

        $container->getDefinition('isolate.unit_of_work.entity.definition.collection')->replaceArgument(0, $factories);
    }
}
