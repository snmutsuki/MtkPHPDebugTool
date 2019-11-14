<?php
namespace mtk;

class ModelAndViewResult extends Result{
    private $viewName = "";
    private $model = [];

    public function setViewName($viewName){
        $this->viewName = $viewName;
    }

    public function addParam($paramName,$value){
        $this->model[$paramName] = $value;
    }

    public function transformResult2Data(){
        //TODO
    }
}