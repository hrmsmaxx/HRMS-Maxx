<?php
require_once ROOT_URL . "/server/controllers/ControladorUbicacion.php";
class Seccion
{
  var $message = array();
  var $table = '_location';
  var $option = 'locations';
  var $status = '';

  var $nombre = 'Ubicaciones';
  var $nombreSingular = 'Ubicación';
  var $icono = 'glyphicon glyphicon-list';

  function listar()
  {
    global $db;
    return $db->get_results("SELECT m.*, s.name as parent_name FROM $this->table as m LEFT JOIN $this->table as s ON m.parent_location_id = s.id ORDER BY m.id DESC");
  }

  function cargar($id)
  {
    global $db;
    return $db->get_row("SELECT m.*, s.name as parent_name FROM $this->table as m LEFT JOIN $this->table as s ON m.parent_location_id = s.id WHERE m.id = '$id'", array("m"));
  }

  function check_forms()
  {
    global $inicio;
    if (isset($_POST['agregar'])) {
      if ($inicio->can_do('agregar')) {
        $this->agregar();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos.', 'msg_style' => 'error'));
      }
    } elseif (isset($_POST['editar'])) {
      if ($inicio->can_do('agregar')) {
        $this->editar();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos.', 'msg_style' => 'error'));
      }
    }
  }

  function agregar()
  {
    global $ControladorUbicacion;
    $this->message = $ControladorUbicacion->agregar();
  }

  function editar()
  {
    global $ControladorUbicacion;
    $this->message = $ControladorUbicacion->editar();
  }
}
