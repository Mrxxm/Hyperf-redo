<?php


namespace Xxm\HttpServer;


class Server
{
    public function onRequest($request, $response)
    {
        var_dump($request);exit;
    }
}