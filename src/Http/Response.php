<?php

namespace App\Http;

class Response {
    protected $responseBody;
    protected $statusCode;
    protected $headers;

    public function __construct($body, $code, $type = 'text'){
        $this->responseBody = $body;
        $this->statusCode = $code;
        $this->contentType = $type;
        if($type == 'text')
            $this->headers['Content-Type'] = 'text/html';
        else if($type == 'json'){
            $this->headers['Content-Type'] = 'application/json';
            $this->responseBody = json_encode($body);
        }
    }
    public function send()
    {
        foreach ($this->headers as $key => $value) {
            header($key.':'.$value);
        }
        http_response_code($this->statusCode);
        echo $this->responseBody;
    }
    public function setHeader($name, $value){
        $this->headers[$name] = $value;
    }
    public function setStatusCode($value){
        $this->statusCode = $value;
    }    
    public function setBody($value){
        $this->body = $value;
    }
}