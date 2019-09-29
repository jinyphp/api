<?php
namespace API\Controller;

class Index extends \Core\API\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        
        $body = $this->Request->getBody();
        $body = json_decode($body, true);
        
        $body['ApiKey'] = $this->Request->headers['ApiKey'];
        echo json_encode($body);
        
        /*
        $body['message'] = "API 출력"; 
        echo json_encode($body);
        */
    }

    public function post()
    {
        echo "this is post";
        exit;
    }

    public function put()
    {

    }

    public function delete()
    {
        
    }

}