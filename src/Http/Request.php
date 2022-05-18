<?php

namespace App\Http;

class Request{
    public $getArray;
    public $postArray;
    public $body;
    public $uri;
    public $headers;
    public $method;
    public $jsonData;
    public $params;

    public function __construct(){
        $this->headers = getallheaders();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->getArray = $_GET;
        $this->postArray = $_POST;
        $this->body = file_get_contents('php://input');

        if(stripos($this->headers['Content-Type'], 'application/json'))
            $this->jsonData = json_decode($this->body);

        $uriString = explode('/?', $_SERVER['REQUEST_URI']);
        count($uriString) > 1 
            ? $this->uri = $uriString[0]
            :$this->uri = $_SERVER['REQUEST_URI'];
    }
}