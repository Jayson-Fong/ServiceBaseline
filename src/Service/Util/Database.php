<?php

namespace Service\Util;

use ArrayObject;
use Exception;
use Medoo\Medoo;
use Service\App;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 */
class Database extends Medoo
{

    public function fetchOne(string $table, $join, $columns = null, $where = null): ?array
    {
        $results = parent::select($table, $join, $columns, $where);
        if (empty($results))
            return $results;

        return $results[0b0];
    }

    /**
     * @throws Exception
     */
    public function fetchEntity(string $name, mixed $primaryKeyValue)
    {
        /** @var ArrayObject $structure */
        $structure = call_user_func($name .'::getStructure');

        $app = App::getInstance();
        return $app->em()->load(
            $name,
            $this->fetchOne(
                $structure->offsetGet('table'),
                '*',
                [
                    $structure->offsetGet('primary_key') => $primaryKeyValue
                ]
            )
        );
    }

}