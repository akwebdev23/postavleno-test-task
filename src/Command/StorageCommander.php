<?php

namespace App\Command;

class StorageCommander{
    // globalExpire set lifetime in seconds
    static function getStorage($storageName, $globalExpire = 3600, $hash = false){
        $className = 'App\\Storage\\'.ucfirst($storageName);
        return new $className($globalExpire, $hash);
    }
}