<?php

namespace Proxy\Config;

use Proxy\Main\Operate;

class Base
{
    public $domainID = "";
    public string $fullUrl = "";
    public function __construct()
    {
        $this->domainID = getallheaders()['domain'] ?? false;
        $this->config();
    }


    private function config()
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET,OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Domain');
        $this->full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if (!$this->domainID) {
            echo Operate::httpResponseCode(400);
            exit;
        }
    }
}
