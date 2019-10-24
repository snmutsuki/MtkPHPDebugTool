<?php
return [
    'DEBUG_BASE_DIR' => 'xxx/Application/',
    'MTK_DEBUG_FOLDER_PATH' => 'xxx/.mdebug/',
    'MTK_VERSION_FILE_NAME' => 'fileVersionList.php',
    'IGNORE_FILE_LIST_RELATIVE_BY_BASE_DIR' => [
        'index.php',
        '.mdebug/',
        'Common/Utils/MtkDebugTool.class.php',
        'Common/Conf/mdebugConfig.php'
    ],
    'REFRESH_VERSION_WHEN_REMOVE' => true,
    'DEFAULT_DEBUG_FILE_NAME' => 'debug.log'
];