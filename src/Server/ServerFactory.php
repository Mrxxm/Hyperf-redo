<?php


namespace Xxm\Server;


class ServerFactory
{
    protected $serverConfig = [];
    public function configure(array $configs)
    {
        $this->serverConfig = $configs;
        $this->getServer()->init($this->serverConfig);
    }

    protected function getServer()
    {

    }
}