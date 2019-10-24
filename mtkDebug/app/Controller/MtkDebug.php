<?php
namespace app\Controller;

use mtk\MtkDebugTool;
use mtk\Response;

class MtkDebug{
    private $debugInfoUrl = '';
    private $refreshDebugUrl = '';

    public function __construct(){
        $config = include ROOT_DIR."/app/Config/ControllerConfig.php";
        $this->debugInfoUrl = $config['DEBUG_INFO_URL'];
        $this->refreshDebugUrl = $config['REFRESH_DEBUG_URL'];
    }

    /**
     * @return Response
     */
    public function index(){
        return Response::createRenderResponse("hello");
    }

    public function showDebug(){
        return Response::createRenderResponse("showDebug");
    }

    public function readDebug(){
        $debugContent = file_get_contents($this->debugInfoUrl);
        return Response::createEchoResponse($debugContent);
    }

    public function refreshDebug(){
        file_get_contents($this->refreshDebugUrl);
    }

    public function showChangedFiles(){
        MtkDebugTool::initMtkDebugFolder();
        return Response::createEchoResponse(nl2br(print_r(MtkDebugTool::getChangedFileList(),true)));
    }

    public function removeDebugTag(){
        MtkDebugTool::removeAllDebugTag();
    }
}