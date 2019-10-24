<?php
namespace mtk;

define("ROOT_DIR",realpath(__DIR__)."/");

require ROOT_DIR.'/mtk/Loader.php';

Loader::register();

\mtk\App::init()->show();






