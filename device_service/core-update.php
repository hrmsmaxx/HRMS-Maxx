<?php
set_time_limit(0);
ini_set('mysql.connect_timeout', '0');
ini_set('max_execution_time', '0');
session_start();
ob_start();

include_once "server/env.php";

if (isset($_GET['secretkey']) && ($_GET['secretkey'] == ACTUALIZAR_KEY || $_GET['secretKey'] == ACTUALIZAR_KEY)) {
  include_once "server/preconfig.php";
  $db = new ezSQL_mysqli(DB_USER, DB_PASS, DB_NAME, DB_HOST, 'UTF-8');
  include('core-update-calls.php');
  echo "Todo correcto";
}
