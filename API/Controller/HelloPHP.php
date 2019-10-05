<?php
namespace API\Controller;

class HelloPHP extends \Core\API\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function post()
    {
        return json_encode([
            "hello PHP 컨트롤러 입니다."
        ]);
    }

}