<?php

namespace TestSolution;

use PDO;

class PurchaseType extends DB
{
	protected function generateSqlToInsert(array $data, string $table):string
	{
		$records = '';
		$lastRecord = array_key_last($data);
		foreach($data as $key=>$record)
		{
			$records .= '("' . $record . '")';
			if($key != $lastRecord)
			{
				$records .= ',';
			}
		}
		$sql = "INSERT INTO " . $table . " (name)
			 VALUES " . $records;
		
		return $sql;
	}

}
