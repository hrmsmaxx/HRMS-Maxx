<?php
set_time_limit(0);
ini_set('mysql.connect_timeout', '0');
ini_set('max_execution_time', '0');
session_start();
ob_start();

$key = "";
if (isset($_GET['key']) && !empty($_GET['key'])) {
  $key = $_GET['key'];
}

include_once "server/preconfig.php";
if ($key == CONSUMER_KEY) {
  require_once ROOT_URL . "/server/models/ComunicacionReloj.php";
  $db = new ezSQL_mysqli(DB_USER, DB_PASS, DB_NAME, DB_HOST, 'UTF-8');
  error_log("Consumer.php - Run OK");
} else {
  error_log("Consumer.php - Bad credentials");
}
