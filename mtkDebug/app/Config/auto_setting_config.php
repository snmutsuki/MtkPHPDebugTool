<?php
return [
    "DEBUG_CONFIG_FILE" => [
        "debugToolConfig" => "mtk_debug_config.php",
        "sftpConfig" => "mtk_sftp_config.php"
    ],
    //mtkdebug中的配置项
    "CONFIG_ENUM_OF_debugToolConfig" => [
        "DEBUG_BASE_DIR",
        "MTK_DEBUG_FOLDER_PATH",
        "MTK_VERSION_FILE_NAME",
        "IGNORE_FILE_LIST_RELATIVE_BY_BASE_DIR",
        "REFRESH_VERSION_WHEN_REMOVE",
        "DEFAULT_DEBUG_FILE_NAME",
        "DEBUG_INFO_URL",
        "REFRESH_DEBUG_URL"
    ],
    //mtksftp中的配置项
    "CONFIG_ENUM_OF_sftpConfig" => [
        "HOST",
        "PORT",
        "USER_NAME",
        "PASSWORD",
        "REMOTE_BASE_DIR",
        "LOCAL_BASE_DIR"
    ],
    //上诉配置的默认配置
    "DEFAULT_DEBUG_SETTING" => [
        'MTK_VERSION_FILE_NAME' => 'fileVersionList.php',
        'IGNORE_FILE_LIST_RELATIVE_BY_BASE_DIR' => [
            'index.php',
            '.mdebug/',
            'Common/Utils/MtkDebugTool.class.php',
        ],
        'REFRESH_VERSION_WHEN_REMOVE' => true,
        'DEFAULT_DEBUG_FILE_NAME' => 'debug.log'
    ],
];