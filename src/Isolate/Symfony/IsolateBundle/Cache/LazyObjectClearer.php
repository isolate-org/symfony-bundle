<?php

namespace Isolate\Symfony\IsolateBundle\Cache;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;

final class LazyObjectClearer implements CacheClearerInterface
{
    /**
     * @var string
     */
    private $proxyCacheDir;

    /**
     * @param string $proxyCacheDir
     */
    function __construct($proxyCacheDir)
    {
        if (!file_exists($proxyCacheDir)) {
            throw new \InvalidArgumentException(sprintf("Lazy objects proxy cache dir \"%s\" does not exists.", $proxyCacheDir));
        }

        $this->proxyCacheDir = $proxyCacheDir;
    }

    /**
     * Clears any caches necessary.
     *
     * @param string $cacheDir The cache directory.
     */
    public function clear($cacheDir)
    {
        $fs = new Filesystem();
        $fs->remove($this->proxyCacheDir);
    }
}
