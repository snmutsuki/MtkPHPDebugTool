<?php
namespace app\Controller;

use mtk\JsonResult;
use mtk\lib\ConfigService;
use mtk\MtkDebugTool;
use mtk\Response;
use app\util\Result;

class MtkDebugController{
    private $configService = null;

    public function __construct(){
        $this->configService = ConfigService::getInstance()->readConfig(ROOT_DIR."/app/Config/mtk_debug_config.php","mtkDebugConfig");
    }

    public function showDebug(JsonResult $jsonResult){
        $debugInfoUrl = $this->configService->getConfig("mtkDebugConfig","DEBUG_INFO_URL");
        $content = file_get_contents($debugInfoUrl);
        $result = Result::createSuccessResult($content);
        $jsonResult->setContent($result->transform2Array());    
        return $jsonResult;
    }


    public function refreshDebug(JsonResult $jsonResult){
        $refreshDebugUrl = $this->configService->getConfig("mtkDebugConfig","REFRESH_DEBUG_URL");
        file_get_contents($refreshDebugUrl);
        $result = Result::createSuccessResult("clean successfully");
        $jsonResult->setContent($result->transform2Array());    
        return $jsonResult;
    }

    public function showChangedFiles(){
        // MtkDebugTool::initMtkDebugFolder();
        // return Response::createEchoResponse(nl2br(print_r(MtkDebugTool::getChangedFileList(),true)));
    }

    public function removeDebugTag(){
        // MtkDebugTool::removeAllDebugTag();
    }


    
}