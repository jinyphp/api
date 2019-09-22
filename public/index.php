<?php

//오토로드
const JINYLOAD_FILE = __DIR__.DIRECTORY_SEPARATOR."../loading.php";
if(file_exists(JINYLOAD_FILE)) {
    require_once JINYLOAD_FILE;
} else die("cannot load loading files..");


/**
 * Http
 * Request, Response
 */
function http_init()
{
    $req = new \Core\Http\Request;
    $res = new \Core\Http\Response($req);
    return [$req, $res];
}

list($req, $res) = http_init();

if ($req->isTypeJson()) {
    echo "json 처리동작";

    
} else {
    echo "웹동작";
}

echo "jinyapi";