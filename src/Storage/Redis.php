<?php

namespace App\Storage;

use App\Exception\StorageException;

class Redis extends Storage{
    public function __construct($expire)
    {
        $this->expire = $expire;
        $this->storage = new \Redis();
        if(!$this->storage->connect('127.0.0.1', 6379))
            throw new StorageException("Storage connect error", 500);
    }
    public function add($key, $value, $hash = 'main'){
        if(!$key || !$value)
            throw new StorageException('add:missed parameters', 500);
        $result = $this->storage->hSetNx($hash, $key, $value);
        $this->storage->expire($hash, $this->expire);
        return $result;
    } 
    public function set($key, $value, $hash = 'main'){
        if(!$key || !$value)
            throw new StorageException('set:missed parameters', 500);
        $result = $this->storage->hSet($hash, $key, $value);
        $this->storage->expire($hash, $this->expire);
        return $result;
    }    
    public function get($key, $hash = 'main')
    {
        if(!$key)
            throw new StorageException('get:missed parameters', 500);
        return $this->storage->hGet($hash, $key);
    }
    public function getAll($hash = 'main')
    {
        return $this->storage->hGetAll($hash);
    }
    public function delete($key, $hash = 'main')
    {
        if(!$key)
            throw new StorageException('delete:missed parameters', 500);
        return $this->storage->hDel($hash, $key);
    }
    public function deleteAll($hash = 'main')
    {
        return $this->storage->del($hash);
    }
}