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

        $this->router->addRoute("GET","/blog/{id}/index/{index}", function($id,$index) {
            return "blog";
        });

        $route = $this->router->match($request);

        $this->assertEquals($request->getMethod(), $route->getMethod());
        $this->assertEquals($request->getUri()->getPath(), $route->getMatchUri());
        $this->assertEquals(2,count($route->getParams()));
        $this->assertCount(2,$route->getParams());
        $response = $this->router->dispatch($route);
        $this->assertEquals("blog",$response->getBody());
    }
    public function testOneNestedRouteWithOneFullRoute()
    {
        $request1 = new Request("GET","/blog/1");
        $request2 = new Request("GET","/blog/index");

        $this->router->addRoute("GET","/blog/{id}", function($request,$id) {
            return "id";
        });
        $this->router->addRoute("GET","/blog/index", function($request) {
            return "index";
        });

        $route1 = $this->router->match($request1);
        $route2 = $this->router->match($request2);

        $response1 = $this->router->dispatch($route1);
        $response2 = $this->router->dispatch($route2);

        $this->assertEquals("id",$response1->getBody());

        $this->assertEquals("id",$response2->getBody());
    }
    public function testOneNestedRouteWithOneFullRouteSorted()
    {

        $request1 = new Request("GET","/blog/2");

        $request2 = new Request("GET","/blog/index");

        $this->router->addRoute("GET","/blog/index", function($request) {
            return "index";
        });

        $this->router->addRoute("GET","/blog/{id}", function($request,$id) {
            return "id";
        });


        $route1 = $this->router->match($request1);
        $route2 = $this->router->match($request2);

        $response1 = $this->router->dispatch($route1);
        $response2 = $this->router->dispatch($route2);

        $this->assertEquals("id",$response1->getBody());

        $this->assertEquals("index",$response2->getBody());

    }
}