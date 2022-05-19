<?php

namespace Proxy\Config;

use Proxy\Main\Core;

class Base extends Core
{
    public function __construct()
    {
        $this->setDomain();
        $this->config();
    }

    public function config()
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Domain');

        if (!$this->getDomain()) {
            echo $this->httpResponseCode(400);
            exit;
        }
    }
}
