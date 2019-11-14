<?php
namespace mtk;

use app\Controller\MtkDebugController;
use app\Controller\IndexController;
use app\Controller\ErrorController;
use Exception;

final class App{
    private static $configPath = CORE_DIR."Config/convention.php";
    private $appName = 'MTK PHP';
    private $config = [];   
    private $startFileName = "mtk.php";
    private $indexPath = "/Index/index";
    private $request;
    private $actionChain = [];
    /**
     * @property Response $response
     */
    private $response;
    private static $instance = null;
    //private $params = [];//TODO想作成应用全局参数存放地

    private function __construct(){
        $this->init();
    }
    
    private function init(){        
        $this->configInit();
        $this->appName = $this->config['APP_NAME'];
        $this->startFileName = $this->config['START_FILE_NAME'];
        $this->indexPath = $this->config['INDEX_PATH'];
    }
    
    private function pathParse($path){
        $actionPath = '';
        if(strpos($path,$this->startFileName) !== false){
            //如果url结尾不是'/'
            $actionPath = substr($path,strpos($path,$this->startFileName)+7);           
        }else{
            $actionPath = $path;
        }
        //如果path是*/mtk.php这样的,或者path是*/mtk.php/这样的，跳转首页
        if(strlen($actionPath) == 0 || strlen($actionPath) == 1) return $this->indexPath;
        return $actionPath;
    }
    
    private function configInit(){
        $config = include self::$configPath;
        $config['LOCAL_STATIC_PATH'] = WEBSITE_NAME."static/";
        $config['STATIC_PAGE_NAME'] = "index.html";
        $this->config = $config;
    }

    /**
     * 获取当前应用的唯一实例
     * @return App
     */
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new App;
        }
        return self::$instance;
    }
    /**
     * 获取当前应用的配置
     * @param string $configName 配置名称，如果为空，则获取所有的配置
     * @return mixed 返回的配置，如果是单个配置，这个配置的值，如果是多个配置，则返回map,如果找不到该配置，返回null
     */
    public function getConfig($configName = ''){
        return key_exists($configName,$this->config)? $this->config[$configName] : null;
    }

    /**
     * 设置配置
     * @param string $configName 需要进行设置的配置名
     * @param mixed $configValue 需要进行设置的配置值
     */
    public function setConfig($configName,$configValue){
        if(empty($configName)) throw new Exception("config name can't be empty");
        self::$instance[$configName] = $configValue;
    }

    public function addAction(Action $action){
        if(empty($this->request) || empty($this->response)) throw new Exception("must start the app first!!!");
        $this->actionChain[] = $action;
    }

    public function getRequest(){
        return $this->request;
    }

    public function getResponse(){
        return $this->response;
    }

    public function start(){
        $path = $_SERVER['SCRIPT_NAME'];
        $actionPath = $this->pathParse($path);
        $this->request = HttpRequest::getNewInstanceByPath($actionPath);//TODO  
        $this->response = HttpResponse::getNewInstance();//TODO
        $action = new ControllerAction($this->request,$this->response);
        $this->actionChain[] = $action;
        $this->run();
    }

    private function run(){  
        for($i = 0 ;$i < count($this->actionChain) ; $i++){//for-each会固定数组长度，不可取
            $action = $this->actionChain[$i];
            $action->execAction();
        }
        $this->end();
    }

    private function end(){
        $responseSender = new HttpResponseSender;//TODO
        $responseSender->loadResponse($this->response);
        $responseSender->send();
    }


}