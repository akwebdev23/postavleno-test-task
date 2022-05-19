<?php

namespace App\Storage;
use App\Exception\StorageException;

class Memcache extends Storage{
    public function __construct($expire)
    {
        $this->expire = $expire;
        $this->storage = new \Memcache();
        if(!$this->storage->connect(STORAGE_HOST, STORAGE_PORT))
            throw new StorageException("Storage connect error", 500);
    }
    public function add($key, $value, $hash = 'main')
    {
        $data = $this->getAll($hash);
        $data[$key] = $value;
        return $this->get($key) ? false : $this->storage->set($hash, $data, 0, $this->expire);
    } 
    public function set($key, $value, $hash = 'main')
    {
        $data = $this->getAll($hash);
        $data[$key] = $value;
        return $this->storage->set($hash, $data, 0, $this->expire);
    }    
    public function get($key, $hash = 'main')
    {
        return $this->storage->get($hash)[$key];
    }
    public function getAll($hash = 'main')
    {
        return $this->storage->get($hash);
    }
    public function delete($key, $hash = 'main')
    {
        $data = $this->getAll($hash);
        unset($data[$key]);
        return $this->storage->set($hash, $data);
    }
    public function deleteAll($hash = 'main')
    {
        return $this->storage->delete($hash);
    }
}