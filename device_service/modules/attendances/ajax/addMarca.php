<?php
if (isset($_GET["codigo"]) && (!empty($_GET["codigo"]) || $_GET["codigo"] == 0) && isset($_GET["fecha"]) && (!empty($_GET["fecha"]) || $_GET["fecha"] == 0) && isset($_GET["incidencia"]) && (!empty($_GET["incidencia"]) || $_GET["incidencia"] == 0)) {
  $codigo = $db->escape($_GET['codigo']);
  $fecha = $db->escape($_GET['fecha']);
  $incidencia = $db->escape($_GET['incidencia']);
  $lectorIP = null;
  $lectorPuerto = null;
  if (
    isset($_GET["ip"]) && (!empty($_GET["ip"]) || $_GET["ip"] == 0) &&
    isset($_GET["puerto"]) && (!empty($_GET["puerto"]) || $_GET["puerto"] == 0)
  ) {
    $lectorIP = $db->escape($_GET['ip']);
    $lectorPuerto = $db->escape($_GET['puerto']);
  }
  $seccion->consumir($codigo, $fecha, $incidencia, $lectorIP, $lectorPuerto);
}
