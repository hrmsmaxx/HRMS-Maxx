<?php
require_once ROOT_URL . "/server/models/Entidad/EntidadMarca.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadFuncionario.php";

$origin_type = array(
  'manual', 'standalone', 'adms', 'batch'
);
$verification_type = array(
  'pin', 'password', 'card', 'fingerprint', 'face', 'other'
);

class Marca
{
  static public function consumir($codigo, $nombre, $password, $activo, $fecha, $incidencia, $origen, $id_lector = null)
  {
    global $db;
    global $inicio;
    global $EntidadFuncionario;
    $funcionario = $db->get_row("SELECT id FROM _employee WHERE device_code = '$codigo'");

    $id_lector = $db->escape($id_lector);
    $lector = $db->get_row("SELECT * FROM _device WHERE id = '$id_lector'");
    if (empty($lector)) {
      $id_lector = null;
    }

    if (empty($funcionario)) {
      if (empty($lector) || $lector->save_employee == 1) {
        if (empty($nombre)) {
          $nombre = "";
        }
        if (empty($password)) {
          $password = "";
        }
        if (empty($activo)) {
          $activo = "true";
        }
        if (strtolower($activo) == "true") {
          $activo = 1;
        } else {
          $activo = 0;
        }
        if (empty($EntidadFuncionario)) {
          $EntidadFuncionario = new EntidadFuncionario("_employee", "Funcionario");
        }
        $informacion = array();
        $informacion["first_name"] = $nombre;
        $informacion["last_name"] = ' ';
        $informacion["device_code"] = $codigo;
        $informacion["device_password"] = $password;
        $informacion["lectores"] = array($id_lector);
        $funcionario = $EntidadFuncionario->agregar($informacion);
      }
    } else {
      $funcionario = $funcionario->id;
    }

    $id_incidencia = 0;
    if (!empty($incidencia) && $incidencia != 0) {
      $incidenciaDB = $db->get_row("SELECT id FROM _workcode WHERE device_code =" . $incidencia);
      if (!empty($incidenciaDB)) {
        $id_incidencia = $incidenciaDB->id_incidencia;
      }
    }
    Marca::agregar($funcionario, $fecha, $id_incidencia, $id_lector, $origen);
  }

  static public function agregar($funcionario, $fecha_real, $incidencia, $lector = 0, $m = 1)
  {
    global $db;
    global $EntidadMarca;
    $errors = array();
    $origen = $m;
    if (isset($_POST['origen'])) {
      $origen = $db->escape($_POST['origen']);
    }
    if (empty($origen)) {
      $origen = 1;
    }

    $pts = 0;
    if (empty($incidencia)) {
      $incidencia = null;
    }
    if (empty($lector)) {
      $lector = null;
    }
    if (empty($funcionario) || empty($fecha_real)) {
      array_push($errors, array('msg' => 'Complete todos los campos para continuar.', 'msg_style' => 'warning'));
      $pts++;
    }

    @list($fecha, $hora) = @explode(" ", $fecha_real);
    @list($dia, $mes, $ano) = @explode("/", $fecha);
    @list($horas, $min, $seg) = @explode(":", $hora);

    $fecha_real = $ano . "-" . $mes . "-" . $dia . " " . $horas . ":" . $min . ":" . $seg;
    if ($pts == 0) {
      if (empty($EntidadMarca)) {
        $EntidadMarca = new EntidadAbstracta("_attendance", "Marca");
      }
      $informacion = array();
      $informacion["employee_id"] = $funcionario;
      $informacion["workcode_id"] = $incidencia;
      $informacion["date"] = $fecha_real;
      $informacion["device_id"] = $lector;
      switch ($origen) {
        case 1:
          $origen = "manual";
          break;
        case 2:
        case 5:
          $origen = "batch";
          break;
        case 3:
          $origen = "standalone";
          break;
        case 4:
          $origen = "adms";
          break;
      }
      $informacion["origin_type"] = $origen;
      $EntidadMarca->agregar($informacion);
      array_push($errors, array('msg' => 'Marca creada con éxito. ', 'msg_style' => 'success'));
    }
    return $errors;
  }
}
