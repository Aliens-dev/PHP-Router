<?php
require "./vendor/autoload.php";

use AliensDev\Controllers\HomeController;
use AliensDev\Router;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;

// Capture the Request
$request = ServerRequest::fromGlobals();

// Instantiate the Router
$router = new Router();

// Add Routes
$router->addRoute("GET","/",[HomeController::class, "index"]);

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
