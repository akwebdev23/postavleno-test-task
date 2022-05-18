#!/usr/bin/php
<?php
require_once('./vendor/autoload.php');

use App\Storage\Storage;

define('EXPIRE', 3600);

unset($argv[0]);
array_values($argv);

$storageName = $argv[1];
$command = $argv[2];
$key = $argv[3] ?? '';
$value = $argv[4] ?? '';

try {
    $commander = Storage::getStorage($storageName);
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
    echo $res !== false ? "success\n" : "failed\n";
} catch (\Throwable $th) {
    $res = $th->getMessage();
    echo $res."\n";
}
?>