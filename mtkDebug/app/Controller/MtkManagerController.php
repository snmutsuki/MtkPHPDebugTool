<?php
namespace app\Controller;

use app\util\Result;
use Exception;
use mtk\HttpRequest;
use mtk\JsonResult;
use mtk\lib\ConfigService;

class MtkManagerController{
    private $configService = null;

    public function __construct(){
        $this->configService = ConfigService::getInstance()->readConfig(ROOT_DIR."/app/Config/mtk_manager_config.php","MtkManager");
    }
    public function menu(JsonResult $jsonResult,$settingMenu = false){
        $menu = $this->configService->getConfig("MtkManager","menu");
        if($settingMenu){
            $menu[0]['disabled'] = true;
        }
        $result = Result::createSuccessResult($menu);
        $jsonResult->setContent($result->transform2Array());
        return $jsonResult;
    }

    public function setting($settingItem,JsonResult $jsonResult){
        switch($settingItem){
            case "debugToolConfig" : {
                $settingForm = $this->configService->getConfig("MtkManager","debugToolConfigItem");
            }break;
            case "sftpConfig" : {
                $settingForm = $this->configService->getConfig("MtkManager","sftpConfig");
            }break;
            default : {
                throw new Exception("不存在该设置项");
            }
        }
        $result = Result::createSuccessResult($settingForm);
        $jsonResult->setContent($result->transform2Array());
        return $jsonResult;
    }

    public function debug($debugItem,HttpRequest $request){
        switch($debugItem){
            case "showDebug":$request->forward("/MtkDebug/showDebug");break;
            case "refreshDebug":$request->forward("/MtkDebug/refreshDebug");break;
            case "showChangedFiles":$request->forward("/MtkDebug/showChangedFiles");break;
            case "removeDebugTag":$request->forward("/MtkDebug/removeDebugTag");break;
            default :;
        }
    }
}