<?php

namespace Core\API;

class Proxy
{
    protected $Request, $Response;
    private $bodyjson;

    /**
     * 싱글턴
     */
    private static $Instance;
    public static function instance()
    {
        if (!isset(self::$Instance)) {
            self::$Instance = new self();
        }

        return self::$Instance;
    }

    public function __construct($req, $res)
    {
        // echo __CLASS__;
        $this->Request = $req;
        $this->Response = $res;

        $this->bodyjson = json_decode($this->Request->getBody());
    }

    public function setRequest($req)
    {
        $this->Request = $req;
    }

    public function setResponse($res)
    {
        $this->Response = $res;
    }

    const API_PATH = "\API\Controller\\";
    private $controller;
    public function endPoint($service=null)
    {
        switch($service->name){
            case "header":
                $name = self::API_PATH. $this->Request->headers['Resource'];
                break;
            case "uri";
                $name = self::API_PATH. $this->Request->Uri->first();
                break;
            case "Message";
                $this->request_body = $this->Request->getBody();
                $this->request_body = json_decode($this->request_body);
                //print_r($this->request_body);
                
                $controllerKey = $service->controller;
                //echo $controllerKey;
              
                $name = self::API_PATH. $this->request_body->$controllerKey;
                //echo $name;
                break;
            default:
                //echo "endpoint를 찾을 수 없습니다.";
                break;

        }

        return $name;
    }

    /**
     * 
     */

}