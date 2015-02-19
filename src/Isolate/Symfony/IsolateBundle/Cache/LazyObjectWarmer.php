<?php

namespace Isolate\Symfony\IsolateBundle\Cache;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;

final class LazyObjectWarmer extends CacheWarmer
{
    /**
     * @var string
     */
    private $proxyCacheDir;

    /**
     * @param string $proxyCacheDir
     */
    public function __construct($proxyCacheDir)
    {
        $this->proxyCacheDir = $proxyCacheDir;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $fs = new Filesystem();
        if ($fs->exists($this->proxyCacheDir)) {
            $fs->mkdir($this->proxyCacheDir);
        }
    }

    public function isOptional()
    {
        return true;
    }
}
