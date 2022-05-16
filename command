#!/usr/bin/php
<?php
require_once('./vendor/autoload.php');

use App\Command\StorageCommander;

unset($argv[0]);
array_values($argv);

$storageName = $argv[1];
$command = $argv[2];
$key = $argv[3];
$value = $argv[4] ?? false;

$commander = StorageCommander::getStorage($storageName);

switch ($command) {
    case 'set':
        $res = $commander->set($key, $value);
        break;
    case 'get':
        $res = $commander->get($key);
        break;
    case 'delete':
        $res = $commander->delete($key);
        break;
}
var_dump($res);
?>