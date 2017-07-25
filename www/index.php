<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
define('APPLICATION_PATH', dirname(__FILE__) . "/../");
date_default_timezone_set('PRC');

$application = new Yaf_Application(APPLICATION_PATH . "/env/application.ini");
$application->bootstrap()->run();