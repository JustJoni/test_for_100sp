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
		$test = $crawler->filter('div.purchases.block')->each(function ($node) {
			
			if(!empty($node))
			{
				$purchasesName = $node->filter('h2 > a')->innerText('Default');
				var_dump($purchasesName);
			}
			$blocks = $node->filter('div.purchase-block')->each(function ($nodeChild) use($purchasesName) {
				$href = '';
				$img = '';
				$title = '';
			
				$href = $nodeChild->filter('.properties > div.name > a')->attr('href');
				$img = $nodeChild->filter('img')->attr('src');
				$title = $nodeChild->filter('.properties > div.name > a')->innerText('Default');

				var_dump($title);
				
				return compact('purchasesName','href','img','title');
			});
			
			
			$blocks[] = ['purchasesName' => $purchasesName];

			return $blocks;
		});
		foreach ($test as $domElement) 
		{
			print_r($domElement);
		}
		
		
        return NULL;
    }
}
