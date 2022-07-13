<?php

namespace TestSolution;

use PDO;

class Purchase extends DB
{
    private string $refTable = '';
	private int $cityID = 0;

    public function getSQL(array $data, string $table):string
    {
		$sql = '';
		if ($this->cityID == 0) {
			print_r('Город не определён! Запись в базу не будет выполнена!');
		}
		else {			
			$purchaseTypes = $this->selectAllTypes();
			$data = $this->changePurchaseTypesNamesToID($data, $purchaseTypes);
			$sql = $this->generateSqlToInsert($data, $table);
		}
		
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

    protected function generateSqlToInsert(array $data, string $table): string
    {
        $records = '';
        $lastRecord = array_key_last($data);
        foreach ($data as $key => $record) {
			$title = $this->conn->quote($record['title']);
            $records .= "(".$record['purchasesType'].",".$this->cityID.",'".$record['href']."','".$record['img']."',".$title.")";
            if ($key != $lastRecord) {
                $records .= ',';
            }
        }
        $sql = 'INSERT INTO '.$table.' (purchase_id,city_id,href,img,name)
			 VALUES '.$records.';';

        return $sql;
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
