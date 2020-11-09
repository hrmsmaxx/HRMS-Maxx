<?php
if (isset($_POST["iddata"]) && isset($_POST["funcionario"]) && isset($_POST["fecha"]) && isset($_POST["incidencia"]) && isset($_POST["dispositivo_reloj"]) && isset($_POST["observacion"]) && isset($_POST["funcionario_documento"])) {
  $seccion->editar();
  die;
}
