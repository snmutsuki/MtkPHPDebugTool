<?php
namespace app\Controller;
use mtk\Response;

class ErrorController{
    public function index($message){
        return $message;
    }
}