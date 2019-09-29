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
        switch($this->conf->endpoint->name){
            case "header":
                $controller_name = "\API\Controller\\". $this->Request->headers['Resource'];
                break;
            case "uri";
                $controller_name = "\API\Controller\\". $this->Request->Uri->first();
                break;
            case "message";
                $this->request_body = $this->Request->getBody();
                $this->request_body = json_decode($this->request_body);
                $controllerKey = $this->conf->endpoint->controller;
              
                $controller_name = "\API\Controller\\". $this->request_body->$controllerKey;
                break;
            default:
                echo "endpoint를 찾을 수 없습니다.";
                break;

        }

        echo $controller_name;
        exit;

        if ($script = $this->isEndpointJson($controller_name)) {
            switch ($script->script) {
                case "node":
                    $this->controllerNode();
                    break;
            }
        } else {
            // 컨트롤러 호출
            $this->controllerPHP($controller_name); 
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
     * PHP 컨트롤러 처리
     */
    public function controllerPHP($name)
    {
        $controller = $this->factory($name);
        
        $controller->setRequest($this->Request);    // Request 전달
        $controller->setResponse($this->Response);  // Response 전달

        $method = $this->Request->isMethod();
        echo $controller->$method();
    }

    /**
     * Node 컨트롤러
     */
    public function controllerNode($name)
    {
        echo "node를 실행합니다.";
        exit;
    }

    /**
     * 컨트롤러 생성 팩토리
     */
    public function factory($name)
    {
        if(file_exists("..".$name.".php")) {
            return new $name;
        } else {
            echo "컨트롤러 파일이 존재하지 않습니다.";
            exit;
        }
        
    }

    /**
     * 
     */
}