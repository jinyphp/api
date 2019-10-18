<?php
namespace App\Controller;

class Index extends \Core\App\Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        // echo __METHOD__;
        return $this->get();
    }

    const  RESOURCE_PATH = "../Resource/View";
    public function get()
    {
        // echo "get 입니다.";
        if (($uri = $this->Request->Uri->getURI()) == "/") {
            $filename = self::RESOURCE_PATH."/index.html";
        } else {
            $filename = self::RESOURCE_PATH.$uri.".html";
        }

        if(file_exists($filename)) {
            $body = file_get_contents($filename);
        } else {
            $body = "404 pages";
        }
        return $body;
    }
}