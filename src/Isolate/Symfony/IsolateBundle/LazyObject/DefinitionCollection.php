<?php

namespace Isolate\Symfony\IsolateBundle\LazyObject;

use Doctrine\Common\Collections\ArrayCollection;
use Isolate\LazyObjects\Proxy\Definition;
use Isolate\Symfony\IsolateBundle\LazyObject\Definition\Factory;

class DefinitionCollection extends ArrayCollection
{
    public function __construct(array $elements = array())
    {
        $definitions = [];
        foreach ($elements as $definitionFactory) {
            $definition = $this->createDefinition($definitionFactory);

            $definitions[] = $definition;
        }

        parent::__construct($definitions);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function add($value)
    {
        return parent::add($this->createDefinition($value));
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return bool|void
     */
    public function offsetSet($offset, $value)
    {
        return parent::offsetSet($offset, $this->createDefinition($value));
    }

    /**
     * @param $definitionFactory
     * @return Definition
     */
    private function createDefinition($definitionFactory)
    {
        $this->validateFactory($definitionFactory);
        $definition = $definitionFactory->createDefinition();
        $this->validateDefinition($definition);

        return $definition;
    }

    /**
     * @param $definitionFactory
     */
    private function validateFactory($definitionFactory)
    {
        if (!$definitionFactory instanceof Factory) {
            throw new \InvalidArgumentException("Definition collection elements needs to implement Definition\\Factory.");
        }
    }

    /**
     * @param $definition
     */
    private function validateDefinition($definition)
    {
        if (!$definition instanceof Definition) {
            throw new \RuntimeException("Definition\\Factory needs to create Entity\\Definition instance.");
        }
    }
}
