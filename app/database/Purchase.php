<?php

namespace TestSolution;

use PDO;
use Exception;

class Purchase extends DB
{
    private string $refTable = '';
	private int $cityID = 0;

    public function getSQL(array $data, string $table):string
    {
		$sql = '';
		
		
		return $sql;
    }

	public function setCityID(int $cityID)
	{
		$this->cityID = $cityID;
	}

    public function setReferenceTable(string $table)
    {
        $this->refTable = $table;
    }

    //Забираем типы покупок из таблицы, чтобы вставлять в покупки индексы типов
    private function selectAllTypes(): array
    {
        $types = array();
        $result = $this->conn->query('SELECT * FROM '.$this->refTable)->fetchAll();
        foreach ($result as $record) {
            $types[$record['name']] = $record['id'];
        }

        return $types;
    }

    //Меняем типы покупок на соответствующие индексы
    private function changePurchaseTypesNamesToID(array $purchases, array $types): array
    {
        foreach ($purchases as $key => $record) {
            $purchases[$key]['purchasesType'] = $types[$record['purchasesType']];
        }

        return $purchases;
    }

    public function insert(array $data, string $table): int
    {
		try {
			if ($this->cityID == 0) {
				throw new Exception('Город не определён! Запись в базу не будет выполнена!');
			}
			else {			
				$purchaseTypes = $this->selectAllTypes();
				$data = $this->changePurchaseTypesNamesToID($data, $purchaseTypes);
			}
		}
		catch (Exception $e) {
			echo $e->getMessage();
			die();
		}
		
        $records = '';
		$this->conn->beginTransaction();
		$query = $this->conn->prepare("INSERT INTO ".$table." (purchase_id,city_id,href,img,name) VALUES (:purchasesType,:cityID,:href,:img,:title)");
        foreach ($data as $key => $record) {
			$record['cityID'] = $this->cityID;
			$query->execute($record);
		}
		$this->conn->commit();
			
		return $this->conn->lastInsertId();
	}
	
	public function getPurchasesByCity(string $cityName = ''):array
	{
		$result = array();
		$cityTable = $this->params['DB_TABLE_CITYES'];
		$purchaseTable = $this->params['DB_TABLE_PURCHASES'];
		$purchaseTypesTable = $this->params['DB_TABLE_TYPES'];
		$sql = "SELECT ".$cityTable.".name AS city, ".$purchaseTypesTable.".name AS purchase_type, ".$purchaseTable.".name AS title, ".$purchaseTable.".img AS images_url, ".$purchaseTable.".href AS purchase_url 
			FROM ".$purchaseTable." 
			JOIN ".$purchaseTypesTable." ON ".$purchaseTable.".purchase_id = ".$purchaseTypesTable.".id 
			JOIN ".$cityTable." ON ".$purchaseTable.".city_id = ".$cityTable.".id";

		if ($cityName == '') {
			$result = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$sql .= " WHERE ".$cityTable.".id = :city";
			$cityID = $this->getCityID($cityName);
			$query = $this->conn->prepare($sql);
			$query->bindParam(':city', $cityID);
			$query->execute();
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return $result;
	}
	
	private function getCityID(string $cityName):int
	{
		$cityID = 0;
		$sql = "SELECT id FROM ".$this->params['DB_TABLE_CITYES']." WHERE name LIKE :city";
		$query = $this->conn->prepare($sql);
		$query->bindParam(':city', $cityName);
		$query->execute();
		$cityID = $query->fetch();
		
		return $cityID['id'];
	}
}
