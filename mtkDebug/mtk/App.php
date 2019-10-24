<?php
namespace mtk;

use app\Controller\MtkDebug;

class App{
    protected $appName = '';
    protected $actionName = '';
    protected $controller = '';

    private function __construct($appName){
        $this->appName = $appName;
    }
    /**
     * @return App
     */
    public static function init(){
        $path = $_SERVER['SCRIPT_NAME'];
        $instance = new App("mtk debug");
        $instance->actionName = pathinfo($path,PATHINFO_FILENAME);
        $instance->controller = new MtkDebug;
        return $instance;
    }

    public function show(){
        if(empty($this->actionName) || ($this->actionName == 'mtk')){
            $this->actionName = 'index';           
        }
        $response = call_user_func([$this->controller , $this->actionName]);
        Response::parseResponse($response);
    }
}