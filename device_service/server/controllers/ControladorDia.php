<?php
require_once ROOT_URL . "/server/Utilidades.php";
require_once ROOT_URL . "/server/controllers/ControladorEntidadAbstracto.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadDia.php";
class ControladorDia extends ControladorEntidadAbstracto
{
  public function crearInformacion()
  {
    global $Utilidades;

    $errores = array();
    $informacion = array();

    $informacion["id_dia"] = $Utilidades->getPost('iddata', "int");
    $informacion["nombre"] = $Utilidades->getPost('Nombre', "string");
    $informacion["id_dia_tipo"] = $Utilidades->getPost('tipo', "int");
    $informacion["dia"] = $Utilidades->getPost('Dia', "int");
    $informacion["mes"] = $Utilidades->getPost('Mes', "int");
    $informacion["ano"] = $Utilidades->getPost('Año', "int");
    $informacion["multiplicador"] = $Utilidades->getPost('Multiplicador', "string");
    $informacion["activo"] = $Utilidades->getPost('estado', "int");

    if (!empty($informacion["dia"]) && !is_numeric($informacion["dia"])) $Utilidades->addError($errores, 'El campo Día debe ser un número.');
    if (!empty($informacion["mes"]) && !is_numeric($informacion["mes"])) $Utilidades->addError($errores, 'El campo Mes debe ser un número.');
    if (!empty($informacion["ano"]) && !is_numeric($informacion["ano"])) $Utilidades->addError($errores, 'El campo Año debe ser un número.');
    if (!empty($informacion["multiplicador"]) && !is_numeric($informacion["multiplicador"])) $Utilidades->addError($errores, 'El campo Multiplicador debe ser un número.');

    if (strlen($informacion["dia"]) > 2) $Utilidades->addError($errores, 'El largo máximo del campo Día es 2 caracteres.');
    if (strlen($informacion["mes"]) > 2) $Utilidades->addError($errores, 'El largo máximo del campo Mes es 2 caracteres.');
    if (strlen($informacion["ano"]) > 4) $Utilidades->addError($errores, 'El largo máximo del campo Año es 4 caracteres.');
    if (strlen($informacion["nombre"]) > 100) $Utilidades->addError($errores, 'El largo máximo del campo Nombre es 100 caracteres.');
    if (empty($informacion["nombre"]) || empty($informacion["id_dia_tipo"]) || empty($informacion["dia"]) || empty($informacion["mes"]) || empty($informacion["multiplicador"])) $Utilidades->addError($errores, 'Complete todos los campos para continuar.');
    if (empty($informacion["ano"])) {
      $informacion["ano"] = 0;
    }
    return array("error" => $errores, "data" => $informacion);
  }
}

$ControladorDia = new ControladorDia($EntidadDia);
