<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\App;
// content-type
// Teext/Html
class Application
{
    private $Request, $response;
    const APP_PATH = "\APP\Controller\\";

    public function __construct($req, $res)
    {
        $this->Request = $req;
        $this->Response = $res;

        $routePoint = $this->endPoint();
        $controller_name = self::APP_PATH .ucfirst($routePoint);;
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

    /**
     * 라우트 endpoint()
     */
    private function endPoint()
    {
        if( $point = $this->Request->Uri->first() )
        {
            return $point;
        } else {
            return "Index";
        }
    }

    private function isAction()
    {
        if( $point = $this->Request->Uri->second() )
        {
            return $point;
        } else {
            return "index";
        }
    }


    /**
     * PHP 컨트롤러 처리
     */
    public function controllerPHP($name)
    {
        $controller = $this->factory($name);

        $controller->setRequest($this->Request);    // Request 전달
        $controller->setResponse($this->Response);  // Response 전달

        // $method = $this->Request->isMethod();
        $action = $this->isAction();
        echo $controller->$action();
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
