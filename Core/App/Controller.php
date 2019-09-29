<?php

namespace Core\App;

class Controller
{
    protected $Request, $Response;

    public function __construct()
    {
       
    }

    public function setRequest($req)
    {
        $this->Request = $req;
    }

    public function setResponse($res)
    {
        $this->Response = $res;
    }

    /**
     * 
     */
}