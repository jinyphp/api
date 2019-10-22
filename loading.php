<?php
// 글로벌 지니헬퍼
require_once __DIR__."/Core/Helper.php";

// 컴포저 오토로드
const AUTOLOAD_FILE = __DIR__."/vendor/autoload.php";
if(file_exists(AUTOLOAD_FILE)) {
    require_once AUTOLOAD_FILE;
}

// 지니 오토로드
spl_autoload_register(function($className) {
    $path = str_replace("\\", DIRECTORY_SEPARATOR, $className).".php";
    // $path = strtolower($className).".php";
    $path = __DIR__.DIRECTORY_SEPARATOR.$path;

    if(file_exists($path)) {
        require_once($path);
    } else {
        echo "Module loading: ".$path." file not found\n";
        exit;
    }
});


