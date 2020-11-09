<?php
require_once ROOT_URL . "/server/models/Entidad.php";
class EntidadAbstracta
{
  public $tabla = "";
  public $nombre = "";
  private $identificador = "";
  private $selectInfo = null;

  public function __construct($tabla, $nombre)
  {
    $this->tabla = $tabla;
    $this->nombre = $nombre;
  }

  public function obtenerSelectInfo()
  {
    global $db;
    if (empty($this->identificador)) {
      $identificador = $db->get_row("SHOW KEYS FROM $this->tabla WHERE Key_name = 'PRIMARY'");
      $this->identificador = $identificador->Column_name;
    }
    if ($this->selectInfo === null) {
      $this->selectInfo = $db->get_results("SELECT $this->identificador as value, CONCAT($this->identificador,' - ',nombre) as name FROM $this->tabla WHERE activo = 1 ORDER BY $this->identificador");
      if (!empty($this->selectInfo)) {
        ksort($this->selectInfo);
      }
    }
    return $this->selectInfo;
  }

  public function agregar($informacion, $id_usuario = null)
  {
    if ($this->agregarBefore($informacion, $id_usuario)) {
      $id = Entidad::agregar($this->tabla, $informacion, $id_usuario);
      if (!empty($id)) {
        $this->agregarAfter($id, $informacion);
        return $id;
      }
    }
    return null;
  }

  public function editar($id, $informacion, $id_usuario = null)
  {
    if ($this->editarBefore($id, $informacion, $id_usuario)) {
      $id = Entidad::editar($this->tabla, $id, $informacion, $id_usuario);
      if (!empty($id)) {
        $this->editarAfter($id, $informacion);
        return true;
      }
    }
    return false;
  }

  public function borrar($id, $id_usuario = null)
  {
    if ($this->borrarBefore($id, $id_usuario)) {
      $id = Entidad::borrar($this->tabla, $id, $id_usuario);
      if (!empty($id)) {
        $this->borrarAfter($id);
        return true;
      }
    }
    return false;
  }

  public function agregarBefore($informacion, $id_usuario)
  {
    return true;
  }
  public function editarBefore($id, $informacion, $id_usuario)
  {
    return true;
  }
  public function borrarBefore($id, $id_usuario)
  {
    return true;
  }

  public function agregarAfter($id, $informacion)
  {
  }
  public function editarAfter($id, $informacion)
  {
  }
  public function borrarAfter($id)
  {
  }
}
