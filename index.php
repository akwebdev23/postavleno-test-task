<?php
// без composer
// require_once('./class_auto_load.php');
require_once('./vendor/autoload.php');

use App\App;

define('STORAGE', 'redis');
define('STORAGE_HOST', '127.0.0.1');
define('STORAGE_PORT', 6379);
define('EXPIRE', 3600);

$app = new App();
$app->start();
?>