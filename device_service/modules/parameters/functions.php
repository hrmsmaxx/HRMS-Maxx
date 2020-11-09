<?php
require_once ROOT_URL . "/server/controllers/ControladorOpcion.php";
class Seccion
{
  var $message = array();
  var $table = 'opcion';
  var $option = 'opciones';
  var $status = '';

  var $nombre = 'Datos de la empresa';
  var $icono = 'fa fa-cogs';

  function cargar($id)
  {
    global $db;
    return $db->get_results("SELECT $this->table.* FROM $this->table");
  }

  function check_forms()
  {
    global $inicio;
    if (isset($_POST['formOpciones'])) {
      if ($inicio->can_do('agregar')) {
        $this->editar();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos para editar usuarios.', 'msg_style' => 'danger'));
      }
    }
  }

  function editar()
  {
    global $ControladorOpcion;
    $this->message = $ControladorOpcion->editar();
  }
}
