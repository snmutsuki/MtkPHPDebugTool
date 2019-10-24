<?php
namespace mtk;

class Loader{
    //源代码的根路径
    private static $srcRootPath;


    public static function register(){
        self::initSrcRootPath();
        //开启自动加载
        spl_autoload_register([__CLASS__ , "autoLoad"] , true ,true);
    }
    //初始化源代码根路径
    public static function initSrcRootPath(){
        if(empty(self::$srcRootPath)){
            $scriptPath = $_SERVER['SCRIPT_FILENAME'];
            self::$srcRootPath = realpath(dirname($scriptPath)).DIRECTORY_SEPARATOR;
        }
    }

    public static function findFile($class){
        return self::$srcRootPath.$class.".php";
    }

    public static function autoLoad($class){
        //导入文件
        self::includeFile(self::findFile($class));
    }

    public static function includeFile($file){
        return include $file;
    }

    public static function requireFile($file){
        return require $file;
    }

}