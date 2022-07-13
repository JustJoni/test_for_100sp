<?php

namespace TestSolution;

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
}
