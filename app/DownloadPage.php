<?php

namespace TestSolution;

use GuzzleHttp;

class DownloadPage
{

    public function __construct(public string $url)
    {
        
    }

    public function getPage():string
    {
		$client = new GuzzleHttp\Client([
		  'base_uri' => $this->url
		]);
		$response = $client->request('GET', '/', [
			'delay' => 10,
			'stream' => true,
			'read_timeout' => 10,
			'synchronous' => true,
			]);
		$page = $response->getBody()->getContents();
		
        return $page;
    }
}
