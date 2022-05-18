<?php

namespace Proxy\Main;

use GuzzleHttp\Client;
use Proxy\Config\Base as Config;

class Operate
{
    public Config $config;
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * Get data from external API by using Guzzle HTTP Client
     * @param string $method
     * @param string $url
     */
    public function getData(): string
    {
        $url = $this->processUrl();
        $client = new Client();
        $res = $client->request($this->getMethod(), $url);
        return $res->getBody()->getContents();
    }

    /**
     * This function processes the incoming request and return final api uri
     */
    public function processUrl(): string
    {
        $params = str_replace(['api/'], [''], $_SERVER['REQUEST_URI']);
        $filtered = $this->filterWebsites()[0] ?? false;
        if (!$filtered) {
            return self::httpResponseCode(404);
        }
        $request_uri = "{$params}&{$filtered['api_key_name']}={$filtered['key_value']}";
        $finalUri = "{$filtered['base_external_url']}" . $request_uri;
        return $finalUri;
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public static function httpResponseCode(int $code): int
    {
        return http_response_code($code);
    }


    public function filterWebsites()
    {
        require dirname(__DIR__) . '/store/websites.php';
        $filtered = array_values(array_filter($websites, function ($website) {
            if ($website['base_url'] === $this->config->domainID) {
                return $website;
            }
        }));
        if (count($filtered) === 0) {
            return null;
        }
        return $filtered;
    }
}
