<?php

namespace AliensDev;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use function GuzzleHttp\Psr7\str;
use function Http\Response\send;

class Router implements RouterInterface
{
    /**
     * List of routes
     * @var array routes
     */
    private $routes;


    /**
     * Match/Find the correspondent route
     * @param Request $request
     * @return mixed|null
     */
    public function match(Request $request)
    {
        foreach ($this->routes as $route) {
            $route->setMatchUri($request->getUri()->getPath());
            if(strtolower($route->getMethod()) === strtolower($request->getMethod())) {
                if($request->getUri()->getPath() === $route->getUrl()) {
                    return $route;
                }

                $routeSlashExplode = explode("/",$route->getUrl());
                $requestUrlSlashExplode = explode("/", $request->getUri()->getPath());

                if(count($routeSlashExplode) === count($requestUrlSlashExplode)) {
                    $vector = $this->getVector($routeSlashExplode,$requestUrlSlashExplode);
                    if(count($vector)) {
                        $route->setParams($vector);
                        return $route;
                    }

                }
            }
        }
        return null;
    }

    /**
     * map the route to request URI and get the params
     * @param $route
     * @param $uri
     * @return array
     */
    private function getVector($route, $uri) {
        $vector = [];
        $regex = "/[a-zA-Z0-9\-]+/";
        for($i=0;$i<count($route);$i++) {
            if(strlen($route[$i]) > 0 && $route[$i][0] === '{') {
                preg_match($regex, $route[$i],$needle);
                array_push($vector , $uri[$i]);
            }
        }
        return $vector;
    }

    /**
     * add routes to the array
     * @param string $method
     * @param string $url
     * @param callable $callable
     * @return Route
     */
    public function addRoute(string $method, string $url, $callable)
    {
        $route = new Route($method,$url,$callable);
        $this->routes [] = $route;
        return $route;
    }

    /**
     * dispatch a route to the corresponding callback
     * @param Route $route
     * @param Request|null $request
     * @return Response
     */
    public function dispatch(Route $route, Request $request = null): Response
    {
        $callback = $route->getCallable();
        $params =  array_merge([$request],$route->getParams());
        $response = call_user_func_array($callback,$params);
        if(is_string($response)) {
            return new Response('200',[],$response);
        }
        var_dump($response);
        return $response;
    }

}