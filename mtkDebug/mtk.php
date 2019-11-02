<?php
namespace mtk;

define("ROOT_DIR",realpath(__DIR__)."/");
define("WEBSITE_NAME","/mtkDebug/");

require ROOT_DIR.'/mtk/Loader.php';

Loader::register();

\mtk\App::init()->show();






