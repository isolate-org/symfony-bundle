<?php

namespace Isolate\Symfony\IsolateBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class IsolateExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('isolate.lazy_objects.proxy_dir', $config['lazy_objects']['proxy_dir']);
        $container->setParameter('isolate.lazy_objects.proxy_namespace', $config['lazy_objects']['proxy_namespace']);


        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('lazy_objects.yml');
        $loader->load('unit_of_work.yml');
        $loader->load('isolate.yml');
    }
}
