<?php
namespace app\Service;

use mtk\lib\ConfigService;
use \Throwable;

class AutoSettingCreationService{
    private static $instance = null;
    private $configService = null;

    private function __construct(){
        $this->configService = ConfigService::getInstance()->readConfig(ROOT_DIR."/app/Config/auto_setting_config.php","autoSettingConfig");
    }

    public static function getInstance(){
        if(empty(self::$instance)) self::$instance = new AutoSettingCreationService;
        return self::$instance;
    }

    public function createSettingFile($path,$settingItem,$data){
        $fileName = $this->configService->getConfig("autoSettingConfig","DEBUG_CONFIG_FILE",$settingItem);
        $configEnum = $this->configService->getConfig("autoSettingConfig","CONFIG_ENUM_OF_".$settingItem);
        $defaultDebugSetting = $this->configService->getConfig("autoSettingConfig","DEFAULT_DEBUG_SETTING");
        $result = [];
        $file = null;       
        try{
            $file = fopen($path.$fileName,"w");
            foreach($configEnum as $value){
                $result[$value] = isset($data[$value]) ? $data[$value] : (isset($defaultDebugSetting[$value]) ? $defaultDebugSetting[$value] : "");
            }
            fwrite($file,"<?php\nreturn ");
            fwrite($file,var_export($result,true));
            fwrite($file,';');
            fflush($file);
            fclose($file);
        }catch(Throwable $e){
            fclose($file);
            unlink($file);
            throw $e;
        }
    }
}