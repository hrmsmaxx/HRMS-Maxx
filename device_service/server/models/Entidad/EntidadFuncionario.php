<?php
require_once ROOT_URL . "/server/models/Funcionario.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadAbstracta.php";
class EntidadFuncionario extends EntidadAbstracta
{
  public function agregarAfter($id, $informacion)
  {
    global $db;
    if (array_key_exists("cargos", $informacion)) {
      Funcionario::actualizarCargos($id, $informacion["cargos"]);
    }
    if (array_key_exists("departamentos", $informacion)) {
      Funcionario::actualziarDepartametnos($id, $informacion["departamentos"]);
    }
    if (array_key_exists("id_turno", $informacion)) {
      Funcionario::actualizarTurno($id, $informacion["id_turno"]);
    }
    if (array_key_exists("huella", $informacion)) {
      $db->put("UPDATE huella SET id_funcionario='$id' WHERE id_huella = '" . $informacion["huella"] . "'");
    }
    if (array_key_exists("fotoFuncionario", $informacion) && !empty($informacion["fotoFuncionario"])) {
      $extension = @end(explode('.', $informacion["fotoFuncionario"]['name']));
      $ruta = 'uploads/funcionarios/' . ID_EMPRESA . '-' . $id . '.' . $extension;
      move_uploaded_file($informacion["fotoFuncionario"]['tmp_name'], $ruta);
      $db->put("UPDATE " . $this->tabla . " SET foto = '$ruta' WHERE id_funcionario = '$id'");
    }
    if (array_key_exists("lectores", $informacion)) {
      Funcionario::agregarALectores($id, $informacion["lectores"], 0);
    }
  }
  public function editarAfter($id, $informacion)
  {
    global $db;
    if (!is_array($id)) {
      $id = array($id);
    }
    foreach ($id as $i) {
      if (array_key_exists("eliminarTodas", $informacion) && $informacion["eliminarTodas"] == "1") {
        $db->put("DELETE FROM huella WHERE id_funcionario = '$i'");
      }
      if (array_key_exists("cargos", $informacion)) {
        Funcionario::actualizarCargos($i, $informacion["cargos"]);
      }
      if (array_key_exists("departamentos", $informacion)) {
        Funcionario::actualziarDepartametnos($i, $informacion["departamentos"]);
      }
      if (array_key_exists("id_turno", $informacion)) {
        Funcionario::actualizarTurno($i, $informacion["id_turno"]);
      }
      if (array_key_exists("huella", $informacion)) {
        $db->put("UPDATE huella SET id_funcionario='$i' WHERE id_huella = '" . $informacion["huella"] . "'");
      }
      if (array_key_exists("fotoFuncionario", $informacion) && !empty($informacion["fotoFuncionario"])) {
        $extension = @end(explode('.', $informacion["fotoFuncionario"]['name']));
        $ruta = 'uploads/funcionarios/' . ID_EMPRESA . '-' . $i . '.' . $extension;
        move_uploaded_file($informacion["fotoFuncionario"]['tmp_name'], $ruta);
        $db->put("UPDATE " . $this->tabla . " SET foto = '$ruta' WHERE id_funcionario = '$i'");
      }
      if (array_key_exists("lectores", $informacion)) {
        Funcionario::agregarALectores($i, $informacion["lectores"], 0);
      }
      $db->put("UPDATE lector_funcionario SET actualizar = 1 WHERE id_funcionario = '$i'");
    }
  }

  public function borrarAfter($id)
  {
    global $db;
    $tiempoAhora = time();
    $db->put("DELETE FROM huella WHERE id_funcionario = '$id'");
    $db->put("UPDATE funcionario_cargo SET fecha_fin='$tiempoAhora' WHERE fecha_fin = 0 AND id_funcionario = '$id'");
    $db->put("UPDATE funcionario_turno SET fecha_fin = '$tiempoAhora' WHERE fecha_fin = 0 AND id_funcionario = '$id'");
    $db->put("UPDATE lector_funcionario SET actualizar = 1, eliminado=1 WHERE id_funcionario = $id;");
  }
}

$EntidadFuncionario = new EntidadFuncionario("_employee", "Funcionario");
