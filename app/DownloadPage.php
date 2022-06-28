<?php

namespace TestSolution;

use GuzzleHttp;

class DownloadPage
{
	public string $url;
	
    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getPage()
    {
		$client = new GuzzleHttp\Client([
		  'base_uri' => $this->url
		]);
		$response = $client->request('GET');
		$page = $response->getBody()->getContents();
		
        return $page;
    }
}
