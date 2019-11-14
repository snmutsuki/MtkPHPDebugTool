<?php
namespace app\Controller;

use app\Service\AutoSettingCreationService;
use mtk\TextResult;

class SettingController{
    private $autoSettingCreationService = null;

    public function __construct(){
        $this->autoSettingCreationService = AutoSettingCreationService::getInstance();
    }

    public function setting($settingItem,$params){
        $this->autoSettingCreationService->createSettingFile(ROOT_DIR."app/Config/",$settingItem,$params);
    }
}