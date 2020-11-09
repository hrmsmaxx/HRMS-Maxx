<?php
set_time_limit(0);
ini_set('mysql.connect_timeout', '0');
ini_set('max_execution_time', '0');
header('Content-type: application/json; charset=UTF-8');
session_start();
ob_start();
$json = json_decode(file_get_contents('php://input'), true);
if (empty($json) || empty($json['apikey']) || empty($json['type']) || empty($json['serial_number'])) {
  exit;
}
include_once "../../preconfig.php";
$apikeyDB = $mainDB->get_var("SELECT valor FROM _opcion WHERE tipo = 'apikey'");
if (!empty($json['apikey']) && $json['apikey'] === ADMS_KEY) {
  $json["type"] = mb_strtolower($json['type']);
  $json["serial_number"] = $mainDB->escape($json['serial_number']);
  $info_dispositivo = $mainDB->get_row("SELECT * FROM _dispositivos WHERE serial_number = '" . $json["serial_number"] . "'");
  if (!empty($info_dispositivo)) {
    $_SESSION['empresa'] = $info_dispositivo->id_empresa;
    include_once ROOT_URL . "/server/config.php";
    include_once ROOT_URL . 'functions.php';
    $inicio = new Inicio();
    $inicio->id = 1;
    include_once ROOT_URL . "/server/controllers/ConsumerADMS.php";
    ConsumerADMS::request($json);
  }
}
exit;
