<?php
require_once ROOT_URL . "/server/Utilidades.php";
require_once ROOT_URL . "/server/controllers/ControladorEntidadAbstracto.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadIncidencia.php";
class ControladorIncidencia extends ControladorEntidadAbstracto
{
  public function crearInformacion()
  {
    global $db;
    global $Utilidades;

    $errores = array();
    $informacion = array();

    $informacion["id"] = $Utilidades->getPost('iddata', "int");
    $informacion["name"] = $Utilidades->getPost('Nombre', "string");
    $informacion["device_code"] = $Utilidades->getPost('Codigo', "int");
    $informacion["status"] = $Utilidades->getPost('estado', "int");

    if ($informacion["device_code"] != "0") {
      $condicion = "";
      if (!empty($informacion["id"])) {
        $condicion = " AND id != " . $informacion["id"];
      }
      $incidenciaConMismoCodigo = $db->get_results("SELECT id FROM _workcode WHERE device_code = '" . $informacion["device_code"] . "'" . $condicion);
      if (!empty($incidenciaConMismoCodigo)) $Utilidades->addError($errores, 'Ya existe una incidencia con el codigo ' . $informacion["device_code"] . '.');
    } else {
      $informacion["device_code"] = null;
    }

    if (strlen($informacion["device_code"]) > 5) $Utilidades->addError($errores, 'El largo máximo del campo Código es 5 caracteres.');
    if (strlen($informacion["name"]) > 100) $Utilidades->addError($errores, 'El largo máximo del campo Nombre es 100 caracteres.');
    if (empty($informacion["name"])) $Utilidades->addError($errores, 'Complete el nombre para continuar.');

    return array("error" => $errores, "data" => $informacion);
  }
}

$ControladorIncidencia = new ControladorIncidencia($EntidadIncidencia);
