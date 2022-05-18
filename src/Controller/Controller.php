<?php

namespace App\Controller;

use App\Storage\Storage;

use function Composer\Autoload\includeFile;

abstract class Controller{
    protected $storage;
    public function __construct(){
        $this->storage = Storage::getStorage(STORAGE);
    }
    public static function includeTemplate($path){
        include($_SERVER['DOCUMENT_ROOT'].'/src/Public/'.$path);
    }
}