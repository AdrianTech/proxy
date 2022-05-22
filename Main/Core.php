<?php

namespace Proxy\Main;

abstract class Core
{

    public function httpResponseCode(int $code): int
    {
        return http_response_code($code);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getAllHeaders()
    {
        return getallheaders();
    }

    public function getBody()
    {
        return json_decode(file_get_contents("php://input"), true);
    }
}
