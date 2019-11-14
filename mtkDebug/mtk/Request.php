<?php
namespace mtk;

abstract class Request{
    protected $params = [];  
    
    public function getParam($paramName){
        return key_exists($paramName,$this->params) ? $this->params[$paramName] : false;
    }

    public function setParam($paramName,$value){
        $this->params[$paramName] = $value;
    }

    public function getParams(){
        return $this->params;
    }
}