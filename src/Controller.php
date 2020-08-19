<?php

namespace Jiny\Api;

class Controller 
{
    protected $Http;
    protected $conf;

    protected function conf($file=null)
    {
        if ($file) {
            $this->conf = \jiny\json_get_array($file);
        }        
    }
}