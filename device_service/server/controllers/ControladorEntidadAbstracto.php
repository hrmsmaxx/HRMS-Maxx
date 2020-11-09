<?php
require_once ROOT_URL . "/server/Utilidades.php";
class ControladorEntidadAbstracto
{
  public $entidad = null;
  public function __construct($Entidad)
  {
    $this->entidad = $Entidad;
  }

  public function obtenerSelectInfo()
  {
    return $this->entidad->obtenerSelectInfo();
  }

  public function agregar($resultado = null)
  {
    global $company;
    global $Utilidades;
    if (empty($resultado)) {
      $resultado = $this->crearInformacion();
      $resultado["subdomain_id"] = $company->subdomain_id;
    }
    if (sizeof($resultado["error"]) == 0) {
      $resultadoCrear = $this->entidad->agregar($resultado["data"]);
      $error = array();
      if (!empty($resultadoCrear)) {
        $Utilidades->addError($error, $this->entidad->nombre . ' creado con éxito. ', "success");
      } else {
        $Utilidades->addError($error, 'Error al agregar.');
      }
      return $error;
    }
    return $resultado["error"];
  }

  public function borrar()
  {
    global $Utilidades;
    global $db;
    $id = $db->escape($_POST['iddata']);
    $resultadoBorrar = $this->entidad->borrar($id);
    $error = array();
    if ($resultadoBorrar) {
      $Utilidades->addError($error, $this->entidad->nombre . ' eliminado con éxito. ', "success");
    } else {
      $Utilidades->addError($error, 'Error al borrar.');
    }
    return $error;
  }

  public function editar($resultado = null, $id = null)
  {
    global $Utilidades;
    global $db;
    global $company;
    if (empty($id)) {
      $id = $db->escape($_POST['iddata']);
    }
    if (empty($resultado)) {
      $resultado = $this->crearInformacion();
      $resultado["subdomain_id"] = $company->subdomain_id;
    }
    if (sizeof($resultado["error"]) == 0) {
      $resultadoEditar = $this->entidad->editar($id, $resultado["data"]);
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
    //todo
  }
}
