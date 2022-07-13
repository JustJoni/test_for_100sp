<?php

namespace TestSolution;

class App
{
    //набор настроек
    public array $env;

    //файл настроек
    private string $envFile;

    public function __construct($envFile)
    {
        $this->envFile = $envFile;
        if (is_readable($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {
                [$name, $value] = explode('=', $line);
                $this->env[$name] = $value;
            }
        } else {
            print_r("\n Не найден файл с настройками БД! Проверьте наличие файла по адресу ".$this->envFile."\n");
        }
    }

    public function run()
    {
		$cityes = array();
		$cityes = explode(',',$this->env['CITYES_URL_PARS']);
		$this->clearTables([$this->env['DB_TABLE_CITYES'],$this->env['DB_TABLE_TYPES'],$this->env['DB_TABLE_PURCHASES']]);
		$sqlRecordPurchasesToDb = '';
		foreach($cityes as $urlCity) {
			$page = $this->getPage($this->env['BASE_URL_PARS'],$urlCity);
			$list = $this->getProductList($page);
			$productList = $list->productList;
			$productTypeList = $this->getProductTypeList($list);
			$dataCity = ['name' => $list->city, 'url' => $urlCity];
			$cityID = $this->recordCity($dataCity, $this->env['DB_TABLE_CITYES']);
			$this->recordPurchaseTypesToDb($productTypeList, $this->env['DB_TABLE_TYPES']);
			$sqlRecordPurchasesToDb .= $this->getSQLForInsert($productList, $this->env['DB_TABLE_PURCHASES'], $cityID);
		}
		$this->recordPurchaseToDb($sqlRecordPurchasesToDb, $this->env['DB_TABLE_PURCHASES']);
    }

    private function getPage($baseUrl, $pageUrl): string
    {
        $download = new DownloadPage($baseUrl, $pageUrl);
        $page = $download->getPage();

        return $page;
    }

    private function getProductList(string $page): ProductsList
    {
        $list = new ProductsList($page);
        $list->getProductList();

        return $list;
    }

    private function getProductTypeList(ProductsList $list): array
    {
        $productTypeList = array();
        $productTypeList = $list->getProductTypeList($list->productList);

        return $productTypeList;
    }
	
	private function clearTables(array $tables)
	{
		$db = new DB($this->env);
		foreach ($tables as $table) {
			$db->clearTable($table);
		}
	}
	
	private function recordCity(array $data, string $table):int
	{
		$cityID = 0;
		$db = new PurchasesCity($this->env);
		$cityID = $db->insert($data, $table);
		
		return $cityID;
	}

    private function recordPurchaseTypesToDb(array $data, string $table)
    {
        $db = new PurchaseType($this->env);
		$db->clearTable($table);
        $db->insert($data, $table);
    }

    private function getSQLForInsert(array $data, string $table, int $cityID):string
    {
		$sql = '';
        $db = new Purchase($this->env);
        $db->setReferenceTable($this->env['DB_TABLE_TYPES']);
		$db->setCityID($cityID);
		$sql = $db->getSQL($data, $table);
		
		return $sql;
    }
	
	private function recordPurchaseToDb($sql, $table)
	{
		$db = new DB($this->env);
		$db->insert($sql, $table);
	}
}
