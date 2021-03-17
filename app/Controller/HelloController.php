<?php


namespace App\Controller;


class HelloController
{
    public function index()
    {
        return "Hello index!";
    }

    /**
     * @path /hello/kenrouf
     */
    public function kenrouf()
    {
        return "Hello Kenrouf!";
    }
}