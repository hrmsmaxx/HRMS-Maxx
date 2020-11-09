<?php
class Funcionario
{
  static public function obtenerLectores($employee_id)
  {
    global $db;
    return $db->get_results("SELECT device_id FROM _employee_device WHERE deleted = 0 AND employee_id = '$employee_id'");
  }

  static public function agregarALectores($id_funcionario, $lectores, $topeAcceso = 0, $privilegio = 0)
  {
    $lectoresFuncionario = Funcionario::obtenerLectores($id_funcionario);
    if (!empty($lectoresFuncionario)) {
      foreach ($lectoresFuncionario as $l) {
        $esta = false;
        if (!empty($lectores)) {
          foreach ($lectores as $lector) {
            if ($lector == $l->device_id) {
              $esta = true;
              break;
            }
          }
        }
        if ($esta == false) {
          Funcionario::borrarDeLector($id_funcionario, $l->id);
        }
      }
    }
    if (!empty($lectores)) {
      foreach ($lectores as $lector) {
        Funcionario::agregarALector($id_funcionario, $lector, $topeAcceso, $privilegio);
      }
    }
  }
  static public function borrarDeLector($id_funcionario, $id_lector)
  {
    global $db;
    if (empty($id_funcionario) || empty($id_lector)) {
      return false;
    } else {
      $db->put("UPDATE _employee_device SET deleted = 1, updated = 1, access_limit = 0 WHERE employee_id = '$id_funcionario' AND device_id = '$id_lector'");
      return true;
    }
  }
  static public function agregarALector($id_funcionario, $id_lector, $topeAcceso = 0, $privilegio = 0)
  {
    global $db;
    if (empty($id_funcionario) || empty($id_lector)) {
      return false;
    } else {
      $funcionarioPrevio = $db->get_row("SELECT * FROM _employee_device WHERE employee_id = '$id_funcionario' AND device_id = '$id_lector'");
      if (empty($funcionarioPrevio)) {
        $db->put("INSERT INTO _employee_device (employee_id,device_id,access_limit,privilege_type,status) VALUES ('$id_funcionario','$id_lector','$topeAcceso','$privilegio',1)");
      } else {
        if ($funcionarioPrevio->eliminado == 1) {
          $db->put("UPDATE _employee_device SET deleted=0, updated=0, access_limit = '$topeAcceso', privilege_type = '$privilegio' WHERE employee_id = '$id_funcionario' AND device_id = '$id_lector'");
        }
      }
      return true;
    }
  }
}
