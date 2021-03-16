<?php


namespace Xxm\HttpServer;


class Server
{
    public function onRequest($request, $response)
    {
        $response->header('Content-Type', 'text/html; charset=utf-8');
        $response->end('<h1>Hello Swoole. #' . 'Xxm' . '</h1>');
    }
}