<?php

namespace Core\App;
// content-type
// Teext/Html
class Application
{
    private $Request, $response;
    public function __construct($req, $res)
    {
        $this->Request = $req;
        $this->Response = $res;

        $controller_name = "\App\Controller\\"."Index";
        $this->controllerPHP($controller_name);

        
        // echo __CLASS__;
        // echo $this->index();
        
        // HTML 모드
    /*
    //echo "nugu play<br>";
    
    if (isset($controller) && $controller != "") {
        $controllerName = "\App\Nugu\\".ucfirst($controller);
        $app = new $controllerName;

        $app->setDatabase($dbo);

        $action = $URI->second()?:"index";
        $params = [1,2];
        if (method_exists($app, $action)) {
            call_user_func_array(
                [$app, $action],
                $params
            );
        } else {
            // echo $controller." 컨트롤러 메소드를 실행할 수 없습니다.";
            // echo $action. "메소드가 존재하지 않습니다.";
            call_user_func_array(
                [$app, $action],
                $params
            );
        }

    } else {

        if(file_exists("./App/Root.php")) {
            $app = new \App\Root;
            $action = "index";
            $params = [1,2];
            call_user_func_array(
                [$app, $action],
                $params
            );
        } else {
            echo "실행할 컨트롤러가 없습니다.";
        }
    }
    */

    }

    public function index()
    {

    }

    /**
     * PHP 컨트롤러 처리
     */
    public function controllerPHP($name)
    {
        $controller = $this->factory($name);
        
        $controller->setRequest($this->Request);    // Request 전달
        $controller->setResponse($this->Response);  // Response 전달

        $method = $this->Request->isMethod();
        echo $controller->$method();
    }

    /**
     * 컨트롤러 생성 팩토리
     */
    public function factory($name)
    {
        $filename = str_replace("\\",DIRECTORY_SEPARATOR,"..".$name.".php");
        // echo $filename;
        if(file_exists($filename)) {
            return new $name;
        } else {
            echo "컨트롤러 파일이 존재하지 않습니다.";
            exit;
        }
        
    }

    /**
     * 
     */
}