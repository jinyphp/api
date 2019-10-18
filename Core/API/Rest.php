<?php

namespace Core\API;

class Rest
{
    protected $Request, $Response;
    private $bodyjson;

    public function __construct($req, $res)
    {
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

    public function body()
    {
        return $this->bodyjson;
    }

    public function params()
    {
        
    }

    const API_PATH = "\API\Rest\\";
    private $controller;
    public function endPoint($service=null)
    {
        $name = self::API_PATH. $this->Request->Uri->first();
        return $name;
    }

    /**
     * 
     */

}