<?php

namespace TestSolution;

use GuzzleHttp;

class DownloadPage
{
    public function __construct(public string $baseUrl, public string $pageUrl)
    {
    }

    public function getPage(): string
    {
        $client = new GuzzleHttp\Client(array(
			'allow_redirects'=>true,
			'base_uri' => $this->baseUrl,
        ));
        $response = $client->request('GET', $this->pageUrl, array(
            'delay' => 10,
            'stream' => true,
            'read_timeout' => 10,
            'synchronous' => true,
            ));
        $page = $response->getBody()->getContents();

        return $page;
    }
}
