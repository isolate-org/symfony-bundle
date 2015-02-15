<?php

namespace Isolate\Symfony\IsolateBundle\Entity\Definition;

use Isolate\UnitOfWork\Entity\Definition;

interface Factory
{
    /**
     * @return Definition
     */
    public function createDefinition();
}
