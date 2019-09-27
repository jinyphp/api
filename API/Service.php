<?php

namespace API;

class Service
{
    private $Request, $response;
    public function __construct($req, $res)
    {
        $this->Request = $req;
        $this->Response = $res;

        $body = $req->getBody();
        $body = json_decode($body, true);
        $body['ApiKey'] = $this->Request->headers['ApiKey'];
        echo json_encode($body);
    }
}