<?php

$routes = [
    '/' => ['GET', 'MainController'],
    '/api' => [
        '/redis' => ['GET', 'MainController']
    ]        
];