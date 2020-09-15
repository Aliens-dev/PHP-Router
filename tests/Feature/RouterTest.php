<?php

namespace Tests;

use AliensDev\Router;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private $router;

    public function setUp() : void
    {
        $this->router = new Router();
    }
    
    public function testBasicRoute()
    {
        $request = new Request('GET', '/blog');

        $this->router->addRoute('GET', '/blog', function () {
            return "blog";
        });

        $route = $this->router->match($request);
        $this->assertEquals($request->getMethod(), $route->getMethod());
        $this->assertEquals($request->getUri()->getPath(), $route->getMatchUri());

        $response = $this->router->dispatch($route);

        $this->assertEquals("blog",$response->getBody());
    }

    public function testWrongRoute()
    {
        $request = new Request('GET', '/blogger');
        $this->router->addRoute('GET', '/blog', function () {
            return "blog";
        });

        $route = $this->router->match($request);

        $this->assertNull($route);
    }

    public function testNestedRoute()
    {
        $request = new Request("GET","/blog/1");

        $this->router->addRoute("GET","/blog/{id}", function() {
            return "blog";
        });

        $route = $this->router->match($request);

        $this->assertEquals($request->getMethod(), $route->getMethod());
        $this->assertEquals($request->getUri()->getPath(), $route->getMatchUri());

        $response = $this->router->dispatch($route);

        $this->assertEquals("blog",$response->getBody());
    }

    public function testRightParamsPassed()
    {
        $request = new Request("GET","/blog/1/index/2");

        $this->router->addRoute("GET","/blog/{id}/index/{index}", function() {
            return "blog";
        });

        $route = $this->router->match($request);

        $this->assertEquals($request->getMethod(), $route->getMethod());
        $this->assertEquals($request->getUri()->getPath(), $route->getMatchUri());
        $this->assertEquals(2,count($route->getParams()));

        $this->assertArrayHasKey("id",$route->getParams());

        $response = $this->router->dispatch($route);

        $this->assertEquals("blog",$response->getBody());
    }
}