<?php

namespace TestSolution;

use PDO;

class DB
{
    protected PDO $conn;

    public function __construct(public array $params)
    {
        $this->conn = new PDO('mysql:host='.$params['DB_ADDRESS'].';port='.$params['DB_PORT'].';dbname='.$params['DB_NAME'], $params['DB_USER'], $params['DB_PASS']);
    }

    public function insert(array $data, string $table)
    {
        $this->clearTable($table);
        $sql = $this->generateSqlToInsert($data, $table);
        $this->conn->exec($sql);
    }

    protected function generateSqlToInsert(array $data, string $table): string
    {
    }

    protected function clearTable(string $table)
    {
        $this->conn->exec('DELETE FROM '.$table);
        $this->conn->exec('ALTER TABLE '.$table.' AUTO_INCREMENT = 1');
    }
}
