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

    public function save()
    {
        $structure = $this::getStructure();
        $data = $this->data;

        if ($this->isInsert)
        {
            unset($data[$structure->offsetGet('primary_key')]);
            $this->app->db()->insert(
                $structure->offsetGet('table'),
                $data
            );
        }
        else
        {
            $primaryKey = $structure->offsetGet('primary_key');
            $this->app->db()->update(
                $structure->offsetGet('table'),
                $data,
                [
                    $primaryKey => $data[$primaryKey]
                ]
            );
        }
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