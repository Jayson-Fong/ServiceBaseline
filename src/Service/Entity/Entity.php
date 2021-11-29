<?php

namespace Service\Entity;

use ArrayObject;
use Service\App;
use Service\Component;

abstract class Entity extends Component
{

    private array $data;
    private bool $isInsert;

    public function __construct(App $app, bool $isInsert = false, array $data = [])
    {
        parent::__construct($app);
        $this->data = $data;
        $this->isInsert = $isInsert;
    }

    public static abstract function getStructure(): ArrayObject;

    public function getData(): array
    {
        return $this->data;
    }

    public function isInsert(): bool
    {
        return $this->isInsert;
    }

    public function save()
    {
        $this->app->em()->write($this);
    }

    public function __get(string $name): mixed
    {
        return $this->data[$name];
    }

    public function __set(string $name, mixed $value)
    {
        $this->data[$name] = $value;
    }

    public function __isset(string $name)
    {
        return isset($this->data[$name]);
    }

    public function __unset(string $name)
    {
        unset($this->data[$name]);
    }

}