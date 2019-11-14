<?php 
namespace mtk;

class ActionDisPatcher{
    public function forwardHttpRequest($path){
        $request = App::getInstance()->getRequest();
        $request->resetPath($path);
        $response = App::getInstance()->getResponse();
        $action = new ControllerAction($request,$response);
        App::getInstance()->addAction($action);
    }
}