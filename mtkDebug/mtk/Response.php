<?php
namespace mtk;

abstract class Response{
    protected $data = "";
    public function getData(){
        return $this->data;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function write($str){
        $this->data.=$str;
    }
}