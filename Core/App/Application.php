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
        $controller_name = self::APP_PATH .ucfirst($routePoint);
        


        $this->controllerPHP($controller_name);

        
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
