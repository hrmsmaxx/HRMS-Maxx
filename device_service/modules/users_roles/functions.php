<?php
class Seccion
{
  var $message = array();
  var $table = '_user_role';
  var $option = 'users_roles';
  var $status = '';

  var $nombre = 'Rol';
  var $icono = 'glyphicon glyphicon-list';

  function listar()
  {
    global $db;
    return $db->get_results("SELECT * FROM $this->table WHERE id <> 1 ORDER BY id");
  }

  function cargar($id)
  {
    global $db;
    return $db->get_row("SELECT * FROM $this->table WHERE id = '$id'");
  }

  function check_forms()
  {
    global $inicio;

    if (isset($_POST['agregar'])) {
      if ($inicio->can_do('agregar')) {
        $this->agregar();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos para agregar usuarios.', 'msg_style' => 'danger'));
      }
    } elseif (isset($_POST['editar'])) {
      if ($inicio->can_do('agregar')) {
        $this->editar();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos para editar usuarios.', 'msg_style' => 'danger'));
      }
    }
  }

  function agregar()
  {
    global $db;
    $pts = 0;

    $rol = $db->escape($_POST['Rol']);
    $menu = $db->escape($_POST['menu']);
    $opcionesForm = json_decode($_POST['opciones']);

    $opciones = array();
    if (!empty($opcionesForm)) {
      foreach ($opcionesForm as $e) {
        if (!isset($opciones[$e->modulo])) $opciones[$e->modulo] = array();
        $opciones[$e->modulo][$e->o] = true;
      }
    }


    if (strlen($rol) > 50) {
      array_push($this->message, array('msg' => 'El largo máximo del campo Rol es 50 caracteres.', 'msg_style' => 'warning'));
      $pts++;
    }


    if (empty($rol)) {
      array_push($this->message, array('msg' => 'Complete el nombre para continuar.', 'msg_style' => 'warning'));
      $pts++;
    }

    if ($pts == 0) {
      $permisos = json_encode($opciones);
      $db->put("INSERT INTO $this->table (name, menu_id, permissions) VALUES ('$rol', '$menu', '$permisos')");
      array_push($this->message, array('msg' => 'Rol de usuario creado con éxito.', 'msg_style' => 'success'));
    }
  }

  function editar()
  {
    global $db;
    $pts = 0;

    $iddata = $db->escape($_POST['iddata']);
    $rol = $db->escape($_POST['Rol']);
    $opcionesForm = json_decode($_POST['opciones']);
    $menu = $db->escape($_POST['menu']);

    $opciones = array();
    if (!empty($opcionesForm)) {
      foreach ($opcionesForm as $e) {
        if (!isset($opciones[$e->modulo])) $opciones[$e->modulo] = array();
        $opciones[$e->modulo][$e->o] = true;
      }
    }
    if (strlen($rol) > 50) {
      array_push($this->message, array('msg' => 'El largo máximo del campo Rol es 50 caracteres.', 'msg_style' => 'warning'));
      $pts++;
    }

    if (empty($rol)) {
      array_push($this->message, array('msg' => 'Complete el nombre para continuar.', 'msg_style' => 'warning'));
      $pts++;
    }

    if ($pts == 0) {
      $permisos = json_encode($opciones);
      $db->put("UPDATE $this->table SET name = '$rol', menu_id = '$menu', permissions = '$permisos' WHERE id = " . $iddata);
      array_push($this->message, array('msg' => 'Rol de usuario editado con éxito.', 'msg_style' => 'success'));
    }
  }
}
