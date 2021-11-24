<?php

namespace Service\Util;

use Medoo\Medoo;

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

}