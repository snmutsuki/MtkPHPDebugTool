<?php
namespace mtk;

use RuntimeException;

class HttpResponse extends Response implements Injectable{
   //private static $responseTypeEnum = ["text","json","none","html","phpArray","xml"];
    private static $headerItemEnum = [];//TODO
    private $cookies = [];//TODO
    //private $responseType = "none";
    //private $renderPath = "hello";
    private $header = [];//TODO
    private $httpResponseCode = 200;//TODO

    private function __construct(){
        //$this->responseType = $responseType;
        $this->setInjectFields($this->getInjectFieldsEnum(),false);
    }

    public function addCookie(Cookie $cookie){
        $this->cookies[] = $cookie;
    }

    public function setResponseEncoding($charset){//TODO
        //header("charset:".$charset);
        return $this;
    }

    public function setHeader($header){//TODO
        //header($header);
        return $this;
    }
    public function setContentType($contentType){//TODO
        //header("ContentType:".$contentType);
        return $this;
    }

    public function addHeader($headerName,$value){//TODO
        $this->header[$headerName] = $value;
    }

    public function redirect($path,bool $local){
        if($local){
            $this->addHeader("Location",App::getInstance()->getConfig('LOCAL_STATIC_PATH').$path.'/'.App::getInstance()->getConfig('STATIC_PAGE_NAME'));
        }else{
            $this->addHeader("Location",$path);
        }

    }


    public static function getNewInstance(){
        $instance = new HttpResponse;
        return $instance;
    }

    public function getHeader(){
        return $this->header;
    }

    public function getCookies(){
        return $this->cookies;
    }


    public function getInjectFields(){
        return $this->injectFields;
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
        return [];
    }



    /*public function setResponseType($responseType){
        if(!in_array($responseType,$this->responseTypeEnum)) throw new Exception("$responseType is not a correct type");
        $this->responseType = $responseType;
        switch($responseType){
            case "text":$this->setContentType("text/plain");break;
            case "phpArray":$this->setContentType("text/plain");break;
            case "html":$this->setContentType("text/html");break;
            case "json":$this->setContentType("application/json");break;
            case "xml":$this->setContentType("text/xml");break;
            default:;
        }
        return $this;
    }*/
 



    
    
}