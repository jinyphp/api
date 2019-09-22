<?php
/*
 * This file is part of the jinyAPI package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Http;

/**
 * HTTP Request 처리
 */
class Request implements ContentType
{
    private $contentType;
    private $body;
    private $method;

    private $reqid;
    
    
    /**
     * Request 생성자
     * 
     */
    public function __construct()
    {
        // 출력버퍼 제한
        \ob_start();

        $this->contentType = $this->contentType();
        $this->method = $this->isMethod();

        // RequestBody를 읽어 저장합니다.
        $handler = fopen("php://input","r");
        $this->body = stream_get_contents($handler);

    }

    /**
     * 리퀘스트 요청정보를 DB에 기록합니다. 
     */
    public function log($dbo)
    {
        $dbo->table("log_api")->insert([
                'uri' => $_SERVER['REQUEST_URI'],
                'method' => $this->method,
                'contentType' => $this->contentType,
                'reqBody'=> addslashes($this->body)
            ],
            $matching=true, 
            $create=true
        );

        $this->reqid = $dbo->lastID();
    }

    /**
     * request 스트림 body
     */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * content-Type
     */
    public function contentType()
    {
        if(!$this->contentType){
            $this->contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : null;
        }        
        return $this->contentType;
    }

    public function isTypeJson()
    {
        if ($this->contentType() == self::APPLICATION_JSON) return true;
        else return false;
    }

    public function isTypeHtml()
    {
        if ($this->contentType() == "text/html") return true;
        else return false;
    }

    public function isMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }





    
}