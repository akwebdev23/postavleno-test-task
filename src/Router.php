<?php
namespace App;
use App\Http\Request;
use App\Http\Response;
use stdClass;

class Router {
    protected $routes;
    protected $request;
    protected $response;
    protected $uri;
    protected $routeSetup;
    protected $routeMatch;
    protected $methodMatch;
    protected $params = [];

    public function __construct($routes, Request $request, Response $response){
        $this->routesHandle($routes);
        $this->request = $request;
        $this->response = $response;
        $this->uri = $this->slashUriEnd($this->request->uri);
        $this->routeMatch = $this->handleUri($this->uri);
        $this->methodMatch = $this->request->method === $this->routeSetup['setup'][0];
    }
    protected function routesHandle($routes, $prefix = ''){
        foreach ($routes as $key => $setup) {
            switch (gettype($setup[0])) {
                case 'string':
                    // each uri's have '/' on end
                    $route = $this->slashUriEnd($prefix.$key);
                    $this->routes[$route] = $setup;
                    break;
                default:
                    $this->routesHandle($setup, $key);
                    break;
            }                
        }
        return;
    }
    protected function handleUri($uri){
        foreach($this->routes as $route => $setup){
            $this->keys = $this->getParamKeys($route);
            if(count($this->keys)){
                $params = $this->getParams($route, $uri, $this->keys);
                // var_dump($params);
                $this->params = $params[1];
                $match = ($params[0] == $uri);
            } else 
                $match = ($route == $uri);
            if($match){
                $this->routeSetup = ['setup'=>$setup, 'params'=>$params[1]];
                // var_dump($this->routeSetup);
                return true;
            }
        }
        return (bool)$match;
    }
    protected function actionResponse(){
        $className = 'App\\Controller\\'.$this->routeSetup['setup'][1];
        $method = $this->routeSetup['setup'][2];
        $params = $this->routeSetup['params'];
        $this->request->params = $params;
        $controller = new $className();
        $response = $controller->$method($this->request, $this->response);
    }
    protected function notFoundResponse(){
        $this->response->send(404, ['message' => 'not found']);
    }
    protected function slashUriEnd($route){
        return substr($route, -1) === '/' 
            ? $route
            : $route.'/';
    }
    public function handleRequest(){
        if($this->routeMatch && $this->methodMatch)
            $this->actionResponse();
        else
            $this->notFoundResponse();
    }
    public function getParamKeys($route, $keys = []){
        $match = preg_match("/(\{.*?\})/", $route, $matches);
        if(!$match)
            return $keys;
        $keys[] = preg_replace("/(\{|\})/", '', $matches[1]);
        $route = preg_replace("/$matches[1]/", '', $route);
        return $this->getParamKeys($route, $keys);
    }
    public function getParams($route, $uri, $keys){
        $route = preg_replace('/\//', '\/', $route);
        $pregPattern = preg_replace('/\{.*?\}/', '(.+?)', $route);
        $match = preg_match("/$pregPattern/", $uri, $matches);
        // var_dump($pregPattern);
        // var_dump($uri);
        // var_dump($matches);
        $params = [];
        if($match){
            // var_dump($matches[0] == $uri);
            array_walk($keys, function($item, $index)use($matches, &$params){
                // var_dump($matches);
                // var_dump($index+1);
                if($matches[$index+1])
                    $params[$item] = $matches[$index+1];
                // var_dump($params);
            });
            // var_dump($params);
        }
        // var_dump($params);
        return [$matches[0], $params];
    }
    public function getRoutes(){
        return $this->routes;
    }
    public function getUri(){
        return $this->uri;
    }
    public function getRouteSetup(){
        return $this->routeSetup;
    }
    public function getRequest(){
        return $this->request;
    }
    public function getResponse(){
        return $this->response;
    }
}
