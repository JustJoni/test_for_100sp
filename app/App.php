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
        //здесь будем дёргать страницу, обрабатывать её по кускам и заносить всё в бд
		$download = new DownloadPage($this->env['URL_PARS']);
		$page = $download->getPage();
		
		$list = new ProductsList($page);
		$list->parse();
		
    }
}
