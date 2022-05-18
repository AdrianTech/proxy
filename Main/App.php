<?php

namespace Proxy\Main;

use GuzzleHttp\Client;

class App
{

    public function __construct()
    {
        $this->start();
    }


    public function start()
    {
        echo "Server started...";
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Get data from external API by using Guzzle HTTP Client
     * @param string $method
     * @param string $url
     */
    public function getData(string $method, string $url): array
    {
        $client = new Client();
        $res = $client->request($method, $url);
        return $res->getBody()->getContents();
    }


    public function httpResponseCode($code)
    {
        return http_response_code($code);
    }
}
