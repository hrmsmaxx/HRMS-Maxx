<?php

require_once ROOT_URL . "/server/models/Filtro.php";
require_once ROOT_URL . "/server/models/Funcionario.php";
require_once ROOT_URL . "/server/models/Registro.php";
require_once ROOT_URL . "/server/controllers/ControladorFuncionario.php";

class Seccion
{

  var $message = array();
  var $table = '_employee';
  var $option = 'employees';
  var $status = '';

  var $nombre = 'Funcionarios';
  var $nombreSingular = 'Funcionario';
  var $icono = 'glyphicon glyphicon-list';

  var $device_code = "";
  var $employee_id = "";
  var $employee_status = 0;

  function url()
  {
    return 'index.php?option=' . $this->option . '&nofiltro';
  }

  function listar()
  {
    global $db;
    global $Filtro;

    $filtro = '';
    if (isset($_GET["filtrar"])) {
      $this->employee_status = $Filtro->obtenerParametro('estado', array('largo' => 1));
      $this->device_code = $Filtro->obtenerParametro('codigo', array('largo' => 10));
      $this->employee_id = $Filtro->obtenerParametro('funcionario', array('largo' => 11));

      if (!empty($this->employee_status)) {
        if ($this->employee_status == 1) {
          $filtro .= " AND e.status = 1";
        } else if ($this->employee_status == 2) {
          $filtro .= " AND e.status = 0";
        }
      }

      if (!empty($this->device_code)) $filtro .= " AND e.device_code = " . $this->device_code;
      if (!empty($this->employee_id)) $filtro .= " AND e.id = " . $this->employee_id;

      if (!empty($filtro)) $filtro = " WHERE " . substr($filtro, 4);
      if (isset($_GET['filtrar']) || isset($_GET['action'])) {
        $filtro .= " GROUP BY e.id ORDER BY e.device_code ASC";
      } else {
        $filtro .= " GROUP BY e.id ORDER BY e.device_code ASC LIMIT 0, 150";
      }
      $_SESSION["filtro"] = array(
        $this->option => array(
          "filtrar" => $filtro,
          "status" => $this->employee_status,
          "device_code" => $this->device_code,
          "employee_id" => $this->employee_id,
        )
      );
    } else if (!isset($_GET["nofiltro"]) && isset($_SESSION["filtro"]) && isset($_SESSION["filtro"][$this->option])) {
      $filtro = $_SESSION["filtro"][$this->option]["filtrar"];
    } else {
      $_SESSION["filtro"] = null;
      $filtro = "WHERE 1=1 GROUP BY e.id ORDER BY e.device_code ASC LIMIT 150";
    }
    return $db->get_results("SELECT e.* FROM $this->table as e " . $filtro, array("e"));
  }

  function cargar($id)
  {
    global $db;
    return $db->get_row("SELECT e.*, (SELECT group_concat(de.device_id SEPARATOR ', ') FROM _employee_device as de WHERE de.employee_id = '$id') as devices FROM $this->table as e WHERE e.id = '$id'", array("e"));
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
    } elseif (isset($_POST['editarMultiple'])) {
      if ($inicio->can_do('agregar')) {
        $this->editarMultiple();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos.', 'msg_style' => 'error'));
      }
    } elseif (isset($_POST['importar'])) {
      if ($inicio->can_do('agregar')) {
        $this->importar();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos.', 'msg_style' => 'error'));
      }
    } elseif (isset($_POST['borrar'])) {
      if ($inicio->can_do('agregar')) {
        $this->borrar();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos.', 'msg_style' => 'error'));
      }
    }
  }

  function importar()
  {
    global $db;
    global $inicio;
    $tiempoAhora = time();

    if (isset($_FILES['archivoshow']) && $_FILES['archivoshow']['size'] > 0) {
      $fp = fopen($_FILES['archivoshow']['tmp_name'], 'rb');
      while (($line = fgets($fp)) !== false) {
        $trimmed = trim($line);
        $chars = str_split($trimmed);
        $raro = false;
        $data = array();
        $tmp = "";
        $user = array();
        $user["nombre"] = "";
        $user["codigo"] = "";
        foreach ($chars as $c) {
          if (ord($c) > 31) {
            if ($raro === true && $tmp != "") {
              if (empty($user["nombre"])) {
                $user["nombre"] = $tmp;
              } else {
                $user["codigo"] = $tmp;
                array_push($data, $user);
                $user = array();
                $user["nombre"] = "";
                $user["codigo"] = "";
              }
              $tmp = "";
            }
            $tmp .= $c;
            $raro = false;
          } else {
            $raro = true;
          }
        }
        if ($tmp != "") {
          if (empty($user["nombre"])) {
            $user["nombre"] = $tmp;
          } else {
            $user["codigo"] = $tmp;
            array_push($data, $user);
          }
        }
        foreach ($data as $d) {
          $codigo = $d["codigo"];
          $nombre = $d["nombre"];
          $id_funcionario = null;
          $funcionarioDB = $db->get_row("SELECT id_funcionario,codigo FROM funcionario WHERE activo = 1 AND codigo = '" . $codigo . "'");
          if (empty($funcionarioDB)) {
            $db->put("INSERT INTO $this->table (nombre, apellido, codigo, codigo_sueldo, domicilio, telefono, mail,id_turno,id_centro,id_departamento,id_responsable,activo,registro_usuario,registro_fecha) VALUES ('$nombre', ' ', '$codigo', ' ', ' ', ' ',' ',0,0,0,0,1,'$inicio->id','$tiempoAhora')");
            $id_funcionario = $db->insert_id;
          } else {
            $id_funcionario = $funcionarioDB->id_funcionario;
          }

          $id_lector = $_POST['lector'];
          if (!empty($id_lector) && !empty($id_funcionario)) {
            $funcionarioPrevio = $db->get_row("SELECT * FROM lector_funcionario WHERE id_funcionario = '$id_funcionario' AND id_lector = '$id_lector'");
            if (empty($funcionarioPrevio)) {
              $db->put("INSERT INTO lector_funcionario (id_funcionario,id_lector,topeAcceso,activo) VALUES ('$id_funcionario','$id_lector',0,1)");
              $tiempo = time();
              $db->put("INSERT INTO lector_funcionario_estado (id_funcionario,id_lector,fecha,activo) VALUES ('$id_funcionario','$id_lector','$tiempo',1)");
              array_push($this->message, array('msg' => 'Funcionario agregado con éxito. ', 'msg_style' => 'success'));
              $this->status = 'add_cat_success';
            }
          }
        }
      }
      array_push($this->message, array('msg' => 'Funcionarios importados con exito.', 'msg_style' => 'success'));
    }
  }

  function agregar()
  {
    global $ControladorFuncionario;
    $this->message = $ControladorFuncionario->agregar();
  }

  function borrar()
  {
    global $ControladorFuncionario;
    $this->message = $ControladorFuncionario->borrar();
  }

  function editar()
  {
    global $ControladorFuncionario;
    $this->message = $ControladorFuncionario->editar();
  }

  function editarMultiple()
  {
    global $db;
    global $ControladorFuncionario;

    $activo = $db->escape($_POST['activo']);
    $eliminarTodas = $db->escape($_POST['eliminarTodas']);

    $lectores = "";
    if (!empty($_POST['lector'])) {
      $l = $_POST['lector'];
      if (!empty($l) && is_array($l)) {
        $lectores = array();
        foreach ($l as $e) {
          array_push($lectores, $e);
        }
      }
    } else {
      $lectores = array();
    }

    $funcionarios = json_decode($_POST['iddata']);

    if (!empty($funcionarios)) {
      $informacion = array();

      if ($activo !== "not") {
        $informacion["activo"] = $activo;
      }

      if (!in_array("not", $lectores)) {
        $informacion["lectores"] = $lectores;
      }

      if ($eliminarTodas == "1") {
        $informacion["eliminarTodas"] = $eliminarTodas;
      }
      $this->message = $ControladorFuncionario->editar(array("error" => array(), "data" => $informacion), $funcionarios);
    } else {
      $this->status = '';
    }
  }

  function addFuncionarioLector($codigo, $nombre, $password, $activo, $id_lector, $tarjeta)
  {
    global $db;
    $funcionario = $db->get_row("SELECT * FROM $this->table WHERE device_code = '$codigo'");
    $id_funcionario = 0;
    if (empty($funcionario)) {
      $nombre = $db->escape($nombre);
      $codigo = $db->escape($codigo);
      $password = $db->escape($password);
      $activo = $db->escape($activo);
      $db->put("INSERT INTO $this->table (first_name,device_code,device_password,status) VALUES ('$nombre','$codigo','$password','$activo')");
      $id_funcionario = $db->insert_id;
    } else {
      $id_funcionario = $funcionario->id;
    }

    if (!empty($tarjeta)) {
      $tarjeta = $db->escape($tarjeta);
      $tarjeta_usada = $db->get_row("SELECT rfid_card FROM $this->table WHERE rfid_card = '$tarjeta' AND id <> '$id_funcionario'");
      if (empty($tarjeta_usada)) {
        $db->put("UPDATE $this->table SET rfid_card = '$tarjeta' WHERE id = '$id_funcionario'");
      }
    }

    if (!empty($id_lector)) {
      $db->put("INSERT IGNORE INTO _employee_device (employee_id,device_id,access_limit,updated) VALUES ('$id_funcionario','$id_lector',0,1)");
    }
  }

  function addHuellaLector($codigo, $dedo, $base64)
  {
    global $db;
    global $company;
    $funcionario = $db->get_row("SELECT id FROM $this->table WHERE device_code = '$codigo'");
    if (!empty($funcionario)) {
      $db->put("INSERT IGNORE INTO _employee_fingerprint (employee_id, base64, finger_number) VALUES ('$funcionario->id','$base64','$dedo')");
    }
  }

  function addRostroLector($codigo, $base64, $length)
  {
    global $db;
    global $company;
    $funcionario = $db->get_row("SELECT * FROM $this->table WHERE device_code = '$codigo'");
    if (!empty($funcionario)) {
      $id = $funcionario->id_funcionario;
      $rostroFuncionario = $db->get_row("SELECT * FROM _employee_face WHERE employee_id = '$id'");
      if (!empty($rostroFuncionario)) {
        $db->put("UPDATE IGNORE _employee_face SET base64 = '$base64', length = '$length' WHERE employee_id = '$id'");
      } else {
        $db->put("INSERT IGNORE INTO _employee_face (employee_id, base64, length) VALUES ('$id','$base64','$length')");
      }
    }
  }
}
