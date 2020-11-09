<?php
require_once ROOT_URL . "/server/Utilidades.php";
require_once ROOT_URL . "/server/controllers/ControladorEntidadAbstracto.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadUbicacion.php";
class ControladorUbicacion extends ControladorEntidadAbstracto
{
  public function crearInformacion()
  {
    global $Utilidades;

    $errores = array();
    $informacion = array();

    $informacion["id"] = $Utilidades->getPost('iddata', "int");
    $informacion["name"] = $Utilidades->getPost('Nombre', "string");
    $informacion["parent_location_id"] = $Utilidades->getPost('padre', "int");
    $informacion["status"] = $Utilidades->getPost('estado', "int");

    if (strlen($informacion["name"]) > 300) $Utilidades->addError($errores, 'El largo máximo del campo Nombre es 300 caracteres.');
    if (empty($informacion["name"])) $Utilidades->addError($errores, 'Complete todos los campos para continuar.');
    if (empty($informacion["parent_location_id"])) {
      $padre = null;
    }

    return array("error" => $errores, "data" => $informacion);
  }
}

$ControladorUbicacion = new ControladorUbicacion($EntidadUbicacion);
