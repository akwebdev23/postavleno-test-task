<?php

namespace App\Storage;

class Redis{
    protected $expire;
    protected $storage;
    protected $hash = 'main';
    public function __construct($expire, $hash)
    {
        if($hash)
            $this->hash = $hash;
        $this->expire = $expire;
        $this->storage = new \Redis();
        $this->storage->connect('127.0.0.1', 6379);
    }
    public function set($key, $value)
    {
        $result = $this->storage->hSet($this->hash, $key, $value);
        $this->storage->expire($this->hash, $this->expire);
        return (bool)$result;
    }    
    public function get($key)
    {
        return $this->storage->hGet($this->hash, $key);
    }
    public function getAll()
    {
        return $this->storage->hGetAll($this->hash);
    }
    public function delete($key)
    {
        return $this->storage->hDel($this->hash, $key);
    }
    public function deleteAll()
    {
        return $this->storage->del($this->hash);
    }
}