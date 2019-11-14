<?php
namespace mtk\lib;

use Exception;

class ConfigService{
    private static $instance = null;
    private $config = [];

    private function __construct(){
        
    }
    public static function getInstance(){
        if(empty(self::$instance)) self::$instance = new ConfigService;
        return self::$instance;
    }

    public function readConfig($path,$configName){
        if(!file_exists($path)) throw new Exception("$path not exist");
        if(isset($this->config[$configName])) return $this;
        $config = include $path;
        $this->config[$configName] = $config;
        return $this;
    }

    public function getConfig($args){
        $args = func_get_args();
        $result = $this->config;
        foreach($args as $arg){
            if(isset($result[$arg])){
                $result = $result[$arg];
                continue;
            }
            throw new Exception("this config not exist!");
        }
        return $result;
    }
}