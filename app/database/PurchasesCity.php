<?php

namespace TestSolution;

class PurchasesCity extends DB
{
    protected function generateSqlToInsert(array $data, string $table): string
    {
        $records = '';
		$columns = '';
        $lastRecord = array_key_last($data);
		foreach ($data as $columnName=>$record) {
			if ($columnName != $lastRecord) {
				$records .= '"'.$record.'"'.',';
				$columns .= $columnName.',';
			}
			else {
				$records .= '"'.$record.'"';
				$columns .= $columnName;
			}
		}
        $sql = 'INSERT INTO '.$table.' ('.$columns.
			') VALUES ('.$records.')';

        return $sql;
    }
}
