<?php

namespace TestSolution;

use PDO;

class Purchase extends DB
{
	private string $refTable = '';
	
    public function insert(array $data, string $table)
    {
		$this->clearTable($table);
		$purchaseTypes = $this->selectAllTypes();
		$data = $this->changePurchaseTypesNamesToID($data, $purchaseTypes);
		$sql = $this->generateSqlToInsert($data, $table);
		$this->conn->exec($sql);
	}
	
	public function setReferenceTable(string $table)
	{
		$this->refTable = $table;
	}
	
	//Забираем типы покупок из таблицы, чтобы вставлять в покупки индексы типов
	private function selectAllTypes():array
	{
		$types = array();
		$result = $this->conn->query('SELECT * FROM ' . $this->refTable)->fetchAll();
		foreach($result as $record)
		{
			$types[$record['name']] = $record['id'];
		}
		
		return $types;
	}
	
	//Меняем типы покупок на соответствующие индексы
	private function changePurchaseTypesNamesToID(array $purchases, array $types):array
	{		
		foreach($purchases as $key=>$record)
		{
			$purchases[$key]['purchasesType'] = $types[$record['purchasesType']];
		}
		
		return $purchases;
	}	
	protected function generateSqlToInsert(array $data, string $table):string
	{
		$records = '';
		$lastRecord = array_key_last($data);
		foreach($data as $key=>$record)
		{
			$records .= "('" . $record['purchasesType'] . "','" . $record['href'] . "','" . $record['img'] . "','" . $record['title'] . "')";
			if($key != $lastRecord)
			{
				$records .= ',';
			}
		}
		$sql = "INSERT INTO " . $table . " (purchase_id,href,img,name)
			 VALUES " . $records;
		
		return $sql;
	}
}
