<?php
require_once ROOT_URL . "/server/Utilidades.php";
require_once ROOT_URL . "/server/controllers/ControladorEntidadAbstracto.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadDepartamento.php";
class ControladorDepartamento extends ControladorEntidadAbstracto
{
  public function crearInformacion()
  {
    global $Utilidades;

    $errores = array();
    $informacion = array();

    $informacion["id_departamento"] = $Utilidades->getPost('iddata', "int");
    $informacion["nombre"] = $Utilidades->getPost('Nombre', "string");
    $informacion["incidencia_defecto"] = $Utilidades->getPost('Incidencia-por-defecto', "string");
    $informacion["responsables"] = $Utilidades->getPost('Responsable', "array");
    $informacion["activo"] = $Utilidades->getPost('estado', "int");

    if (strlen($informacion["incidencia_defecto"]) > 100) $Utilidades->addError($errores, 'El largo máximo del campo Incidencia por defecto es 100 caracteres.');
    if (strlen($informacion["nombre"]) > 100) $Utilidades->addError($errores, 'El largo máximo del campo Nombre es 100 caracteres.');
    if (empty($informacion["nombre"])) $Utilidades->addError($errores, 'Complete todos los campos para continuar.');

    return array("error" => $errores, "data" => $informacion);
  }
}

$ControladorDepartamento = new ControladorDepartamento($EntidadDepartamento);
