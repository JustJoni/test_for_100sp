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

    public function insert(array|string $data, string $table):int
    {
		$sql = '';
		if (is_array($data)) {
			$sql = $this->generateSqlToInsert($data, $table);
		}
		else {
			$sql = $data;
		}
        
        $this->conn->exec($sql);
		
		return $this->conn->lastInsertId();
    }

    protected function generateSqlToInsert(array $data, string $table): string
    {
    }

    public function clearTable(string $table)
    {
        $this->conn->exec('DELETE FROM '.$table);
        $this->conn->exec('ALTER TABLE '.$table.' AUTO_INCREMENT = 1');
    }
}
