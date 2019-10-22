<?php

namespace Core\API;

class Service
{
    private $Request, $response;
    private $conf;

    private $request_body;

    const APIDIR = "../API/";
    public function __construct($req, $res)
    {
        $this->Request = $req;
        $this->Response = $res;

        $this->conf = $this->jsonDecodeFile(self::APIDIR."api.json");
        
    }

    /**
     * API Proxy 미들웨어 설정
     */
    private $Proxy;
    public function setProxy($name = "\Core\API\Proxy")
    {
        if (is_object($name)) {
            $this->Proxy = $name;
        } else {
            $this->Proxy = new $name ($this->Request, $this->Response);
        }        
        return $this;
    }

    /**
     * API 컨트롤러 로직 실행
     */
    public function execute()
    {
        $controller = $this->Proxy->endPoint($this->conf->endpoint);

        // 컨트롤러 호출
        switch ($this->scriptType($controller)) {
            case "node":
                $this->controllerNode($controller);
                exit;
                break;
            default:
                $this->controllerPHP($controller);
        }
    }

    /**
     * 실행 스크립트 선택
     */
    private function scriptType($name)
    {
        $name = ucfirst($name);;
        if(isset($this->Request->headers['Script'])) {
            return $this->Request->headers['Script'];

        } else if(isset($this->request_body->script)) {
            return $this->request_body->script;

        } else if ($script = $this->isEndpointJson($name)) {
            return $script->script;

        } else  {
            return "php";
        }
    }

    public function jsonDecodeFile($filename)
    {
        return json_decode(file_get_contents($filename));
    }

    public function isEndpointJson($name)
    {
        $filename = "..".$name.".json";
        if (file_exists($filename)) {
            $json = file_get_contents($filename);
            $json = json_decode($json);
            return $json;
        }
    }



    /**
     * Node 컨트롤러
     */
    public function controllerNode($name)
    {
        // echo "node를 실행합니다.";
        $filename = "..".$name.".js";
        if (file_exists($filename)) {
            exec("node ".$filename, $result);
            foreach($result as $r) {
                echo $r;
            }
        } else {
            echo "node 파일이 없습니다.";
        }
    }

    /**
     * PHP 컨트롤러 처리
     */
    public function controllerPHP($name)
    {
        $controller = $this->factory($name);
        $controller->setProxy($this->Proxy);
        $method = $this->Request->isMethod();        
        echo $controller->$method();
        // exit;
    }

    /**
     * 컨트롤러 생성 팩토리
     */
    public function factory($name)
    {
        $path = "..";
        $ext = ".php";
        $filename = str_replace("\\",DIRECTORY_SEPARATOR, $path.$name.$ext);
        // echo $filename;
        if(file_exists($filename)) {
            return new $name;
        } else {
            echo $name." 컨트롤러 파일이 존재하지 않습니다.";
            exit;
        }
        
    }

    /**
     * 
     */
}