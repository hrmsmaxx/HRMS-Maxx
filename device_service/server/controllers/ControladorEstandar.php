<?php
require_once ROOT_URL . "/server/Utilidades.php";
require_once ROOT_URL . "/server/controllers/ControladorEntidadAbstracto.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadEstandar.php";
class ControladorEstandar extends ControladorEntidadAbstracto
{
  public function crearInformacion()
  {
    global $Utilidades;

    $errores = array();
    $informacion = array();
    $informacion["id_estandar"] = $Utilidades->getPost('iddata', "int");
    $informacion["id_departamento"] = $Utilidades->getPost('departamento', "int");
    $informacion["id_ubicacion"] = $Utilidades->getPost('ubicacion', "int");
    $informacion["id_turno"] = $Utilidades->getPost('turno', "int");
    $informacion["cantidad_dias"] = $Utilidades->getPost('cantidad_dias', "int");
    $informacion["dias"] = $Utilidades->getPost('dias', "jsonA");
    $informacion["activo"] = $Utilidades->getPost('activo', "int");

    if (empty($informacion["id_departamento"]) || empty($informacion["id_ubicacion"]) || empty($informacion["id_turno"])) $Utilidades->addError($errores, 'Complete todos los campos para continuar.');

    if (empty($informacion["cantidad_personas"])) {
      $informacion["cantidad_personas"] = 0;
    }
    if (empty($informacion["fecha_inicio"])) {
      $informacion["fecha_inicio"] = time();
    }
    return array("error" => $errores, "data" => $informacion);
  }
}

$ControladorEstandar = new ControladorEstandar($EntidadEstandar);
