<?php
namespace mtk;

class TextResult extends Result{
    private $str = "";
    public function __construct($text = ""){
        $this->str = $text;
    }

    public function write($str){
        $this->str.=$str;
    }
    public function transformResult2Data(){
        $this->setData($this->str);
    }
}