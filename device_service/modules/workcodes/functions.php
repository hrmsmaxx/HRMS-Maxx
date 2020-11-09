<?php
require_once ROOT_URL . "/server/controllers/ControladorIncidencia.php";
class Seccion
{
  var $message = array();
  var $table = '_workcode';
  var $option = 'workcodes';
  var $status = '';

  var $nombre = 'Incidencias';
  var $nombreSingular = 'Incidencia';
  var $icono = 'glyphicon glyphicon-list';

  function listar()
  {
    global $db;
    return $db->get_results("SELECT * FROM $this->table ORDER BY ABS(device_code) ASC");
  }

  function cargar($id)
  {
    global $db;
    return $db->get_row("SELECT  * FROM $this->table WHERE id = '$id'");
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
    global $ControladorIncidencia;
    $this->message = $ControladorIncidencia->agregar();
  }

  function editar()
  {
    global $ControladorIncidencia;
    $this->message = $ControladorIncidencia->editar();
  }
}
