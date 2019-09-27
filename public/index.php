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

/**
 * 데이터베이스 접속
 */
$dbconf = \Jiny\Database\db_conf("../dbconf.php");
if ($dbo = \Jiny\Database\db_init($dbconf)) {
    // echo "DB 접속 성공";
}


// Http 로그
$HttpLog = new \Core\Http\Log($req);
$HttpLog->log2db($dbo);

if ($req->isTypeJson()) {
    // API 동작
    // applicationType/Json
    new \API\Service($req, $res);
    
} else {
    // Application 동작
    // text/html
    new \App\Application($req, $res);
}

$res->send();
