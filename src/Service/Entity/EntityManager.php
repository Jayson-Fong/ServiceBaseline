<?php

namespace Service\Entity;

use ArrayObject;
use Service\Component;

class EntityManager extends Component
{

    public function load(string $name, array $data): Entity
    {
        if (empty($data))
        {
            return $this->create($name);
        }

        /** @var ArrayObject $structure */
        $structure = call_user_func($name .'::getStructure');
        $columns = $structure->offsetGet('columns');

        $finalData = [];
        foreach ($columns as $columnName => $column)
        {
            if (isset($data[$columnName]))
            {
                $finalData[$columnName] = $data[$columnName];
            }
            else
            {
                $finalData[$columnName] = $column['default'];
            }
        }

        return new $name($this->app, false, $finalData);
    }

    public function create(string $name): Entity
    {
        /** @var ArrayObject $structure */
        $structure = call_user_func($name .'::getStructure');
        $columns = $structure->offsetGet('columns');

        $data = [];
        foreach ($columns as $columnName => $column)
        {
            $data[$columnName] = $column['default'];
        }

        return new $name($this->app, true, $data);
    }

}