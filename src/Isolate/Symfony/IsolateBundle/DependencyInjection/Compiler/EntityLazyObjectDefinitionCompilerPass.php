<?php

namespace Isolate\Symfony\IsolateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EntityLazyObjectDefinitionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $factories = $container->findTaggedServiceIds("isolate.lazy_object.definition.factory");
        $definitions = [];
        foreach ($factories as $id => $tag) {
            $definitions[] = new Reference($id);
        }

        $container->getDefinition('isolate.lazy_objects.definition.collection')->replaceArgument(0, $definitions);
    }
}
