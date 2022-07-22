<?php

namespace TestSolution;

use PDO;

class PurchaseType extends DB
{
    public function insert(array $data, string $table): int
    {	
		$this->conn->beginTransaction();
		$query = $this->conn->prepare("INSERT INTO ".$table." (name) VALUES (?)");
        foreach ($data as $record) {
			$query->bindParam(1,$record,PDO::PARAM_STR);
			$query->execute();
        }
		$lastRecord = $this->conn->lastInsertId();
		$this->conn->commit();

        return $lastRecord;
    }
}
