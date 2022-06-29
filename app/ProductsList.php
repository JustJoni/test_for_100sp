<?php

namespace TestSolution;

use Symfony\Component\DomCrawler\Crawler;

class ProductsList
{
	public string $page;
	
    public function __construct($page)
    {
        $this->page = $page;
    }

    public function parse()
    {
		$crawler = new Crawler($this->page);
		$crawler = $crawler->filter('.purchases');
		foreach ($crawler as $domElement) 
		{
			var_dump($domElement->nodeName);
		}
		
        return NULL;
    }
}
