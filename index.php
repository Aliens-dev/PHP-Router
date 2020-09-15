<?php
require "./vendor/autoload.php";

use AliensDev\Controllers\HomeController;
use AliensDev\Router;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;

// Capture the Request
$request = ServerRequest::fromGlobals();

if($request->getUri()->getPath()[-1] == "/") {
    send(new Response("301",["Location"=> substr($request->getUri()->getPath(), 0,-1)]));
}
// Instantiate the Router
$router = new Router();

// Add Routes
$router->addRoute("GET","/",[HomeController::class, "index"]);
$router->addRoute("GET","/blog",[HomeController::class, "index"]);
$router->addRoute("GET","/blog/{id}",[HomeController::class, "get"]);
$router->addRoute("GET","/blog/{id}/index/{index}",[HomeController::class, "get"]);


// get The Correspondent Route
$route = $router->match($request);

// Generate Response

if(! is_null($route)) {
    $response = $router->dispatch($route);
}else {
    $response = new Response(404,[],"Not Found!");
}
// Send back the response
send($response);
