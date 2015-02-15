<?php

namespace Isolate\Symfony\IsolateBundle;

use Isolate\Symfony\IsolateBundle\DependencyInjection\Compiler\EntityDefinitionCompilerPass;
use Isolate\Symfony\IsolateBundle\DependencyInjection\Compiler\EntityLazyObjectDefinitionCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IsolateBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new EntityDefinitionCompilerPass());
        $container->addCompilerPass(new EntityLazyObjectDefinitionCompilerPass());
    }

    public function boot()
    {
        parent::boot();

        $fs = new Filesystem();
        $proxyDir = $this->container->getParameter('isolate.lazy_objects.proxy_dir');
        $config = $this->container->get('isolate.lazy_objects.wrapper.proxy.adapter.configuration');

        if (!$fs->exists($proxyDir)) {
            $fs->mkdir($proxyDir);
        }

        spl_autoload_register($config->getProxyAutoloader());
    }
}
