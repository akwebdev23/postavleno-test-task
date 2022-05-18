<?php

$routes = [
    '/' => ['GET', 'MainController', 'main'],
    '/api' => [
        '/redis' => ['GET', 'MainController', 'get'],
        '/redis/{key}' => ['DELETE', 'MainController', 'delete'],
    ]        
];