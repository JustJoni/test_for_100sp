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
		if (is_readable($envFile)) 
		{
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) 
			{
                list($name, $value) = explode('=', $line);
                $this->env[$name] = $value;
            }
        }
		else
		{
			print_r("\n Не найден файл с настройками БД! Проверьте наличие файла по адресу " . $this->envFile . "\n");
		}
    }

    public function run()
    {        
		$page = $this->getPage();
		$list = $this->getProductList($page);
		$productList = $list->productList;
		$productTypeList = $this->getProductTypeList($list);
		$this->recordProductsToDb($productList);	
    }
	
	private function getPage():string
	{
		$download = new DownloadPage($this->env['URL_PARS']);
		$page = $download->getPage();
		
		return $page;
	}
	
	private function getProductList(string $page):ProductsList
	{
		$list = new ProductsList($page);
		$list->getProductList();
		
		return $list;
	}
	
	private function getProductTypeList(ProductsList $list):array
	{
		$productTypeList = array();
		$productTypeList = $list->getProductTypeList($list->productList);

		return $productTypeList;
	}
	
	private function recordProductsToDb(array $data)
	{
		$db = new DB($this->env);
		$db->insert($data);
	}
}
