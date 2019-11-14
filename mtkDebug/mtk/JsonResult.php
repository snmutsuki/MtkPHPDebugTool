<?php
namespace mtk;

class JsonResult extends Result{
    private $content;

    public function setContent($content){
        $this->content = $content;
    }
    public function transformResult2Data(){
        $this->setData(json_encode($this->content));
    }
}