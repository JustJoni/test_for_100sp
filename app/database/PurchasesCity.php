<?php

namespace TestSolution;

use PDO;

class PurchasesCity extends DB
{
    public function insert(array $data, string $table): int
    {
        $records = '';
		$columns = '';
        $lastRecord = array_key_last($data);

		$this->conn->beginTransaction();
		$query = $this->conn->prepare("INSERT INTO ".$table." (name,url) VALUES (:name,:url)");
		$query->execute($data);
		$cityID = $this->conn->lastInsertId();
		$this->conn->commit();
		
		return $cityID;
    }
}
