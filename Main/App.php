<?php

namespace Proxy\Main;

class App
{
    public Operate $operate;

    public function __construct()
    {
        $this->operate = new Operate();
        $this->start();
    }


    public function start()
    {
        echo $this->operate->getData();
    }
}
