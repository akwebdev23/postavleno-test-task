<?php

namespace App\Storage;

class Memcache{
    protected $expire;
    protected $storage;
    protected $hash = 'main';
    public function __construct($expire, $hash)
    {
        if($hash)
            $this->hash = $hash;
        $this->expire = $expire;
        $this->storage = new \Memcache();
        $this->storage->connect('localhost', 11211);
    }
    public function set($key, $value)
    {
        $data = $this->getAll($this->hash);
        $data[$key] = $value;
        return $this->storage->set($this->hash, $data, 0, $this->expire);
    }    
    public function get($key)
    {
        return $this->storage->get($this->hash)[$key];
    }
    public function getAll()
    {
        return $this->storage->get($this->hash);
    }
    public function delete($key)
    {
        $data = $this->getAll($this->hash);
        unset($data[$key]);
        return $this->storage->set($this->hash, $data);
    }
    public function deleteAll()
    {
        return $this->storage->delete($this->hash);
    }
}