<?php

namespace AliensDev\Controllers;
class HomeController
{
    public function index()
    {
        return "hello world";
    }

    public function get($id,$index)
    {
        echo "<pre>";
        var_dump($id['id']);
        var_dump($index);
    }
}