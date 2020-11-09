<?php
if (isset($_POST["funcionario"]) && isset($_POST["fecha"]) && isset($_POST["incidencia"]) && isset($_POST["dispositivo_reloj"])) {
  $funcionario = $db->escape($_POST['funcionario']);
  $fecha = $inicio->parse_fecha($db->escape($_POST['fecha']));
  $incidencia = $db->escape($_POST['incidencia']);
  $dispositivo_reloj = $db->escape($_POST['dispositivo_reloj']);
  Marca::agregar($funcionario, $fecha, $incidencia, $dispositivo_reloj, 1);
}
