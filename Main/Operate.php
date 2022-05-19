<?php

namespace Proxy\Main;

use Exception;
use GuzzleHttp\Client;
use Proxy\Config\Base as Config;

class Operate extends Core
{
    public function __construct(Config $config)
    {
        $this->setDomain();
        $this->config = $config;
    }

    /**
     * Get data from external API by using Guzzle HTTP Client
     */
    public function getData(): ?string
    {
        try {
            $url = $this->processUrl();
            $client = new Client();
            $res = $client->request($this->getMethod(), $url);
            return $res->getBody()->getContents();
        } catch (Exception $e) {
            return "Not found";
        }
    }

    /**
     * This function processes the incoming request and return final api uri
     */
    public function processUrl(): string
    {
        $params = str_replace(['api/'], [''], $_SERVER['REQUEST_URI']);
        $filtered = $this->filterWebsites()[0] ?? false;
        if (!$filtered) {
            return $this->httpResponseCode(404);
        }
        return "{$filtered['base_external_url']}{$params}&{$filtered['api_key_name']}={$filtered['key_value']}";
    }


    public function filterWebsites(): ?array
    {
        require dirname(__DIR__) . '/store/websites.php';
        $filtered = array_values(array_filter($websites, function ($website) {
            if ($website['base_url'] === $this->getDomain()) {
                return $website;
            }
        }));
        if (count($filtered) === 0) {
            return null;
        }
        return $filtered;
    }
}
