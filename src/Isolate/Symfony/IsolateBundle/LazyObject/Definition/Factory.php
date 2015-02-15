<?php

namespace Isolate\Symfony\IsolateBundle\LazyObject\Definition;

use Isolate\LazyObjects\Proxy\Definition;

interface Factory
{
    /**
     * @return Definition
     */
    public function createDefinition();
}
