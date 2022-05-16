<?php
require_once('./vendor/autoload.php');

use App\Http\Request;
use App\Router;

require_once('./src/routes.php');
$request = new Request;
$router = new Router($routes);
$router->handleRequest($request);

?>