<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional\Entity\Definition;

use Isolate\Framework\UnitOfWork\Entity\Definition\Factory;
use Isolate\UnitOfWork\Entity\ClassName;
use Isolate\UnitOfWork\Entity\Definition;

final class UserFactory implements Factory
{
    /**
     * @return Definition
     */
    public function createDefinition()
    {
        $definition = new Definition(
            new ClassName("Isolate\\Symfony\\IsolateBundle\\Tests\\Functional\\Entity\\User"),
            new Definition\Identity("id")
        );
        $definition->addToObserved(new Definition\Property("email"));
        
        return $definition;
    }
}
