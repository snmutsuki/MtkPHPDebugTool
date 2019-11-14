<?php
namespace mtk;

use \Exception;
use RuntimeException;

class HttpRequest extends Request implements Injectable{
    private $controllerName = '';
    private $actionName = '';
    private $session;
    private $cookies = [];
    private $header = [];
    private $injectFields = [];

    private function __construct($controllerName,$actionName,$params = []){
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->params = $params;
        $this->init();
    }

    private function init(){//TODO
        $this->setInjectFields($this->getInjectFieldsEnum(),false);
        $this->getRequestParams();
    }

    public static function getNewInstanceByPath($path){
        $result = self::parsePath($path);
        $instance = new HttpRequest($result['controllerName'],$result['actionName'],$result['params']);
        return $instance;
    }

    public static function getNewInstanceByParam($controllerName,$actionName,$params = []){
        $instance = new HttpResponse($controllerName,$actionName,$params);
        return $instance;
    }

    private function getRequestParams(){
        foreach($_GET as $key => $value){
            $this->params[$key] = $value; 
        }
        foreach($_POST as $key => $value){
            $this->params[$key] = $value; 
        }
        $input = json_decode(file_get_contents('php://input')) ?? [];
        foreach($input as $key => $value){
            $this->params[$key] = $value; 
        }
    }

    public function getControllerName(){
        return $this->controllerName;
    }

    public function getActionName(){
        return $this->actionName;
    }

    public function getSession(){
        return $this->session;
    }

    public function getCookies(){
        return $this->cookies;
    }

    public function getHeader(){
        return $this->header;
    }

    public function getHeaderItem($itemName){
        return $this->header[$itemName];
    }

    public function getInjectFields(){
        return $this->injectFields;
    }

    public function resetPath($path){
        $result = self::parsePath($path);
        $this->controllerName = $result['controllerName'];
        $this->actionName = $result['actionName'];
        foreach($result['params'] as $key => $value){
            $this->params[$key] = $value;
        }
    }

    public function setInjectFields(Array $fields , bool $merge){
        if(!$merge) $this->injectFields = [];
        foreach($fields as $value){
            if(in_array($value,$this->getInjectFieldsEnum()) && !in_array($value,$this->injectFields)){
                $this->injectFields[] = $value;
                continue;
            }
            throw new RuntimeException("设置的注入字段不符合规范");         
        }
    }

    public function getInjectFieldsEnum(){
        return ["cookie","header","session","params"];
    }

    /**
     * 解析path并将解析后的数据返回
     * @param string $path 格式必须为   /controllerName/actionName/paramName1:param1/paramName2:param2/...这种格式
     */
    private static function parsePath($path){
        //开头必须为'/'
        if(substr($path,0,1) != '/') throw new Exception("path must start with '/',path:".$path);
        //最后一个若是'/'则删除
        $path = substr($path,strlen($path)-1,strlen($path)) == '/' ? substr($path,0,srlen($path)-1) : $path;
        $index = 0;
        $lastIndex = 0;
        $temp = [];
        $result = [];
        while(($index = strpos($path,'/',$lastIndex)) !== false){
            if($index !== 0){
                $temp[] = substr($path,$lastIndex,$index-$lastIndex);
            }
            $lastIndex = ++$index;
        }
        $temp[] = substr($path,$lastIndex);

        if(count($temp) < 2) throw new Exception("path is not correct,path:".$path);
        foreach($temp as $key => $value){
            if(empty($value)) throw new Exception("path is not correct,path:".$path);
            switch($key){
                case 0:{
                    $result['controllerName'] = $value;
                }break;
                case 1:{
                    $result['actionName'] = $value;
                    $result['params'] = [];
                }break;
                default:{
                    $paramData = explode(':',$value,2);
                    if(count($paramData) !== 2){
                        throw new Exception("path is not correct,path:".$path.",paramStr:".$value);
                    }
                    $result['params'][$paramData[0]] = $paramData[1];
                };
            }
        }
        return $result;
    }

    public function forward($path){
        $dispatcher = new ActionDisPatcher;
        $dispatcher->forwardHttpRequest($path);
    }
}