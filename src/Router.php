<?php
namespace App;
use App\Http\Request;
use App\Http\Response;

class Router {
    protected $routes;
    public function __construct($routes){
        $this->routesHandle($routes);
    }
    public function handleRequest(Request $request){
        $response = $this->getResponse($request);
        $response->send();
    }
    public function getResponse($request){
        var_dump($request);
        if(array_key_exists($request->uri, $this->routes)){
            $className = 'App\\Controller\\'.$this->routes[$request->uri][1];
            $method = $this->routes[$request->uri][0];
            $controller = new $className();
            $response = $controller->$method($request);
        }
        else
            $response = new Response('Not found', 404);
        return $response;
    }
    public function routesHandle($routes, $prefix = ''){
        foreach ($routes as $key => $value) {
            // var_dump($value);
            // echo gettype($value[0]).'<br>';
            switch (gettype($value[0])) {
                case 'string':
                    $this->routes[$prefix.$key] = [strtolower($value[0]), $value[1]];
                    break;
                default:
                    $this->routesHandle($value, $key);
                    break;
            }                
        }
        return;
    }

}
