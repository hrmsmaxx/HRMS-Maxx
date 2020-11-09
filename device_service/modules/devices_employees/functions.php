<?php
require_once ROOT_URL . "/server/models/Funcionario.php";
require_once ROOT_URL . "/server/models/Filtro.php";


class Seccion
{
  var $message = array();
  var $table = '_employee_device';
  var $option = 'devices_employees';
  var $status = '';
  var $lector = 0;

  var $nombre = 'Funcionarios en lector';
  var $nombreSingular = 'Funcionarios en lector';
  var $icono = 'glyphicon glyphicon-list';
  var $list = null;
  var $fechaHoy = null;
  var $infoLector = null;

  function cargarInfo()
  {
    global $db;
    $this->list = $this->listar();
    if (empty($this->lector)) {
      header("Location: index.php?option=devices_employees");
      die();
    }

    $this->fechaHoy = date("d/m/Y", time());
    $this->infoLector = null;
    if (!empty($this->lector)) {
      $this->infoLector = $db->get_row("SELECT d.*, l.name as ubicacion_nombre FROM _device as d LEFT JOIN _location as l ON l.id = d.location_id WHERE d.id = '" . $this->lector . "'", array("d"));
      $this->fechaHoy = date("d/m/Y", time());
    }
  }

  function url()
  {
    return 'index.php?option=' . $this->option . '&lector=' . $this->lector . '&nofiltro';
  }

  function listar()
  {
    global $db;
    global $Filtro;
    $data = null;
    if (isset($_GET["lector"]) && !empty($_GET["lector"])) {
      $this->lector = $db->escape($_GET["lector"]);
    }
    $joins = 'LEFT JOIN _device as d ON de.device_id = d.id LEFT JOIN _employee as e ON de.employee_id = e.id';
    $filtro = '';
    if (!empty($this->lector)) {
      if (isset($_GET["filtrar"])) {
        $this->estado = $Filtro->obtenerParametro('estado', array('largo' => 1));
        $this->codigo = $Filtro->obtenerParametro('codigo', array('largo' => 10));
        $this->funcionario = $Filtro->obtenerParametro('funcionario', array('largo' => 11));
        $this->turno = $Filtro->obtenerParametro('turno', array('largo' => 11));
        $this->centro = $Filtro->obtenerParametro('centro', array('largo' => 11));
        $this->departamento = $Filtro->obtenerParametro('departamento', array('largo' => 11));
        $this->responsable = $Filtro->obtenerParametro('responsable', array('largo' => 11));
        $this->privilegio = $Filtro->obtenerParametro('privilegio', array('largo' => 1));
        $this->colaActualizar = $Filtro->obtenerParametro('actualizar', array('largo' => 1));

        if (!empty($this->estado)) {
          if ($this->estado == 1) {
            $filtro .= " AND de.status = 1";
          } else if ($this->estado == 2) {
            $filtro .= " AND de.status = 0";
          }
        }

        if (!empty($this->codigo)) $filtro .= " AND e.device_code = " . $this->codigo;
        if (!empty($this->funcionario)) $filtro .= " AND e.id = " . $this->funcionario;
        if (!empty($this->privilegio)) $filtro .= " AND de.privilege_type = '$this->privilegio'";
        if (!empty($this->colaActualizar)) {
          if ($this->colaActualizar == 1) {
            $filtro .= " AND de.updated = 0";
          } else {
            $filtro .= " AND de.updated = 1";
          }
        }

        $_SESSION["filtro"] = array(
          $this->option => array(
            "filtrar" => $filtro,
            "joins" => $joins,
            "estado" => $this->estado,
            "codigo" => $this->codigo,
            "funcionario" => $this->funcionario,
            "turno" => $this->turno,
            "centro" => $this->centro,
            "departamento" => $this->departamento,
            "responsable" => $this->responsable,
            "privilegio" => $this->privilegio,
            "colaActualizar" => $this->colaActualizar
          )
        );
      } else if (!isset($_GET["nofiltro"]) && isset($_SESSION["filtro"]) && isset($_SESSION["filtro"][$this->option])) {
        $joins = $_SESSION["filtro"][$this->option]["joins"];
        $filtro = $_SESSION["filtro"][$this->option]["filtrar"];
      } else {
        $_SESSION["filtro"] = null;
      }

      if (empty($filtro)) {
        $filtro .= " GROUP BY de.employee_id ORDER BY e.device_code ASC LIMIT 0, 50";
      } else {
        $filtro .= " GROUP BY de.employee_id ORDER BY e.device_code ASC";
      }
      $data = $db->get_results("SELECT e.device_code as funcionario_codigo, e.first_name as funcionario_nombre, e.last_name as funcionario_apellido, e.status as funcionario_activo, de.access_limit as tope, de.status as activo, de.device_id as id_lector, de.employee_id as id_funcionario, de.privilege_type FROM $this->table as de $joins WHERE de.device_id = '" . $this->lector . "' AND de.deleted = 0 " . $filtro, array("de"));
    }
    return $data;
  }

  function cargarFuncionario($lector, $funcionario)
  {
    global $db;
    return $db->get_row("SELECT e.device_code as funcionario_codigo, e.first_name as funcionario_nombre, e.last_name as funcionario_apellido, e.status as funcionario_activo, de.access_limit as tope, de.status as activo, de.device_id as id_lector, de.employee_id as id_funcionario, de.privilege_type FROM $this->table as de LEFT JOIN _device as d ON de.device_id = d.id LEFT JOIN _employee as e ON de.employee_id = e.id WHERE de.device_id = '$lector' AND de.employee_id = '$funcionario' AND de.deleted = 0 GROUP BY de.employee_id ORDER BY e.last_name, e.first_name ASC", array("de"));
  }

  function check_forms()
  {
    global $inicio;

    if (isset($_POST['agregarFuncionario'])) {
      if ($inicio->can_do('agregar')) {
        $this->agregarFuncionario();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos.', 'msg_style' => 'error'));
      }
    } elseif (isset($_POST['editarFuncionario'])) {
      if ($inicio->can_do('agregar')) {
        $this->editarFuncionario();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos.', 'msg_style' => 'error'));
      }
    } elseif (isset($_POST['borrarFuncionario'])) {
      if ($inicio->can_do('agregar')) {
        $this->borrarFuncionario();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos.', 'msg_style' => 'error'));
      }
    }
  }

  function borrarFuncionario()
  {
    global $db;

    $pts = 0;
    $id_funcionario = $db->escape($_POST['funcionario']);
    $id_lector = $db->escape($_POST['lector']);

    if (Funcionario::borrarDeLector($id_funcionario, $id_lector)) {
      array_push($this->message, array('msg' => 'Funcionario eliminado con exito.', 'msg_style' => 'success'));
      $pts++;
    } else {
      array_push($this->message, array('msg' => 'Complete todos los campos para continuar.', 'msg_style' => 'warning'));
      $pts++;
    }
    $this->lector = $id_lector;
  }

  function agregarFuncionario()
  {
    global $db;

    $pts = 0;

    $id_funcionario = $db->escape($_POST['funcionario']);
    $id_lector = $db->escape($_POST['lector']);
    $topeAcceso = $db->escape($_POST['tope']);

    $privilegio = $db->escape($_POST['privilegio']);
    if (empty($privilegio)) {
      $privilegio = 0;
    }
    if (empty($topeAcceso)) {
      $topeAcceso = 0;
    }

    if (Funcionario::agregarALector($id_funcionario, $id_lector, $topeAcceso, $privilegio)) {
      array_push($this->message, array('msg' => 'Funcionario agregado con éxito. ', 'msg_style' => 'success'));
      $this->status = 'add_cat_success';
    } else {
      array_push($this->message, array('msg' => 'Complete todos los campos para continuar.', 'msg_style' => 'warning'));
      $pts++;
      $this->status = 'add_cat_error';
    }

    $this->lector = $id_lector;
  }

  function editarFuncionario()
  {
    global $db;

    $id_funcionario = $db->escape($_POST['funcionario']);
    $id_lector = $db->escape($_POST['lector']);
    $topeAcceso = $db->escape($_POST['tope']);
    $activo = $db->escape($_POST['estado']);

    $privilegio = $db->escape($_POST['privilegio']);
    if (empty($privilegio)) {
      $privilegio = 0;
    }
    if (empty($topeAcceso)) {
      $topeAcceso = 0;
    }
    $pts = 0;

    if (empty($id_funcionario) || empty($id_lector)) {
      array_push($this->message, array('msg' => 'Complete todos los campos para continuar.', 'msg_style' => 'warning'));
      $pts++;
    }

    if ($pts == 0) {
      $db->put("UPDATE $this->table SET updated = 0, access_limit = '$topeAcceso', privilege_type = '$privilegio', status = '$activo' WHERE employee_id = '$id_funcionario' AND device_id = '$id_lector'");
      $tiempo = time();
      array_push($this->message, array('msg' => 'Funcionario editado con éxito. ', 'msg_style' => 'success'));
      $this->status = 'add_cat_success';
    } else {
      $this->status = '';
    }
    $this->lector = $id_lector;
  }
}
