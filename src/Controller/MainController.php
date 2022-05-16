<?php

namespace App\Controller;
use App\Http\Response;

class MainController{
    public function get(){
        return new Response([], 200, 'json');
    }
}