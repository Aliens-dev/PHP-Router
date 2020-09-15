<?php


namespace AliensDev;


use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

interface RouterInterface
{

    public function match(Request $request);

    public function addRoute(string $method, string $url, callable $callable);

    public function dispatch(Route $route): Response;

}