<?php

namespace TestSolution;

use Symfony\Component\DomCrawler\Crawler;

class ProductsList
{
    public array $productList;
	public string $city;

    public function __construct(private string $page)
    {
		$this->city = $this->getCity($page);
    }
	
	private function getCity(string $page):string
	{
		$city = '';
		$crawler = new Crawler($page);
		$city = $crawler->filter('.city-info .delivery a.city-selector-widget-link')->text('Не распознан');
		
		return $city;
	}

    public function getProductList()
    {
        $normalBlocks = $this->parsePurchasesBlocks();
        $sliderBlocks = $this->parsePurchasesSliderBlocks();
        $this->productList = array_merge($normalBlocks, $sliderBlocks);
    }

    public function getProductTypeList(array $productList): array
    {
        $productTypeList = array();
        foreach ($productList as $key => $product) {
            $productTypeList[$product['purchasesType']] = $product['purchasesType'];
        }

        return $productTypeList;
    }

    private function parsePurchasesBlocks(): array
    {
        $blocks = array();
        $data = array();
        $crawler = new Crawler($this->page);
        $classes = array(
            'parentBlocksClasses' => 'div.purchases.block',
            'purchasesClasses' => 'h2 > a',
            'childrenBlocksClasses' => 'div.purchase-block',
            'hrefClasses' => '.properties > div.name > a',
            'imgClasses' => 'img',
            'titleClasses' => '.properties > div.name > a',
        );
        $data = $this->parseBlocks($crawler, $classes);

        for ($i = 0; $i < 5; $i++) {
            $blocks += $this->dismantleBlocks($data[$i]);
        }

        return $blocks;
    }
	
	private function parsePurchasesSliderBlocks(): array
    {
        $blocks = array();
        $data = array();
        $crawler = new Crawler($this->page);

        $classes = array(
            'parentBlocksClasses' => 'div.purchases:not(.block)',
            'purchasesClasses' => 'h2.title',
            'childrenBlocksClasses' => 'div.purchase-slider > div.purchase-slider-item',
            'hrefClasses' => 'a.purchase-slider-item__image',
            'imgClasses' => 'a.purchase-slider-item__image',
            'titleClasses' => 'div.purchase-slider-item > a.purchase-slider-item__title',
        );
        $imgAttr = 'style';
        $data = $this->parseBlocks($crawler, $classes, $imgAttr);

        foreach ($data[0] as $key => $block) {
            $blocks[$key] = $block;
            $img = array();
            preg_match('/"(.+)"/', $block['img'], $img);
            $blocks[$key]['img'] = $img[1];
        }

        return $blocks;
    }

    private function parseBlocks(Crawler $crawler, array $classes, string $imgAttr = 'src'): array
    {
        $data = $crawler->filter($classes['parentBlocksClasses'])->each(function ($node) use ($classes, $imgAttr) {
            $purchasesType = '';
            $blocks = array();
            $purchasesType = $node->filter($classes['purchasesClasses'])->innerText('Default');
            $blocks = $node->filter($classes['childrenBlocksClasses'])->each(function ($nodeChild) use ($purchasesType, $classes, $imgAttr) {
                $href = '';
                $img = '';
                $title = '';

                $href = $nodeChild->filter($classes['hrefClasses'])->attr('href');
                $img = $nodeChild->filter($classes['imgClasses'])->attr($imgAttr);
                $title = $nodeChild->filter($classes['titleClasses'])->innerText('Default');

                return compact('purchasesType', 'href', 'img', 'title');
            });

            return $blocks;
        });

        return $data;
    }

    private function dismantleBlocks(array $blocks): array
    {
        $dBlocks = array();
        foreach ($blocks as $block) {
            $dBlocks[$block['href']] = $block;
        }

        return $dBlocks;
    }
}
