<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

class BundleTestCase extends WebTestCase
{
    protected static function deleteTmpDir($suite = 'Isolate')
    {
        if (!file_exists($dir = sys_get_temp_dir().'/'.Kernel::VERSION.'/'.$suite)) {
            return;
        }

        $fs = new Filesystem();
        $fs->remove($dir);
    }

    protected static function createKernel(array $options = [])
    {
        $class = self::getKernelClass();

        $options = array_merge([
            'suite' => "Isolate",
        ], $options);

        return new $class("test", true, $options['suite']);
    }

    protected static function getKernelClass()
    {
        require_once __DIR__.'/app/AppKernel.php';

        return 'Isolate\Symfony\IsolateBundle\Tests\Functional\app\AppKernel';
    }
}
