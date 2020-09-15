## PHP Router
#### How it Works
1. Capture the Request
    - $request = ServerRequest::fromGlobals();
 
2. Instantiate the Router
    - $router = new Router();
 
3. Add Routes
    - $router->addRoute("GET","/",[HomeController::class, "index"]);
 
4. get The Correspondent Route
    - $route = $router->match($request);
 
5. Generate Response
     if(! is_null($route)) {
        // if route Found !
         $response = $router->dispatch($route);
     }else {
        // if route isn't found
         $response = new Response(404,[],"Not Found!");
     }

6. Send back the response
    - send($response);
