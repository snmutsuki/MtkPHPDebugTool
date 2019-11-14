<?php
namespace mtk;

abstract class ResponseSender{
    protected $response = null;
    public abstract function send();
    public function loadResponse(Response $response){
        $this->response = $response;
    }
}