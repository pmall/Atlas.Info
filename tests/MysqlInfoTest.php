<?php
namespace Atlas\Info;

use Atlas\Info\InfoTest;

class MysqlInfoTest extends InfoTest
{
    protected function create()
    {
        $this->connection->query("CREATE DATABASE {$this->schemaName1}");
        $this->connection->query("CREATE DATABASE {$this->schemaName2}");

        $this->connection->query("USE {$this->schemaName1}");
        $this->connection->query("
            CREATE TABLE {$this->tableName} (
                id                     INTEGER AUTO_INCREMENT PRIMARY KEY,
                name                   VARCHAR(50) NOT NULL,
                test_size_scale        NUMERIC(7,3),
                test_default_null      CHAR(3) DEFAULT NULL,
                test_default_string    VARCHAR(7) DEFAULT 'string',
                test_default_number    NUMERIC(5) DEFAULT 12345,
                test_default_ignore    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");

        $this->connection->query("
            CREATE TABLE {$this->schemaName2}.{$this->tableName} (
                id                     INTEGER AUTO_INCREMENT PRIMARY KEY,
                name                   VARCHAR(50) NOT NULL,
                test_size_scale        NUMERIC(7,3),
                test_default_null      CHAR(3) DEFAULT NULL,
                test_default_string    VARCHAR(7) DEFAULT 'string',
                test_default_number    NUMERIC(5) DEFAULT 12345,
                test_default_ignore    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");
    }

    protected function drop()
    {
        $this->connection->query("DROP DATABASE IF EXISTS {$this->schemaName1}");
        $this->connection->query("DROP DATABASE IF EXISTS {$this->schemaName2}");
    }

    public function provideFetchColumns()
    {
        $columns = [
            'id' => [
                'name' => 'id',
                'type' => 'int',
                'size' => 10,
                'scale' => 0,
                'notnull' => true,
                'default' => null,
                'autoinc' => true,
                'primary' => true
            ],
            'name' => [
                'name' => 'name',
                'type' => 'varchar',
                'size' => 50,
                'scale' => null,
                'notnull' => true,
                'default' => null,
                'autoinc' => false,
                'primary' => false
            ],
            'test_size_scale' => [
                'name' => 'test_size_scale',
                'type' => 'decimal',
                'size' => 7,
                'scale' => 3,
                'notnull' => false,
                'default' => null,
                'autoinc' => false,
                'primary' => false
            ],
            'test_default_null' => [
                'name' => 'test_default_null',
                'type' => 'char',
                'size' => 3,
                'scale' => null,
                'notnull' => false,
                'default' => null,
                'autoinc' => false,
                'primary' => false
            ],
            'test_default_string' => [
                'name' => 'test_default_string',
                'type' => 'varchar',
                'size' => 7,
                'scale' => null,
                'notnull' => false,
                'default' => 'string',
                'autoinc' => false,
                'primary' => false
            ],
            'test_default_number' => [
                'name' => 'test_default_number',
                'type' => 'decimal',
                'size' => 5,
                'scale' => 0,
                'notnull' => false,
                'default' => '12345',
                'autoinc' => false,
                'primary' => false
            ],
            'test_default_ignore' => [
                'name' => 'test_default_ignore',
                'type' => 'timestamp',
                'size' => null,
                'scale' => null,
                'notnull' => true,
                'default' => null,
                'autoinc' => false,
                'primary' => false
            ],
        ];

        return [
            [$this->tableName, $columns],
            ["{$this->schemaName2}.{$this->tableName}", $columns],
        ];
    }
}
