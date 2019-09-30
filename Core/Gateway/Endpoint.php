<?php
namespace Core\Gateway;

/**
 * Endpoint
 */

 class Endpoint
 {
    private $Request; 
    public function __construct($req)
    {
        $this->Request = $req;
    }

    /**
     * 엔트포인트 감지
     */
    public function detect($conf)
    {
        $method = "end".$conf->endpoint->name;
        return $this->$method($conf);
    }

    const CONTOLLER_PATH = "\API\Controller\\";
    public function endMessage($conf)
    {
        $request_body = $this->Request->getBody();
        $request_body = json_decode($this->request_body);
        $key = $conf->endpoint->controller;
        
        return self::CONTOLLER_PATH . $this->request_body->$key;
    }

    public function endUri($conf)
    {
        return self::CONTOLLER_PATH . $this->Request->Uri->first();
    }

    public function endHeader($conf)
    {
        return self::CONTOLLER_PATH . $this->Request->headers['Resource'];
    }

    /**
     * 
     */

}