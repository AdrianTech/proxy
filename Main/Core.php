<?php

namespace Proxy\Main;

abstract class Core
{
    protected $domain = "";

    public function httpResponseCode(int $code): int
    {
        return http_response_code($code);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function setDomain()
    {
        $this->domain = getallheaders()['domain'] ?? false;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }
}
