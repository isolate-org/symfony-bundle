<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional\Entity\LazyObject;

use Isolate\Framework\LazyObjects\Definition\Factory;
use Isolate\LazyObjects\Proxy\ClassName;
use Isolate\LazyObjects\Proxy\Definition;

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
