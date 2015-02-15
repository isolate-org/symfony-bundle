<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional\app;

use Isolate\Symfony\IsolateBundle\IsolateBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new IsolateBundle()
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config.yml');
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir() . '/'. Kernel::VERSION . '/cache/' . $this->environment;
    }

    public function getLogDir()
    {
        return sys_get_temp_dir() . '/' . Kernel::VERSION . '/logs';
    }
}
