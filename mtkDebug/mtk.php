<?php
namespace mtk;

define("ROOT_DIR",realpath(__DIR__)."/");
define("CORE_DIR",ROOT_DIR."mtk/");
define("APP_DIR",ROOT_DIR."app/");
define("WEBSITE_NAME","/mtkDebug/");

require ROOT_DIR.'/mtk/Loader.php';

Loader::register();

\mtk\App::getInstance()->start();






