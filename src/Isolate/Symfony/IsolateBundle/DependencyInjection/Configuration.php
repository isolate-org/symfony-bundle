<?php

namespace Isolate\Symfony\IsolateBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('isolate');

        $rootNode
            ->children()
                ->arrayNode('lazy_objects')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('proxy_dir')->defaultValue('%kernel.cache_dir%/isolate/lazy_objects')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
