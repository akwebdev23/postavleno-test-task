<?php

namespace App\Controller;

use App\Http\Request;
use App\Http\Response;

class MainController{
    public function get(Request $request){
        return new Response($request, 200, 'json');
    }
}