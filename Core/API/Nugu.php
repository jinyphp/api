<?php

namespace Rest;

class Nugu
{
    protected $Request, $Response;

    private $action;
    private $parameters;
    public function __construct()
    {
        $reqBody = $this->Request->getBody();
        $nuguReq = json_decode($reqBody);

        $this->action = $nuguReq->action->actionName;
        $this->parameters = $nuguReq->action->parameters;
    }

    public function setRequest($req)
    {
        $this->Request = $req;
    }

    public function setResponse($res)
    {
        $this->Response = $res;
    }


    /**
     * nugu
     * action controller
     */
    public function execute()
    {
        // echo "=>컨트롤러 실행";
        $this->action = str_replace("_", ".", $this->action);
        $names = explode(".",$this->action);
        $controllerName = "\Rest\Nugu\\";
        foreach ($names as $name) {
            $controllerName .= ucfirst($name);
        }

        $controller = new $controllerName;
        $controller->setApp($this);
        return $controller->POST($this->parameters);
    }


}
