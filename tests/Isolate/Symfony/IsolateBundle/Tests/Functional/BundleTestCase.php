<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

use Isolate\Symfony\IsolateBundle\Tests\Functional\app\AppKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BundleTestCase extends KernelTestCase
{
    protected static function createKernel(array $options = array())
    {
        return new AppKernel("test", true);
    }
}
