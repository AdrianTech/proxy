<?php

namespace Proxy\Main;

use Proxy\Config\Base as Config;

class App extends Core
{
    public Operate $operate;
    public Config $config;

    public function __construct()
    {
        $this->config = new Config();
        $this->operate = new Operate($this->config);
        $this->start();
    }

    public function start()
    {
        echo $this->operate->getData();
    }
}
