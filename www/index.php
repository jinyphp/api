<?php
/**
 * 오토로드
 */
const JINYLOAD_FILE = __DIR__.DIRECTORY_SEPARATOR."../loading.php";
if(file_exists(JINYLOAD_FILE)) {
    require_once JINYLOAD_FILE;
} else die("cannot load loading files..");

// 시간측정
\Jiny\TimeLog::init();

/**
 * HTTP 접속
 */
list($req, $res) = http_init();
switch($req->contentType()){
    // application/json 접속처리
    // API 동작
    case "application/json":
        $api = new \Core\API\Service($req, $res);
        // 기본 api프록시
        // $api->setProxy()->execute();

        // nugu_AI proxy
        $api->setProxy("\Jiny\Nugu\Proxy")->execute();
        /*
        $nugu = \Jiny\Nugu\Proxy::instance();
        $nugu->setRequest($req);
        $nugu->setResponse($res);        
        $api->setProxy($nugu)->execute();
        */
        break;
    default:
        // 일반동작, text/html
        $app = new \Core\App\Application($req, $res);


}

$res->send();

// 시간측정
\Jiny\TimeLog::check("end");
// echo "<pre>".\Jiny\TimeLog::output()."</pre>";







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


/**
 * 데이터베이스 접속
 */
$dbconf = \Jiny\Database\db_conf("../dbconf.php");
if ($dbo = \Jiny\Database\db_init($dbconf)) {
    // echo "DB 접속 성공";

    // Http 로그
    // $HttpLog = new \Core\Http\Log($req);
    // $HttpLog->log2db($dbo);
}