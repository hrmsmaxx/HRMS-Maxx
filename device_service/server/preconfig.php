<?php
include_once "env.php";
$company = null;
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
if (!defined("ROOT_URL_PANEL")) define("ROOT_URL_PANEL", $root);
if (!defined("ROOT_URL")) define("ROOT_URL", $_SERVER['DOCUMENT_ROOT']);
date_default_timezone_set("America/Montevideo");

// Include ezSQL core
include_once(ROOT_URL . "//conf/ezSQL/shared/ez_sql_core.php");
include_once(ROOT_URL . "//conf/smart_resize_image.function.php");
include_once(ROOT_URL . "//conf/ezSQL/mysqli/ez_sql_mysqli.php");

$db = new ezSQL_mysqli(DB_USER, DB_PASS, DB_NAME, DB_HOST, 'UTF-8');
ini_set("display_errors", "off");
