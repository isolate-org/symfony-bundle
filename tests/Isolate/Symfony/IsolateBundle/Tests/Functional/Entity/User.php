<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional\Entity;

class User
{
    private $email;

    private $items;

    /**
     * @param $email
     */
    public function __construct($email)
    {
        $this->email = $email;
        $this->items = [];
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    public function addItem($item)
    {
        $this->items[] = $item;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }
}
