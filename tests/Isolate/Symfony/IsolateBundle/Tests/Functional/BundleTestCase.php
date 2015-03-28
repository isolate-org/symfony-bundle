<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

use Isolate\Symfony\IsolateBundle\IsolateBundle;
use Isolate\Symfony\IsolateBundle\Tests\Functional\app\AppKernel;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BundleTestCase extends WebTestCase
{
    protected static function createKernel(array $options = array())
    {
        return new AppKernel("test", true, self::configuration(), self::bundles());
    }

    protected static function configuration()
    {
        return "config.yml";
    }

    protected static function bundles()
    {
        return [new FrameworkBundle(), new IsolateBundle()];
    }
}
