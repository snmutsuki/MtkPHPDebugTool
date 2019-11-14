<?php
return [
    //应用的名字
    "APP_NAME" => "MTK PHP",
    "START_FILE_NAME" => "mtk.php",
    //首页路径
    "INDEX_PATH" => "/Index/index",
    'PRE_CONTROLLER_ACTION_FILTER_CHAIN' => [
        "\\app\\Filter\\NotSettingFilter",
    ],
    'POST_CONTROLLER_ACTION_FILTER_CHAIN' => [],
];