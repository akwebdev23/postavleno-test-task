<?php
require_once('./vendor/autoload.php');

use App\App;

define('STORAGE', 'redis');
define('EXPIRE', 3600);

$app = new App();
$app->start();

?>