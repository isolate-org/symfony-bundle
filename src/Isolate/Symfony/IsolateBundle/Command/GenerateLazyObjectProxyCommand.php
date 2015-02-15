<?php

namespace Isolate\Symfony\IsolateBundle\Command;

use Isolate\LazyObjects\Proxy\Adapter\OcramiusProxyManager\Factory\LazyObjectsFactory;
use Isolate\LazyObjects\Proxy\Definition;
use Isolate\Symfony\IsolateBundle\LazyObject\DefinitionCollection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateLazyObjectProxyCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('isolate:lazy-objects:generate:proxies')
            ->setDescription('Generate proxy classes for Isolate lazy objects.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var DefinitionCollection $lazyObjectDefinitions */
        /* @var LazyObjectsFactory $factory */
        /* @var Definition $definition */

        $lazyObjectDefinitions = $this->getContainer()->get('isolate.lazy_objects.definition.collection');
        $factory = $this->getContainer()->get('isolate.lazy_objects.wrapper.proxy.adapter.factory');

        foreach ($lazyObjectDefinitions as $definition) {
            $factory->createProxyClass((string) $definition->getClassName());
        }
    }
}
