<?php

namespace TestSolution;

use Symfony\Component\DomCrawler\Crawler;

class ProductsList
{
	
    public function __construct(private string $page)
    {
        
    }

    public function parse()
    {
		$normalBlocks = $this->parsePurchasesBlocks();
		$sliderBlocks = $this->parsePurchasesSliderBlocks();
		$blocks = array_merge($normalBlocks, $sliderBlocks);
		
		
		foreach ($normalBlocks as $domElement) 
		{
			print_r($domElement);
		}
		
		
        return NULL;
    }
	
	private function parsePurchasesBlocks():array
	{
		$crawler = new Crawler($this->page);
		$data = $crawler->filter('div.purchases.block')->each(function ($node) {
			$purchasesName = '';
			$blocks = [];
			$purchasesName = $node->filter('h2 > a')->innerText('Default');			
			$blocks = $node->filter('div.purchase-block')->each(function ($nodeChild) use($purchasesName) {
				$href = '';
				$img = '';
				$title = '';
			
				$href = $nodeChild->filter('.properties > div.name > a')->attr('href');
				$img = $nodeChild->filter('img')->attr('src');
				$title = $nodeChild->filter('.properties > div.name > a')->innerText('Default');
				
				return compact('purchasesName','href','img','title');
			});

			return $blocks;
		});
		
		return $data;
	}
	
	private function parsePurchasesSliderBlocks():array
	{
		$crawler = new Crawler($this->page);
		$data = $crawler->filter('div.purchases')->eq(3)->each(function ($node) {
			$purchasesName = '';
			$blocks = [];
			$purchasesName = $node->filter('h2.title')->innerText('Default');
			$blocks = $node->filter('div.purchase-slider > div.purchase-slider-item')->siblings()
						->each(function ($nodeChild) use($purchasesName) {
				$href = '';
				$img = '';
				$title = '';
			
				$href = $nodeChild->filter('a.purchase-slider-item__image')->attr('href');
				$img = $nodeChild->filter('a.purchase-slider-item__image')->attr('style');
				$title = $nodeChild->filter('div.purchase-slider-item > a.purchase-slider-item__title')->innerText('Default');
				
				return compact('purchasesName','href','img','title');
			});

			return $blocks;
		});
		
		return $data;
	}
	
}
