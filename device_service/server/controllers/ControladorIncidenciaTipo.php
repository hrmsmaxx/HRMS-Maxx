<?php
require_once ROOT_URL . "/server/Utilidades.php";
require_once ROOT_URL . "/server/controllers/ControladorEntidadAbstracto.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadIncidenciaTipo.php";
class ControladorIncidenciaTipo extends ControladorEntidadAbstracto
{
  public function crearInformacion()
  {
    global $Utilidades;

    $errores = array();
    $informacion = array();

    $informacion["id_incidencia_tipo"] = $Utilidades->getPost('iddata', "int");
    $informacion["nombre"] = $Utilidades->getPost('Nombre', "string");
    $informacion["activo"] = $Utilidades->getPost('estado', "int");

    if (strlen($informacion["nombre"]) > 100) $Utilidades->addError($errores, 'El largo máximo del campo Nombre es 100 caracteres.');
    if (empty($informacion["nombre"])) $Utilidades->addError($errores, 'Complete todos los campos para continuar.');

    return array("error" => $errores, "data" => $informacion);
  }
}

$ControladorIncidenciaTipo = new ControladorIncidenciaTipo($EntidadIncidenciaTipo);
