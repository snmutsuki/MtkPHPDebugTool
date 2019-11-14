<?php
namespace mtk;

use Exception;
use ReflectionClass;
use ReflectionParameter;


class ControllerAction extends Action{
    public function __construct(Request $Request , Response $Response/*,ResponseSender $ResponseSender*/){
    parent::__construct($Request,$Response/*,$ResponseSender*/);
    }
    
    /**
     * @return Result
     */
    protected function doAction(Request $request,Response $response){
        $fullControllerName = "\app\Controller\\".$this->request->getControllerName()."Controller";
        $controller = new $fullControllerName;
        $class = new ReflectionClass($controller);
        $method = $class->getMethod($this->request->getActionName());
        $reflectParams = $method->getParameters();
        $params = [];
        foreach($reflectParams as $reflectParam){
            $params[] = $this->getInjectData($reflectParam);
        }
        $method->setAccessible(true);
        $result = $method->invoke($controller,...$params);
        if(empty($result)) return;
        if(gettype($result) == "string") $result = new TextResult($result);
        $response->setData($result->getData());
    }

    //TODO后面需要独立出来
    protected function getInjectData(ReflectionParameter $param){
        $result = null;
        $name = $param->getName();
        foreach($this->request->getInjectFields() as $value){
            if($name == $value) return call_user_func([$this->request,"get".ucfirst($value)]);
        }
        foreach($this->response->getInjectFields() as $value){
            if($name == $value) return call_user_func([$this->request,"get".ucfirst($value)]);
        }
        switch($name){
            case "request":$result = $this->request;break;
            case "response":$result = $this->response;break;
            case "textResult":$result = new TextResult;break;//TODO
            case "jsonResult":$result = new JsonResult;break;//TODO
            case "xmlResult":$result = new XmlResult;break;//TODO
            case "phpArrayResult":$result = new PHPArrayResult;break;//TODO
            case "modelAndViewResult":$result = new ModelAndViewResult;break;//TODO
            default:{
                if(!key_exists($name,$this->request->getParams()) && !$param->isDefaultValueAvailable()) throw new Exception("false to inject $name , the param of $name is not exist");
                $result = $this->request->getParam($name);
            };
        }
        return $result;
    }

    protected function preAction(Request $request,Response $response){
        if(empty(App::getInstance()->getConfig('PRE_CONTROLLER_ACTION_FILTER_CHAIN'))) return true;
        $filterParams = ["request" => $request , "response" => $response];
        $preFilterChain = new FilterChain(App::getInstance()->getConfig('PRE_CONTROLLER_ACTION_FILTER_CHAIN'),$filterParams);        
        return $preFilterChain->startFilter();
    }

    protected function postAction(Request $request,Response $response){
        if(empty(App::getInstance()->getConfig('POST_CONTROLLER_ACTION_FILTER_CHAIN'))) return true;
        $filterParams = ["request" => $request , "response" => $response];
        $postFilterChain = new FilterChain(App::getInstance()->getConfig('POST_CONTROLLER_ACTION_FILTER_CHAIN'),$filterParams);
        return $postFilterChain->startFilter();
    }
}