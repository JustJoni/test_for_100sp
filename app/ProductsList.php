<?php

namespace TestSolution;

use Symfony\Component\DomCrawler\Crawler;

class ProductsList
{
	
    public function __construct(private string $page)
    {
        
    }

    public function parse():array
    {
		$normalBlocks = $this->parsePurchasesBlocks();
		$sliderBlocks = $this->parsePurchasesSliderBlocks();
		$blocks = array_merge($normalBlocks, $sliderBlocks);
		
        return $blocks;
    }
	
	private function parsePurchasesBlocks():array
	{
		$blocks = array();
		$data = array();
		$crawler = new Crawler($this->page);
		$classes = [
			'parentBlocksClasses' => 'div.purchases.block',
			'purchasesClasses' => 'h2 > a',
			'childrenBlocksClasses' => 'div.purchase-block',
			'hrefClasses' => '.properties > div.name > a',
			'imgClasses' => 'img',
			'titleClasses' => '.properties > div.name > a',
		];
		$data = $this->parseBlocks($crawler, $classes);

		for($i = 0; $i < 5; $i++)
		{
			$blocks += $this->dismantleBlocks($data[$i]);
		}
		
		return $blocks;
	}
	
	
	private function parseBlocks(Crawler $crawler, array $classes, bool $sliderBlock = false):array
	{
		
		$data = $crawler->filter($classes['parentBlocksClasses'])->each(function ($node, $i) use ($classes, $sliderBlock) {
			if($sliderBlock && $i == 3 || !$sliderBlock)
			{
				$purchasesName = '';
				$blocks = [];
				$purchasesName = $node->filter($classes['purchasesClasses'])->innerText('Default');
				$blocks = $node->filter($classes['childrenBlocksClasses'])->each(function ($nodeChild) use($purchasesName, $classes) {
					$href = '';
					$img = '';
					$title = '';
				
					$href = $nodeChild->filter($classes['hrefClasses'])->attr('href');
					$img = $nodeChild->filter($classes['imgClasses'])->attr('src');
					$title = $nodeChild->filter($classes['titleClasses'])->innerText('Default');
					
					return compact('purchasesName','href','img','title');
				});

				return $blocks;
			}
		});
		
		return $data;
	}
	
	private function dismantleBlocks(array $blocks):array
	{
		$dBlocks = array();
		foreach($blocks as $block)
		{
			$dBlocks[$block['href']] = $block;
		}
		
		return $dBlocks;
	}
	
	private function parsePurchasesSliderBlocks():array
	{
		$blocks = array();
		$crawler = new Crawler($this->page);
		
		$classes = [
			'parentBlocksClasses' => 'div.purchases',
			'purchasesClasses' => 'h2.title',
			'childrenBlocksClasses' => 'div.purchase-slider > div.purchase-slider-item',
			'hrefClasses' => 'a.purchase-slider-item__image',
			'imgClasses' => 'a.purchase-slider-item__image',
			'titleClasses' => 'div.purchase-slider-item > a.purchase-slider-item__title',
		];
		$blocks = $this->parseBlocks($crawler, $classes, true);
		
		return $blocks[3];
	}
	
}
