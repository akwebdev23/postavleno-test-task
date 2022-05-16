<?php
function findClassFileRecursive($path, $className){
    $openPath = opendir($path);
    while($file = readdir($openPath)){
        if(strlen($file) > 2){
            $nextPath = $path.'/'.$file;
            if(is_dir($nextPath)){
                $result = findClassFileRecursive($nextPath, $className);
                if($result)
                    return true;
            }
            $className = explode('\\', $className)[count(explode('\\', $className)) - 1];

            if($file == $className.'.php'){
                $res = include_once($path.'/'.$file);
                return true;
            } 
        }
    }
    return false;
}
spl_autoload_register(function($className){
    findClassFileRecursive('.', $className);
});
