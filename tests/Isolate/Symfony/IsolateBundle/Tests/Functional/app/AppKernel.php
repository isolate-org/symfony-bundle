<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional\app;

use Isolate\Symfony\IsolateBundle\IsolateBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    /**
     * @var string
     */
    protected $configuration;

    protected $requiredBundles;

    /**
     * @param string $environment
     * @param bool $debug
     * @param string $configuration
     * @param array $bundles
     */
    public function __construct($environment, $debug, $configuration = 'config.yml', $bundles = array())
    {
        parent::__construct($environment, $debug);
        $this->configuration = $configuration;
        $this->requiredBundles = $bundles;
    }

    public function registerBundles()
    {
        return count($this->requiredBundles)
            ? $this->requiredBundles
            : [new FrameworkBundle(), new IsolateBundle()];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/' . $this->configuration);
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
