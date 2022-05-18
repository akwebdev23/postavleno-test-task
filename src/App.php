<?php

namespace App;

use App\Http\Request;
use App\Http\Response;
use App\Router;

class App {
    protected $router;
    protected $request;
    protected $response;

    public function __construct(){
        require_once('./src/routes.php');
        $this->request = new Request;
        $this->response = new Response;
        $this->router = new Router($routes, $this->request, $this->response);
    }
    public function start(){
        try {
            $this->router->handleRequest();
        } catch (\Throwable $th) {
            $this->response->send(500, ['message'=>$th->getMessage()]);
        }
    }
    public function getRouter(){
        return $this->router;
    }
}