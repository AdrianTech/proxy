<?php

namespace Proxy\Main;

use ErrorException;
use Exception;
use GuzzleHttp\Client;
use Proxy\Config\Base as Config;
use Psr\Http\Message\ResponseInterface;

class Operate extends Core
{
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Get data from external API by using Guzzle HTTP Client
     */
    public function getData(): ?string
    {
        try {
            $url = $this->processUrl();
            $res = $this->apiRequestHandle($url, $this->getBody(), $this->getAllHeaders());
            return $res->getBody()->getContents();
        } catch (Exception $e) {
            echo $e->getMessage();
            return "Not found";
        }
    }

    /**
     * This function processes the incoming request and return final api uri
     */
    public function processUrl(): string
    {
        $filtered = $this->filterWebsites()[0] ?? false;
        if (!$filtered) {
            return $this->httpResponseCode(404);
        }
        return "{$filtered['base_external_url']}{$_SERVER['REQUEST_URI']}&{$filtered['api_key_name']}={$filtered['key_value']}";
    }


    public function filterWebsites(): ?array
    {
        require dirname(__DIR__) . '/store/websites.php';
        $headers = $this->getAllHeaders();
        $filtered = array_values(array_filter($websites, function ($website) use ($headers) {
            if (array_key_exists('domain', $headers) && $website['base_url'] === $headers['domain']) {
                return $website;
            }
        }));
        if (count($filtered) === 0) return null;
        return $filtered;
    }

    private function apiRequestHandle(string $uri, $body, array $headers): ResponseInterface
    {
        $method = $this->getMethod();
        $client = new Client();

        if ($method === "get") {
            $result = $client->request($method, $uri);
        } elseif ($method === "post" || $method === "put" || $method === "patch") {
            $result = $client->request($method, $uri, [
                "headers" => $headers,
                "form_params" => $body
            ]);
        } elseif ($method === "delete") {
            $result = $client->request($method, $uri, [
                "headers" => $headers,
            ]);
        } else {
            throw new ErrorException('unsupported method');
        }

        return $result;
    }
}
