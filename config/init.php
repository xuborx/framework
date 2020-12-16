<?php

define("DEBUG", 1);
define("USE_PHP_REDBEAN", 0);
define("ROOT_DIR", dirname(__DIR__));
define("APP_DIR", ROOT_DIR . "/app");
define("PUBLIC_DIR", ROOT_DIR . "/public");
define("CONF_DIR", ROOT_DIR . "/config");
define("VIEW_DIR", APP_DIR . "/Views");
define("STATICS_DIR", APP_DIR . "/Statics");
define("INSPECTORS_DIR", APP_DIR . "/Inspectors");
define("CORE_DIR", ROOT_DIR . "/vendor/xuborx/framework/core");

$appPath = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
$appPath = preg_replace("#[^/]+$#", "", $appPath);
$appPath = str_replace('public', '', $appPath);
$appPath = substr($appPath, 0, -1);

define("APP_PATH", $appPath);
define("APP_ADMIN_PATH", APP_PATH . '/admin');

require_once ROOT_DIR . '/vendor/autoload.php';
require_once CORE_DIR . '/dev/devFunctions.php';
require_once CONF_DIR . '/routes.php';