<?php

namespace App\Http;

use stdClass;

class Response {
    public $responseBody;
    protected $statusCode;
    protected $headers;

    public function __construct($code = 200, $data = '', $type = 'json'){
        $this->responseBody = [
            'status' => $code > 399 ? false : true,
            'code' => $code > 399 ? 500 : 200,
            'data' => $data
        ];
        $this->statusCode = $code;
        $this->contentType = $type;
        if($type == 'text')
            $this->headers['Content-Type'] = 'text/html';
        else if($type == 'json'){
            $this->headers['Content-Type'] = 'application/json';
        }
    }
    public function send($code = null, $data = null, $type = null, $headers = null){
        foreach ($headers ? $headers : $this->headers as $key => $value) {
            header($key.':'.$value);
        }
        $code = $code ? $code : $this->statusCode;
        http_response_code($code);
        $this->responseBody = [
            'status' => $code > 399 ? false : true,
            'code' => $code > 399 ? 500 : 200
        ];
        $data ? $this->responseBody['data'] = $data : $this->responseBody;
        echo json_encode($this->responseBody);
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