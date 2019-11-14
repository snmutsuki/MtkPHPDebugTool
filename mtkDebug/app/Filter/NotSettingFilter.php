<?php
namespace app\Filter;

use mtk\HttpFilter;
use mtk\HttpRequest;
use mtk\HttpResponse;
use mtk\lib\ConfigService;

class NotSettingFilter extends HttpFilter{
    /**
     * @property ConfigService $configService
     */
    private $configService = null;

    public function __construct(){
        $this->configService = ConfigService::getInstance()->readConfig(ROOT_DIR."/app/Config/auto_setting_config.php","autoSettingConfig"); 
    }
    protected function doHttpFilter(HttpRequest $request , HttpResponse $response){
        $requiredSettingFiles = $this->configService->getConfig("autoSettingConfig","DEBUG_CONFIG_FILE");
        $result = true;
        foreach($requiredSettingFiles as $value){
            $result=$result && file_exists(ROOT_DIR."app/Config/".$value);
        }
        if(!$result){
            if($request->getControllerName() != "MtkManager"){
                if($request->getControllerName() == "Setting") return true;
                $response->redirect("mtkManager",true);
                return false;
            }
            if($request->getActionName() == "menu"){
                $request->setParam("settingMenu",true);
            }
        }
        return true;
    }
}