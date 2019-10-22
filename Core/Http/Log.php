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
 * HTTP 로그
 */
class Log
{
    private $Request;
    private $Response;

    public function __construct($req)
    {
        $this->Request = $req;
        // echo "http log<br>";
        // echo $this->Request->Uri->getURI();
    }

    /**
     * 리퀘스트 요청정보를 DB에 기록합니다. 
     */
    const LOG = "api_log";
    public function log2db($dbo):int
    {
        $data = [
            'uri' => $this->Request->Uri->getURI(),
            'method' => $this->Request->isMethod(),
            'contentType' => $this->Request->contentType(),
            'reqBody'=> addslashes($this->Request->getBody())
        ];

        $dbo->table(self::LOG)->insert($data)->createAuto()->run($data);
        

        return $dbo->lastID();
    }

    /**
     * 
     */
}