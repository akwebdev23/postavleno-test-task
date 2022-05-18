<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Http\Request;
use App\Http\Response;
use \Exception;
use stdClass;

class MainController extends Controller{
    public function get(Request $request, Response $response){
        $allData = $this->storage->getAll();
        if($allData !== false)
            $response->send(200, $allData);
        else 
            throw new Exception('Get error');
    }
    public function post(Request $request, Response $response){
        $result = $this->storage->add($request->params['key'], $request->params['value']);
        if($result !== false) 
            $response->send(200, [$request->params['key'] => $request->params['value']]);
        else 
            throw new Exception('Key exist');
    }
    public function delete(Request $request, Response $response){
        $key = $request->params['key'];
        $result = $this->storage->delete($key);
        if($result) 
            $response->send(200, new stdClass);
        else 
            throw new Exception('Key not found');
    }
    public function main(){
        self::includeTemplate('index.php');
    }
}