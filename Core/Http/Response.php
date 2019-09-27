<?php
namespace Core\Http;

class Response
{
    private $Request;

    public function __construct($req)
    {
        $this->Request = $req;
    }

    public function applicationJson($body=null)
    {
        
        // echo json_encode($body);
    }

    // 화면출력
    public function send()
    {
        $this->sendHeaders();
        $this->sendContents();
        $this->terminate();
    }

    private function sendHeaders()
    {
        if ($this->Request->contentType() == "application/json") {
            header('Content-Type: application/json');
        } else {
            header("content-type: text/html");
        }
    }

    private function sendContents()
    {
        // 출력 버퍼값 화면 전송
        $out = \ob_get_clean();
        echo $out;
    }

    private function terminate()
    {
        // echo "종료";
    }
}