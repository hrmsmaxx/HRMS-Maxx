<?php
require_once ROOT_URL . "/server/Utilidades.php";
require_once ROOT_URL . "/server/controllers/ControladorEntidadAbstracto.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadOpcion.php";
class ControladorOpcion extends ControladorEntidadAbstracto
{
  public function agregar($resultado = null)
  {
    //// TODO:
    return false;
  }

  public function borrar()
  {
    //// TODO:
    return false;
  }

  public function editar($resultado = null, $id = null)
  {
    global $Utilidades;
    global $db;
    $resultado = $this->crearInformacion();
    if (sizeof($resultado["error"]) == 0) {
      $resultadoEditar = $this->entidad->editar(null, $resultado["data"]);
      $error = array();
      if (!empty($resultadoEditar)) {
        $Utilidades->addError($error, $this->entidad->nombre . ' editado con éxito. ', "success");
      } else {
        $Utilidades->addError($error, 'Error al editar.');
      }
      return $error;
    }
    return $resultado["error"];
  }
  public function crearInformacion()
  {
    global $Utilidades;

    $errores = array();
    $informacion = array();

    $informacion["nombre_empresa"] = $Utilidades->getPost('Nombre-empresa', "string");
    $informacion["razon_social"] = $Utilidades->getPost('Razon-social', "string");
    $informacion["direccion"] = $Utilidades->getPost('Direccion', "string");
    $informacion["ciudad"] = $Utilidades->getPost('Ciudad', "string");
    $informacion["rut"] = $Utilidades->getPost('Rut', "string");
    $informacion["telefono"] = $Utilidades->getPost('Telefono', "string");
    $informacion["email"] = $Utilidades->getPost('Email', "string");
    $informacion["fax"] = $Utilidades->getPost('Fax', "string");
    $informacion["web"] = $Utilidades->getPost('Web', "string");
    $informacion["fecha_liquidacion"] = $Utilidades->getPost('fecha_liquidacion', "date");
    $informacion["alerta_liquidacion"] = $Utilidades->getPost('Alerta-dias-liquidacion', "int");
    $informacion["cierreMarcas"] = $Utilidades->getPost('cierreMarcas', "int");

    if (!empty($informacion)) {
      foreach ($informacion as $key => $value) {
        if (strlen($value) > 30000) $Utilidades->addError($errores, 'El largo máximo del campo ' . $key . ' es 30000 caracteres.');
      }
    }

    return array("error" => $errores, "data" => $informacion);
  }
}

$ControladorOpcion = new ControladorOpcion($EntidadOpcion);
