<?php

$routes = [
    '/' => ['GET', 'MainController', 'main'],
    '/api' => [
        '/redis' => ['GET', 'MainController', 'get'],
        '/redis/{key}/{value}' => ['POST', 'MainController', 'post'],
        '/redis/{key}' => ['DELETE', 'MainController', 'delete'],
    ]        
];