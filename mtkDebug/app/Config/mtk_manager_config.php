<?php
return [
    "menu" => [
        [
            "name" => "Debug",
            "key" => "/debug",
            "icon" => "bug",
            "subMenu" => [
                [
                    "name" => "show debug",
                    "key" => "/debug/debugItem:showDebug",
                    "icon" => false,
                    "subMenu" => false,
                    "path" => "/debug/showDebug",
                    "disabled" => false
                ],
                [
                    "name" => "refresh debug",
                    "key" => "/debug/debugItem:refreshDebug",
                    "icon" => false,
                    "subMenu" => false,
                    "path" => "/debug/refreshDebug",
                    "disabled" => false
                ],
                [
                    "name" => "show changed files",
                    "key" => "/debug/debugItem:showChangedFiles",
                    "icon" => false,
                    "subMenu" => false,
                    "path" => "/debug/showChangedFiles",
                    "disabled" => false
                ],
                [
                    "name" => "remove debug tag",
                    "key" => "/debug/debugItem:removeDebugTag",
                    "icon" => false,
                    "subMenu" => false,
                    "path" => "/debug/removeDebugTag",
                    "disabled" => false
                ]
            ],
            "path" => "/debug",
            "disabled" => false
        ],
        [
            "name" => "setting",
            "key" => "/setting",
            "icon" => "setting",
            "subMenu" => [
                [
                    "name" => "debug tool",
                    "key" => "/setting/settingItem:debugToolConfig",
                    "icon" => false,
                    "subMenu" => false,
                    "path" => "/setting/debugToolConfig",
                    "disabled" => false
                ],
                [
                    "name" => "sftp",
                    "key" => "/setting/settingItem:sftpConfig",
                    "icon" => false,
                    "subMenu" => false,
                    "path" => "/setting/sftpConfig",
                    "disabled" => false
                ]
            ],
            "path" => "/setting",
            "disabled" => false
        ]
    ],
    "debugToolConfigItem" => [
        [
            "name" => "DEBUG_BASE_DIR",
            "labelName" => "debug base dir",
            "type" => "text",
            "required" => true,
            "helpMessage" => "本地代码根目录",
            "value" => ""
        ],
        [
            "name" => "MTK_DEBUG_FOLDER_PATH",
            "labelName" => "mtk debug folder path",
            "type" => "text",
            "required" => false,
            "helpMessage" => "存放debug的生成文件的本地路径",
            "value" => "/mtk/.mdebug"
        ],
        [
            "name" => "DEBUG_INFO_URL",
            "labelName" => "debug info url",
            "type" => "text",
            "required" => true,
            "helpMessage" => "远端控制器插件查看远端debug的网址",
            "value" => ""
        ],
        [
            "name" => "REFRESH_DEBUG_URL",
            "labelName" => "refresh debug url",
            "type" => "text",
            "required" => true,
            "helpMessage" => "远端控制器插件清除debug记录的网址",
            "value" => ""
        ],
        [
            "name" => "REFRESH_VERSION_WHEN_REMOVE",
            "labelName" => "refresh version when remove",
            "type" => "switch",
            "required" => false,
            "helpMessage" => "是否在清除debug标记后更新文件版本记录表",
            "value" => ""
        ],
    ],
    "sftpConfig" => [
        [
            "name" => "HOST",
            "labelName" => "host",
            "type" => "text",
            "required" => true,
            "helpMessage" => "远端主机地址",
            "value" => ""
        ],
        [
            "name" => "PORT",
            "labelName" => "port",
            "type" => "text",
            "required" => true,
            "helpMessage" => "远端主机端口",
            "value" => ""
        ],
        [
            "name" => "USER_NAME",
            "labelName" => "user name",
            "type" => "text",
            "required" => true,
            "helpMessage" => "用户名",
            "value" => ""
        ],
        [
            "name" => "PASSWORD",
            "labelName" => "password",
            "type" => "password",
            "required" => true,
            "helpMessage" => "密码",
            "value" => ""
        ],
        [
            "name" => "REMOTE_BASE_DIR",
            "labelName" => "remote base dir",
            "type" => "text",
            "required" => true,
            "helpMessage" => "远端项目根目录",
            "value" => ""
        ],
        [
            "name" => "LOCAL_BASE_DIR",
            "labelName" => "local base dir",
            "type" => "text",
            "required" => true,
            "helpMessage" => "本地项目根目录",
            "value" => ""
        ],
    ]
];