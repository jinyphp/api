<?php
/**
 * 
 */
namespace Core\Http;

class URI
{
    private $uri;
    private $uris;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        
        $this->uris = explode("/", trim($this->uri, "/"));
    }

    /**
     * uri 문자열을 반환합니다.
     */
    public function getURI()
    {
        return $this->uri;
    }

    /**
     * uri 배열을 반환합니다.
     */
    public function getURIS()
    {
        return $this->uris;
    }

    public function first()
    {
        return isset($this->uris[0])?$this->uris[0]:null;
    }

    public function second()
    {
        return isset($this->uris[1])?$this->uris[1]:null;
    }

    public function third()
    {
        return isset($this->uris[2])?$this->uris[2]:null;
    }


}
