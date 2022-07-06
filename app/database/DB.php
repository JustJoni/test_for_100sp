<?php

namespace TestSolution;

use PDO;

class DB
{
	private PDO $conn;
	
    public function __construct(public array $params)
    {
        $this->conn = new PDO("mysql:host=" . $params['DB_ADDRESS'] . ";port=" . $params['DB_PORT'] . ";dbname=" . $params['DB_NAME'], $params['DB_USER'], $params['DB_PASS']);
    }

    public function insert(array $data, string $table, int $arrayLvl)
    {
		$check = $this->checkTable($table);
		if($check)
		{
			
		}
		$this->clearTable();
		print_r($this->generateSqlListToInsert($data));
	}
	
	private function generateSqlListToInsert(array $data, string $table):string
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
	
	private function clearTables(string $table)
	{
		$this->conn->exec("DELETE FROM" . $table);
	}
	
	private function checkTable(string $table):bool
	{
		$this->conn->query("USE information_schema;");
		$result = $this->conn->query('SELECT COUNT(*) AS res FROM information_schema.tables WHERE table_name = "' . $table . '"')->fetch();
		$this->conn->query("USE " . $this->params['DB_NAME']);

		return $result['res'];
	}
	
	private function createTable()
	{
		
	}
}
