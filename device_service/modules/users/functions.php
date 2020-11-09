<?php
class Seccion
{
  var $message = array();
  var $table = '_user';
  var $option = 'users';
  var $status = '';

  var $nombre = 'Usuarios';
  var $icono = 'glyphicon glyphicon-list';

  function listar()
  {
    global $db;

    $where = "WHERE u.id <> 1";
    $data = $db->get_results("SELECT u.id, u.username, u.user_role_id, u.first_name, u.last_name, u.status, ur.name as role FROM $this->table as u INNER JOIN _user_role as ur ON u.user_role_id = ur.id $where", array("u", "ur"));
    return $data;
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
        return true;
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos para agregar usuarios.', 'msg_style' => 'danger'));
      }
    } elseif (isset($_POST['editar'])) {
      if ($inicio->can_do('agregar')) {
        $this->editar();
        return true;
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos para editar usuarios.', 'msg_style' => 'danger'));
      }
    }
  }

  function agregar()
  {
    global $db;

    $usuario = strtolower($db->escape($_POST['Usuario']));
    $nombre = $db->escape($_POST['Nombre']);
    $apellido = $db->escape($_POST['Apellido']);
    $contrasena = $db->escape($_POST['Contraseña']);
    $rol = $db->escape($_POST['rol']);

    $pts = 0;

    if (strlen($usuario) > 65) {
      array_push($this->message, array('msg' => 'El largo máximo del campo Usuario es 65 caracteres.', 'msg_style' => 'warning'));
      $pts++;
    }
    if (strlen($nombre) > 400) {
      array_push($this->message, array('msg' => 'El largo máximo del campo Nombre es 400 caracteres.', 'msg_style' => 'warning'));
      $pts++;
    }
    if (strlen($apellido) > 400) {
      array_push($this->message, array('msg' => 'El largo máximo del campo Apellido es 400 caracteres.', 'msg_style' => 'warning'));
      $pts++;
    }

    if (empty($usuario) || empty($nombre) || empty($contrasena) || empty($apellido)) {
      array_push($this->message, array('msg' => 'Los campos obligatorios son: nombre, usuario  y contraseña.', 'msg_style' => 'warning'));
      $pts++;
    }
    if (!preg_match('/^[A-Za-z]+[A-Za-z0-9_.]{3,60}$/', $usuario)) {
      array_push($this->message, array('msg' => 'El usuario elegido es inválido. Solo puede contener letras, números, y los signos _ o . con un mínimo de 4 y un máximo de 20 caracteres. ', 'msg_style' => 'warning'));
      $pts++;
    }
    $userexist = $db->get_var("SELECT id_usuario FROM " . $this->table . " WHERE usuario ='" . $usuario . "'");
    if (!empty($userexist)) {
      array_push($this->message, array('msg' => 'Ya existe un usuario registrado con ese nombre de usuario.', 'msg_style' => 'danger'));
      $pts++;
    }
    $largo = strlen($contrasena);
    if ($largo < 6) {
      array_push($this->message, array('msg' => 'La contraseña debe de contener almenos 6 caracteres. Contiene: ' . $largo, 'msg_style' => 'warning'));
      $pts++;
    }
    $largo = strlen($nombre);
    if ($largo > 400) {
      array_push($this->message, array('msg' => 'El nombre debe de contener menos de 35 caracteres. Contiene: ' . $largo, 'msg_style' => 'warning'));
      $pts++;
    }
    $largo = strlen($apellido);
    if ($largo > 400) {
      array_push($this->message, array('msg' => 'El apellido debe de contener menos de 50 caracteres. Contiene: ' . $largo, 'msg_style' => 'warning'));
      $pts++;
    }


    if ($pts == 0) {
      $db->put("INSERT INTO $this->table (username, hashed_password, first_name, last_name, user_role_id) VALUES ('$usuario', '" . md5($contrasena) . "', '$nombre', '$apellido', '$rol')");
      array_push($this->message, array('msg' => 'Usuario creado con éxito.', 'msg_style' => 'success'));
    }
  }

  function editar()
  {
    global $db;
    $pts = 0;

    $iddata = $db->escape($_POST['iddata']);
    $usuario = strtolower($db->escape($_POST['Usuario']));
    $nombre = $db->escape($_POST['Nombre']);
    $rol = $db->escape($_POST['rol']);
    $apellido = $db->escape($_POST['Apellido']);
    $contrasena = $db->escape($_POST['Contraseña']);
    $activo = $db->escape(substr($_POST['activo'], 3));

    $pts = 0;

    if (strlen($usuario) > 65) {
      array_push($this->message, array('msg' => 'El largo máximo del campo Usuario es 65 caracteres.', 'msg_style' => 'warning'));
      $pts++;
    }
    if (strlen($nombre) > 400) {
      array_push($this->message, array('msg' => 'El largo máximo del campo Nombre es 400 caracteres.', 'msg_style' => 'warning'));
      $pts++;
    }
    if (strlen($apellido) > 400) {
      array_push($this->message, array('msg' => 'El largo máximo del campo Apellido es 400 caracteres.', 'msg_style' => 'warning'));
      $pts++;
    }

    if (empty($iddata) || $iddata == 1) {
      array_push($this->message, array('msg' => 'No puedes editar este usuario.', 'msg_style' => 'danger'));
      $pts++;
    }

    if (empty($nombre) || (empty($activo) && ($activo != '0')) || empty($rol)) {
      array_push($this->message, array('msg' => 'Complete todos los campos para continuar.', 'msg_style' => 'warning'));
      $pts++;
    }
    $userexist = $db->get_var("SELECT id FROM " . $this->table . " WHERE username ='" . $usuario . "' AND id <> " . $iddata);
    if (!empty($userexist)) {
      array_push($this->message, array('msg' => 'Ya existe un usuario registrado con ese nombre de usuario.', 'msg_style' => 'danger'));
      $pts++;
    }



    if ($pts == 0) {
      if (!empty($contrasena)) $changepass = ", hashed_password = '" . md5($contrasena) . "' ";
      else $changepass = "";

      $db->put("UPDATE $this->table SET first_name = '$nombre', last_name = '$apellido', username = '$usuario', user_role_id = '$rol', status = '$activo' " . $changepass . " WHERE id = '$iddata'");
      array_push($this->message, array('msg' => 'Usuario editado con éxito.', 'msg_style' => 'success'));
      $this->status = 'edit_success';
    } else {
      $this->status = 'edit_danger';
    }
  }
}
