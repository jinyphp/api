<?php

namespace App;
// content-type
// Teext/Html
class Application
{
    private $Request, $response;
    public function __construct($req, $res)
    {
        $this->Request = $req;
        $this->Response = $res;
        
        // echo __CLASS__;
        echo $this->index();
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
        $URI = new \Core\Http\URI;
        if (($uri = $URI->getURI()) == "/") {
            $filename = "../Resource/View/index.html";
        } else {
            $filename = "../Resource/View".$uri.".html";
        }

        if(file_exists($filename)) {
            $body = file_get_contents($filename);
        } else {
            $body = "404 pages";
        }
        return $body;
    }

    /**
     * 
     */
}
