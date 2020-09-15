<?php


namespace AliensDev;


use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{

    public function match(ServerRequestInterface $request);

    public function addRoute(string $method, string $url, callable $callable);

    public function dispatch(Route $route): Response;

}