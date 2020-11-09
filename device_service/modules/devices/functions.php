<?php
class Seccion
{
  var $message = array();
  var $table = '_device';
  var $option = 'opciones-lectores';
  var $status = '';

  var $nombre = 'Dispositivos';
  var $nombreSingular = 'Dispositivo';
  var $icono = 'glyphicon glyphicon-list';

  function listar()
  {
    global $db;
    $data = $db->get_results("SELECT d.*, l.name as location_name FROM $this->table as d LEFT JOIN _location as l ON l.id = d.location_id ORDER BY d.id DESC");
    if (!empty($data)) {
      foreach ($data as $d) {
        $d->updateQueue = $db->get_var("SELECT COUNT(e.device_code) FROM _employee_device as ed LEFT JOIN _device as d ON ed.device_id = d.id LEFT JOIN _employee as e ON ed.employee_id = e.id WHERE ed.device_id = '$d->id' AND e.device_code <> '' AND ed.updated = 0");
      }
    }
    return $data;
  }

  function cargar($id)
  {
    global $db;
    return $db->get_row("SELECT d.* FROM $this->table as d WHERE d.id = '$id'");
  }

  function actualizarLector($id_lector, $ultimoConsumo, $ultimaActualizacion, $ultimoTiempo = 0)
  {
    global $db;
    if (!empty($id_lector)) {
      if (!empty($ultimoConsumo)) {
        $ultimoConsumo = '"' . date("Y-m-d H:i:s", $ultimoConsumo) . '"';
      } else {
        $ultimoConsumo = "NULL";
      }
      if (!empty($ultimaActualizacion)) {
        $ultimaActualizacion = '"' . date("Y-m-d H:i:s", $ultimaActualizacion) . '"';
      } else {
        $ultimaActualizacion = "NULL";
      }
      if (!empty($ultimoTiempo)) {
        $ultimoTiempo = '"' . date("Y-m-d H:i:s", $ultimoTiempo) . '"';
      } else {
        $ultimaActualizacion = "NULL";
      }
      $db->put("UPDATE _device SET last_consume = $ultimoConsumo, last_update=$ultimaActualizacion, last_clock = $ultimoTiempo WHERE id = '$id_lector'");
    }
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
    } elseif (isset($_POST['credenciales'])) {
      if ($inicio->can_do('agregar')) {
        $this->credenciales();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos.', 'msg_style' => 'error'));
      }
    }
  }

  function credenciales()
  {
    global $db;
    $apikey = $db->escape($_POST['ApiKey']);
    if (empty($apikey)) {
      array_push($this->message, array('msg' => 'Complete todos los campos para continuar.', 'msg_style' => 'warning'));
    } else {
      $db->put("UPDATE _subdomain SET apikey = '$apikey'");
      array_push($this->message, array('msg' => 'Credencial actualizada con exito a: ' . $apikey, 'msg_style' => 'success'));
    }
  }

  function agregar()
  {
    global $db;
    $this->status = 'add_cat_error';
    $pts = 0;

    $serial_number = $db->escape($_POST['serial']);
    if (empty($serial_number)) {
      $serial_number = "NULL";
    } else {
      $serial_number = "'" . $serial_number . "'";
    }
    $ip = $db->escape($_POST['Ip']);
    $puerto = $db->escape($_POST['Puerto']);
    $ubicacion = $db->escape($_POST['Ubicacion']);

    $borrar_marcas = $db->escape($_POST['borrar_marcas']);
    $crear_funcionario = $db->escape($_POST['crear_funcionario']);

    $modalidad_consumo = $db->escape($_POST['ModalidadConsumo']);
    $intervalo_consumo = $db->escape($_POST['IntervaloConsumo']);
    $horaCon = $db->escape($_POST['HoraConsumo']);
    $hora_consumo = 0;
    $minuto_consumo = 0;

    if (empty($modalidad_consumo)) {
      $modalidad_consumo = "NULL";
    } else {
      $modalidad_consumo = "'" . $modalidad_consumo . "'";
    }
    if (empty($intervalo_consumo)) {
      $intervalo_consumo = 0;
    }
    if (!empty($horaCon)) {
      $hora_consumo = intval(substr($horaCon, 0, 2));
      $minuto_consumo = intval(substr($horaCon, 3, 2));
    }

    $modalidad_actualizacion = $db->escape($_POST['ModalidadActualizacion']);
    $intervalo_actualizacion = $db->escape($_POST['IntervaloActualizacion']);
    $horaAct = $db->escape($_POST['HoraActualizacion']);
    $hora_actualizacion = 0;
    $minuto_actualizacion = 0;


    if (empty($modalidad_actualizacion)) {
      $modalidad_actualizacion = "NULL";
    } else {
      $modalidad_actualizacion = "'" . $modalidad_actualizacion . "'";
    }

    if (!empty($horaAct)) {
      $hora_actualizacion = intval(substr($horaAct, 0, 2));
      $minuto_actualizacion = intval(substr($horaAct, 3, 2));
    }

    $modalidad_tiempo = $db->escape($_POST['ModalidadTiempo']);
    $intervalo_tiempo = $db->escape($_POST['IntervaloTiempo']);
    $forma_tiempo = $db->escape($_POST['FormaTiempo']);
    $horaTiempo = $db->escape($_POST['HoraTiempo']);
    $hora_tiempo = 0;
    $minuto_tiempo = 0;

    if (!empty($horaTiempo)) {
      $hora_tiempo = intval(substr($horaTiempo, 0, 2));
      $minuto_tiempo = intval(substr($horaTiempo, 3, 2));
    }

    if (empty($intervalo_tiempo)) {
      $intervalo_tiempo = 0;
    }
    if (empty($forma_tiempo)) {
      $forma_tiempo = 0;
    }
    if (empty($modalidad_tiempo)) {
      $modalidad_tiempo = "NULL";
    } else {
      $modalidad_tiempo = "'" . $modalidad_tiempo . "'";
    }


    if (empty($id_lector_modelo)) {
      $id_lector_modelo = 0;
    }
    if (empty($ubicacion)) {
      $ubicacion = 'NULL';
    } else {
      $ubicacion = "'" . $ubicacion . "'";
    }

    if (strlen($ip) > 20) {
      array_push($this->message, array('msg' => 'El largo máximo del campo IP es 20 caracteres.', 'msg_style' => 'warning'));
      $pts++;
    }
    if (strlen($puerto) > 10) {
      array_push($this->message, array('msg' => 'El largo máximo del campo Puerto es 10 caracteres.', 'msg_style' => 'warning'));
      $pts++;
    }
    if (!empty($puerto) && !is_numeric($puerto)) {
      array_push($this->message, array('msg' => 'El campo Puerto debe ser un número.', 'msg_style' => 'warning'));
      $pts++;
    }

    if (empty($ip) || empty($puerto)) {
      array_push($this->message, array('msg' => 'Complete todos los campos para continuar.', 'msg_style' => 'warning'));
      $pts++;
    }


    if ($pts == 0) {
      $db->put("INSERT INTO $this->table (`serial_number`, `ip`, `port`, `location_id`, `update_mode`, `update_interval`, `update_time`, `consume_mode`, `consume_time`, `consume_interval`, `clock_mode`, `clock_interval`, `clock_time`, `timezone`, `clean_attendance`, `save_employee`) VALUES ($serial_number,'$ip','$puerto',$ubicacion,$modalidad_actualizacion,'$intervalo_actualizacion','$hora_actualizacion:$minuto_actualizacion',$modalidad_consumo,'$hora_consumo:$minuto_consumo','$intervalo_consumo',$modalidad_tiempo,'$intervalo_tiempo','$hora_tiempo:$minuto_tiempo','$crear_funcionario','$borrar_marcas','$crear_funcionario')");
      array_push($this->message, array('msg' => $this->nombreSingular . ' creado con éxito. ', 'msg_style' => 'success'));
      $this->status = 'add_cat_success';
    } else {
      $this->status = '';
    }
  }

  function editar()
  {
    global $db;

    $serial_number = $db->escape($_POST['serial']);
    if (empty($serial_number)) {
      $serial_number = "NULL";
    } else {
      $serial_number = "'" . $serial_number . "'";
    }
    $id = $db->escape($_POST['iddata']);
    $ip = $db->escape($_POST['Ip']);
    $puerto = $db->escape($_POST['Puerto']);
    $ubicacion = $db->escape($_POST['Ubicacion']);
    $estado = $db->escape($_POST['estado']);
    $borrar_marcas = $db->escape($_POST['borrar_marcas']);

    $crear_funcionario = $db->escape($_POST['crear_funcionario']);

    $modalidad_consumo = $db->escape($_POST['ModalidadConsumo']);
    $intervalo_consumo = $db->escape($_POST['IntervaloConsumo']);
    $horaCon = $db->escape($_POST['HoraConsumo']);
    $hora_consumo = 0;
    $minuto_consumo = 0;
    if (empty($modalidad_consumo)) {
      $modalidad_consumo = "NULL";
    } else {
      $modalidad_consumo = "'" . $modalidad_consumo . "'";
    }
    if (empty($intervalo_consumo)) {
      $intervalo_consumo = 0;
    }
    if (!empty($horaCon)) {
      $hora_consumo = intval(substr($horaCon, 0, 2));
      $minuto_consumo = intval(substr($horaCon, 3, 2));
    }

    $modalidad_actualizacion = $db->escape($_POST['ModalidadActualizacion']);
    $intervalo_actualizacion = $db->escape($_POST['IntervaloActualizacion']);
    $horaAct = $db->escape($_POST['HoraActualizacion']);
    $hora_actualizacion = 0;
    $minuto_actualizacion = 0;

    if (!empty($horaAct)) {
      $hora_actualizacion = intval(substr($horaAct, 0, 2));
      $minuto_actualizacion = intval(substr($horaAct, 3, 2));
    }

    $modalidad_tiempo = $db->escape($_POST['ModalidadTiempo']);
    $intervalo_tiempo = $db->escape($_POST['IntervaloTiempo']);
    $forma_tiempo = $db->escape($_POST['FormaTiempo']);
    $horaTiempo = $db->escape($_POST['HoraTiempo']);
    $hora_tiempo = 0;
    $minuto_tiempo = 0;

    if (!empty($horaTiempo)) {
      $hora_tiempo = intval(substr($horaTiempo, 0, 2));
      $minuto_tiempo = intval(substr($horaTiempo, 3, 2));
    }

    if (empty($intervalo_tiempo)) {
      $intervalo_tiempo = 0;
    }
    if (empty($intervalo_actualizacion)) {
      $intervalo_actualizacion = 0;
    }
    if (empty($forma_tiempo)) {
      $forma_tiempo = 0;
    }

    if (empty($modalidad_tiempo)) {
      $modalidad_tiempo = "NULL";
    } else {
      $modalidad_tiempo = "'" . $modalidad_tiempo . "'";
    }

    if (empty($modalidad_actualizacion)) {
      $modalidad_actualizacion = "NULL";
    } else {
      $modalidad_actualizacion = "'" . $modalidad_actualizacion . "'";
    }

    if (empty($id_lector_modelo)) {
      $id_lector_modelo = 0;
    }
    $pts = 0;

    if (empty($id_lector_modelo)) {
      $id_lector_modelo = 0;
    }
    if (empty($ubicacion)) {
      $ubicacion = 'NULL';
    } else {
      $ubicacion = "'" . $ubicacion . "'";
    }
    if (empty($ip) || empty($puerto)) {
      array_push($this->message, array('msg' => 'Complete todos los campos para continuar.', 'msg_style' => 'warning'));
      $pts++;
    }

    if ($pts == 0) {
      $db->put("UPDATE $this->table SET clean_attendance = '$borrar_marcas', save_employee='$crear_funcionario', ip = '$ip', port = '$puerto', location_id = $ubicacion, consume_mode = $modalidad_consumo, consume_time = '$hora_consumo:$minuto_consumo', consume_interval = '$intervalo_consumo', status = '$estado', update_time = '$hora_actualizacion:$minuto_actualizacion', update_mode = $modalidad_actualizacion, update_interval = '$intervalo_actualizacion', clock_mode = $modalidad_tiempo, timezone = '$forma_tiempo', clock_interval = '$intervalo_tiempo', clock_time = '$hora_tiempo:$minuto_tiempo', serial_number = $serial_number WHERE id = '$id'");
      array_push($this->message, array('msg' => $this->nombreSingular . ' editado con éxito. ', 'msg_style' => 'success'));
    } else {
      $this->status = '';
    }
  }
}
