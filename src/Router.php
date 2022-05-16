<?php
namespace App;
use App\Controller\MainController;
use App\Http\Response;

class Router {
    protected $routes;
    public function __construct()
    {
        $this->routes = [
            '/api/redis' => [MainController::class, 'get', 'GET']
        ];
    }
    public function handle()
    {
        $route = $this->routes[$_SERVER['REQUEST_URI']];
        if(!$route && $route[2] == $_SERVER['REQUEST_METHOD'])
            $response = new Response('Not found', 404);
        else {
            $handler = new $route[0];
            $method = $route[1];
            $response = $handler->$method();
        }
        $response->send();
    }
}