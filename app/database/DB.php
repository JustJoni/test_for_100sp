<?php

namespace TestSolution;

use PDO;

class DB
{
	private $conn;

    public function __construct(public array $params)
    {
        /*$this->conn = new PDO("mysql:host=" . $params['DB_ADDRESS'] . ";port=" . $params['DB_PORT'] . ";dbname=" . $params['DB_NAME'], $params['DB_USER'], $params['DB_PASS']);*/
    }

    public function insert(array $data, string $table)
    {
		print_r($this->sqlGenerate($data, $table));
	}
	
	private function sqlGenerate(array $data, string $table):string
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
	
	private function clearTable()
	{
		
	}
	
	private function checkTable()
	{
		
	}
	
	private function createTable()
	{
		
	}
}
