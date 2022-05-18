<?php

namespace App\Storage;
use App\Exception\StorageException;

abstract class Storage{
    protected $expire;
    protected $storage;
    // globalExpire set lifetime in seconds
    static function getStorage($storageName, $globalExpire = EXPIRE){
        $className = 'App\\Storage\\'.ucfirst($storageName);
        return new $className($globalExpire);
    }
    public function add($key, $value, $hash){}
    public function set($key, $value, $hash){}
    public function get($key, $hash){}
    public function delete($key, $hash){}
    public function getAll($hash){}
    public function deleteAll($hash){}
}