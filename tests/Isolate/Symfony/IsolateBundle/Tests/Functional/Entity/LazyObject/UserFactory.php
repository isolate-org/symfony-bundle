<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional\Entity\LazyObject;

use Isolate\LazyObjects\Proxy\ClassName;
use Isolate\LazyObjects\Proxy\Definition;
use Isolate\Symfony\IsolateBundle\LazyObject\Definition\Factory;

final class UserFactory implements Factory
{
    /**
     * @return Definition
     */
    public function createDefinition()
    {
        return new Definition(
            new ClassName("Isolate\\Symfony\\IsolateBundle\\Tests\\Functional\\Entity\\User")
        );
    }
}
