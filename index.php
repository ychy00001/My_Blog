<?php 
//定义常量 
define("APP","Home");//家目录

define("DS", DIRECTORY_SEPARATOR);
define("ROOT_PATH",getcwd().DS);
define("APP_PATH",ROOT_PATH.APP.DS);

require_once(ROOT_PATH."Frame".DS."Frame.class.php");

\Frame\Frame::run();
