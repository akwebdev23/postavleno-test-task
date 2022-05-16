<?php

namespace App\Http;

class Request{
    public $getArray;
    public $postArray;
    public $phpInput;
    public $uri;
    public function __construct(){
        $this->getArray = $_GET;
        $this->postArray = $_POST;
        $this->phpInput = file_get_contents('php://input');
        $uriString = explode('/?', $_SERVER['REQUEST_URI']);
        count($uriString) > 1 
            ? $this->uri = $uriString[0]
            :$this->uri = $_SERVER['REQUEST_URI'];
    }
}