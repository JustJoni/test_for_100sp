<?php

namespace TestSolution;

use PDO;

class DB
{
	private PDO $conn;
	private string $purchaseTypesTable = 'purchase_type';
	private array $purchaseTypesTableFields = [
		'id' => 'int',
		'type_name' => '',
		];
	private string $purchasesTable = 'purchase_test';
	private array $purchasesTableFields = [
		'id' => '',
		'type_id' => '',
		'' => '',
		'' => '',
		'' => '',
		];

    public function __construct(public array $params)
    {
        $this->conn = new PDO("mysql:host=" . $params['DB_ADDRESS'] . ";port=" . $params['DB_PORT'] . ";dbname=" . $params['DB_NAME'], $params['DB_USER'], $params['DB_PASS']);
    }

    public function insert(array $data, string $table)
    {
		$this->checkTable($table);
		$this->clearTable($table);
		print_r($this->generateSqlInsert($data, $table));
	}
	
	private function generateSqlInsert(array $data, string $table):string
	{
		$records = '';
		$lastRecord = array_key_last($data);
		foreach($data as $key=>$record)
		{
			$records .= '("' . $record['purchasesName'] . '","' . $record['href'] . '","' . $record['img'] . '","' . $record['title'] . '")';
			if($key != $lastRecord)
			{
				$records .= ',';
			}
		}
		$sql = 'INSERT ' . $table . '(ПОЛЯ)
			VALUES ' . $records . ';';
		
		return $sql;
	}
	
	private function clearTables()
	{
		$this->conn->exec("DELETE " . $table);
	}
	
	private function checkTables()
	{
		$fields = [
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
		];
		$result = $this->conn->query("SELECT  " . $table);
	}
	
	private function createTable()
	{
		
	}
}
