<?php

namespace AliensDev\Controllers;
use GuzzleHttp\Psr7\Request;

class HomeController
{
    public function index(Request $request)
    {
        return "hello world";
    }

    public function get(Request $request, $id)
    {
        return "get";
    }

    public function in($request)
    {
        return "index";
    }
}