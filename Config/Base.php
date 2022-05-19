<?php

namespace Proxy\Config;

class Base
{
    public $domainID = "";
    public function __construct()
    {
        $this->domainID = getallheaders()['domain'] ?? false;
        $this->config();
    }

    private function config()
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Domain');

        if (!$this->domainID) {
            echo $this->httpResponseCode(400);
            exit;
        }
    }

    public function httpResponseCode(int $code): int
    {
        return http_response_code($code);
    }
}
