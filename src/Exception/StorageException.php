<?php

namespace App\Exception;

class StorageException extends \Exception{
    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }
}