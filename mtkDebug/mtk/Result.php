<?php
namespace mtk;

abstract class Result{
    protected $data = "";

    public function setData($data){
        $this->data = $data;
    }

    public function getData(){
        if(empty($data)) $this->transformResult2Data();
        return $this->data;
    }

    public abstract function transformResult2Data();
}