<?php

namespace Jiny\API;

class ApplicationJson
{
    public $type = "api"; // www 또는 api 
    private $http;
    public $params=[];
    public function __construct()
    {
        $this->http = \jiny\http();
    }

    /**
     * 호출시작 진입점
     */
    public function main()
    {
        // API 처리
        $method = \jiny\http\request()->method();
        if($method == "GET") {
            $data = []; // body 내용이 없음.
            $endpoint = $this->endpoint();
            $r = \jiny\route()->main($endpoint);
        } else 
        // POST, PUT, DELETE 그외 메소드 요청
        {
            $data = $this->reqBody();
            $endpoint = $this->endpoint($data);
        }
        
        //jsonRoute
        $r = \jiny\route()->main($endpoint);
        return $this->paerser($r, $data);
        

    }

    /**
     * 컨트롤러 생성, 호출
     */
    private function paerser($r, $data)
    {
        if( $r->get() ) {
            // print_r($r);
            if ($name = $r->apiName()) {
                $controller = $this->factory($name); // new $name;
                $method = $this->appMethod($data);
                $this->params = [ $r->params(), $data ];

            } else {
                // 라우터 정보에 컨트롤러 이름 없음.
                // 설정에 라이트 정보가 없는 경우
                if($type = $r->actionType()) {
                    //echo $type;
                    return $this->typeAction($type, $r);    
                } else {
                    // 라우터 정보에 컨트롤러 이름 없음.
                    $msg = " API 컨트롤러 이름이 설정되어 있지 않습니다.";
                    echo $msg;
                    exit;
                }
            }

        } else {
            $msg = "라우터파일이 없습니다.";
            echo $msg;
            exit;
        }

        return $this->run($controller, $method);
    }

    private function typeAction($type, $r)
    {
        $path = $r->actionConf();
        switch($type) {
            case 'table' :
                $name = "\Jiny\\Board\\Controller";
                $controller = $this->factory($name); // 컨트롤러 객체 생성    
                $controller->init($path);
                $method = $r->method(); // 실행 메서드            
                $this->params = $r->params(); // uri 파라미터

        }

        return $this->run($controller, $method);
    }

    private function router($endpoint=null)
    {
        
    }
    
    
    public function run($obj, $method="main")
    {
        if(method_exists($obj, $method)) {
            // print_r($this->params);
            return call_user_func_array( [$obj, $method], $this->params);
        } else {
            echo get_class($obj)." 컨트롤러에 ".$method." 메소드가 선언되어 있지 않습니다.";
            exit;
        }
        
    }

    public function factory($name, $args=null)
    {
        try {
            if($args) {
                // echo "args";
                $obj = new $name ($args);
            } else {
                $obj = new $name;
            }
        } catch (\Exception $e) {
            echo "오류";
            echo $e->getMessage();
            exit;
        }
        return $obj;
    }

    
    private function objectTo_POST($body)
    {
        foreach($body as $key => $value) {
            $key = str_replace(['[]','[',']'],".",$key);
            $k = \explode(".", rtrim($key,"."));
            $arr = &$_POST;
            foreach ($k as $a ) $arr = &$arr[$a];
            $arr = $value;
        }
    }

    private function reqBody()
    {
        $reqBody = $this->http->request()->body();
        if($data = json_decode($reqBody)) {
            // echo "변환성공";
            $this->objectTo_POST($data);
            
            return $data;
        } else {
            echo "유효한 json body가 아닙니다.\n";
            echo $reqBody;
            exit;
        }
    }

    private function endpoint($data=null)
    {
        if (isset($data->endpoint)) {
            return $data->endpoint;
        } else {
            return \jiny\http\endpoint()->uri();
        }
    }
    
    private function appMethod($data)
    {
        // 라우터에서 설정한 메소드를 우선적용
        if (isset($data->method)) {
            return $data->method;
        } else {
            return \jiny\http\request()->method();
        }
    }

}