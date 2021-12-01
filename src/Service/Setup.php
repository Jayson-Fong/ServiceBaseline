<?php

namespace Service;

class Setup
{

    protected App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function runSetup()
    {
        $db = $this->app->db();

        $tables = $this->getTables();
        foreach ($tables as $tableName => $table)
        {
            $db->create(
                $tableName,
                $table['columns'] ?? [],
                $table['options'] ?? []
            );
        }
    }

    public function runUninstall()
    {
        $db = $this->app->db();
        $tables = $this->getTables();
        foreach (array_keys($tables) as $tableName)
        {
            $db->drop($tableName);
        }
    }

    public function getTables(): array
    {
        return [
            /**
            'table_name' => [
                'columns ' => [

                ],
                'options' => [

                ]
            ]
             **/
        ];
    }

}