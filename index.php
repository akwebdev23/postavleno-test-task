<?php
require_once('./vendor/autoload.php');
use App\Router;
$router = new Router();
// var_dump(headers_sent());
$router->handle();
?>