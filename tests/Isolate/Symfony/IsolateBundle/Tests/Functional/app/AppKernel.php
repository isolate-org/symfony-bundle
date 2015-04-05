<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional\app;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private $bootTime = 0;

    /**
     * @var string
     */
    private $suite;

    /**
     * @param string string $suite
     * @param string $environment
     * @param bool $debug
     */
    public function __construct($environment, $debug, $suite = 'Isolate')
    {
        if (!is_dir(__DIR__.'/'.$suite)) {
            throw new \InvalidArgumentException(sprintf('The suite "%s" does not exist.', $suite));
        }
        $this->suite = $suite;

        parent::__construct($environment, $debug);
    }

    public function registerBundles()
    {
        if (!is_file($filename = $this->getRootDir().'/'.$this->suite.'/bundles.php')) {
            throw new \RuntimeException(sprintf('The bundles file "%s" does not exist.', $filename));
        }

        return include $filename;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/' . $this->suite . '/config.yml');
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir() . '/'. Kernel::VERSION . '/' . $this->suite .  '/cache/' . $this->environment;
    }

    public function getLogDir()
    {
        return sys_get_temp_dir() . '/' . Kernel::VERSION . '/' . $this->suite . '/logs';
    }

    public function serialize()
    {
        return serialize(array($this->suite, $this->getEnvironment(), $this->isDebug()));
    }

    public function unserialize($str)
    {
        $a = unserialize($str);
        $this->__construct($a[0], $a[1], $a[2]);
    }

    protected function getKernelParameters()
    {
        $parameters = parent::getKernelParameters();
        $parameters['kernel.test_suite'] = $this->suite;
        return $parameters;
    }

    protected function initializeContainer()
    {
        $class = $this->getContainerClass();
        $cache = new ConfigCache($this->getCacheDir().'/'.$class.'.php', $this->debug);
        $fresh = true;
        if (!$cache->isFresh()) {
            $container = $this->buildContainer();
            $container->compile();

            $this->dumpContainer($cache, $container, $class, $this->getContainerBaseClass());

            $fresh = false;
        }

        require_once $cache;

        $this->container = new $class();
        $this->container->set('kernel', $this);

        if (!$fresh && $this->container->has('cache_warmer')) {
            $this->container->get('cache_warmer')->warmUp($this->container->getParameter('kernel.cache_dir'));
        }
    }
}
