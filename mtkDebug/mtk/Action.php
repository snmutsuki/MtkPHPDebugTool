<?php
namespace mtk;

abstract class Action{
    protected $request = null;
    protected $response = null;
    public function __construct(Request $request , Response $response){
        $this->request = $request;
        $this->response = $response;
    }
    public function execAction(){
        if($this->preAction($this->request,$this->response)) {
            $this->doAction($this->request,$this->response);
            $this->postAction($this->request,$this->response);
        }      
    }
    protected abstract function doAction(Request $request,Response $response);
    /**
     * @return boolean
     */
    protected function preAction(Request $request,Response $response){
        return true;
    }
    /**
     * @return boolean
     */
    protected function postAction(Request $request,Response $response){
        return true;
    }

    public function setResponseSender(ResponseSender $responseSender){
        $this->responseSender = $responseSender;
        $responseSender->loadResponse($this->response);
    }

}