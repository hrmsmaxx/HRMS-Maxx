<?php
require_once ROOT_URL . "/server/Utilidades.php";
require_once ROOT_URL . "/server/controllers/ControladorEntidadAbstracto.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadCargo.php";
class ControladorCargo extends ControladorEntidadAbstracto
{
  public function crearInformacion()
  {
    global $Utilidades;

    $errores = array();
    $informacion = array();

    $informacion["id_cargo"] = $Utilidades->getPost('iddata', "int");
    $informacion["nombre"] = $Utilidades->getPost('Nombre', "string");
    $informacion["activo"] = $Utilidades->getPost('estado', "int");

    if (strlen($informacion["nombre"]) > 300) $Utilidades->addError($errores, 'El largo máximo del campo Nombre es 300 caracteres.');
    if (empty($informacion["nombre"])) $Utilidades->addError($errores, 'Complete todos los campos para continuar.');

    return array("error" => $errores, "data" => $informacion);
  }
}

$ControladorCargo = new ControladorCargo($EntidadCargo);
