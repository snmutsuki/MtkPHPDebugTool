<?php 
namespace app\util;

class Result{
    private $resultCode = -1;
    private $data;
    private $message = "";

    private function __construct($resultCode,$data,$message){
        $this->resultCode = $resultCode;
        $this->data = $data;
        $this->message = $message;
    }

    public static function createSuccessResult($data){
        return new Result(200,$data,"");
    }

    public static function createErrorResult($data,$message){
        return new Result(500,$data,$message);
    }

    public function transform2Array(){
        return ["resultCode" => $this->resultCode , "data" => $this->data , "message" => $this->message];
    }
}