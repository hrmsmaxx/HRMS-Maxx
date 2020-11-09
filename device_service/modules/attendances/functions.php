<?php
require_once ROOT_URL . "/server/models/Filtro.php";
require_once ROOT_URL . "/server/models/Marca.php";
require_once ROOT_URL . "/server/controllers/ControladorMarca.php";
require_once ROOT_URL . "/server/Utilidades.php";

class Seccion
{
  var $message = array();
  var $table = '_attendance';
  var $option = 'attendances';
  var $status = '';

  var $nombre = 'Marcas';
  var $nombreSingular = 'Marca';
  var $icono = 'glyphicon glyphicon-list';

  var $codigo = "";
  var $funcionario = "";
  var $incidencia = "";
  var $fecha_desde = "";
  var $fecha_hasta = "";
  var $dispositivo = "";

  function url()
  {
    return 'index.php?option=' . $this->option . '&nofiltro';
  }

  function listar($error = false)
  {
    global $db;
    global $inicio;
    global $Filtro;

    $filtro = '';
    $joins = '';
    $joins .= " LEFT JOIN _workcode as w ON w.id = a.workcode_id";
    $joins .= " LEFT JOIN _device as d ON d.id = a.device_id";
    $joins .= " LEFT JOIN _location as l ON l.id = d.location_id";
    if (isset($_GET["filtrar"])) {
      $this->codigo = $Filtro->obtenerParametro('codigo', array('largo' => 10, 'error' => $error));
      $this->funcionario = $Filtro->obtenerParametro('funcionario', array('largo' => 11, 'error' => $error));
      $this->dispositivo = $Filtro->obtenerParametro('dispositivo', array('largo' => 11, 'error' => $error));
      $this->incidencia = $Filtro->obtenerParametro('incidencia', array('largo' => 11, 'error' => $error));
      $this->fecha_desde = $Filtro->obtenerParametro('fecha_desde', array("tipo" => "date"));
      $this->fecha_hasta = $Filtro->obtenerParametro('fecha_hasta', array("tipo" => "date"));

      if (!empty($this->codigo)) $filtro .= " AND e.device_code = " . $this->codigo;
      if (!empty($this->funcionario)) $filtro .= " AND e.id = " . $this->funcionario;
      if (!empty($this->incidencia)) {
        $filtro .= " AND w.id = " . $this->incidencia;
      }
      if (!empty($this->dispositivo)) {
        $filtro .= " AND a.device_id = " . $this->dispositivo;
      }
      if (!empty($this->fecha_desde)) $filtro .= " AND a.date >= " . $this->fecha_desde;
      if (!empty($this->fecha_hasta)) $filtro .= " AND a.date <= " . $this->fecha_hasta;

      $_SESSION["filtro"] = array(
        $this->option => array(
          "filtrar" => $filtro,
          "joins" => $joins,
          "codigo" => $this->codigo,
          "funcionario" => $this->funcionario,
          "incidencia" => $this->incidencia,
          "dispositivo" => $this->dispositivo,
          "fecha_desde" => $this->fecha_desde,
          "fecha_hasta" => $this->fecha_hasta,
        )
      );
    } else if (!isset($_GET["nofiltro"]) && isset($_SESSION["filtro"]) && isset($_SESSION["filtro"][$this->option])) {
      $filtro = $_SESSION["filtro"][$this->option]["filtrar"];
      $joins = $joins;
    } else {
      $_SESSION["filtro"] = null;
    }

    $filtro = " WHERE 1=1 " . $filtro;
    if (!empty($filtro)) {
      $filtro .= " ORDER BY a.date DESC LIMIT 0, 1000";
    } else {
      $filtro .= " ORDER BY a.date DESC LIMIT 51";
    }
    $data = $db->get_results("SELECT a.*, e.device_code AS employee_device_code, e.first_name AS employee_first_name, e.last_name AS employee_last_name, w.name AS workcode_name, CONCAT(d.ip,':',d.port,' - ',COALESCE(l.name,'')) as device FROM $this->table as a INNER JOIN _employee as e ON a.employee_id = e.id $joins " . $filtro, array("a"));
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
    global $Utilidades;
    $permiso = true;
    if (isset($_POST['importar'])) {
      if ($inicio->can_do('agregar')) {
        $this->importar();
      }
    }
    if (!$permiso) {
      $Utilidades->addError($this->message, 'No tienes permisos.', "error");
    }
  }

  function cargarMarcasDesdeLog($filename, $line, $id_lector = null)
  {
    global $db;
    if (empty($id_lector)) {
      $splittedName = explode("-", $filename);
      if (sizeof($splittedName) >= 3) {
        $ip = $splittedName[1];
        $puerto = $splittedName[2];
        if (!empty($ip) && !empty($puerto)) {
          $id_lector = $db->get_var("SELECT id_lector FROM lector WHERE ip = '$ip' AND puerto = '$puerto'");
        }
      }
    }
    if (empty($id_lector)) {
      $id_lector = 0;
    }

    //0 -> codigo funcionario
    //1 -> fecha marca
    //2 -> codigo incidencia
    //3 -> activo
    $trimmed = trim($line);
    $spaces = explode(",", $trimmed);
    if (sizeof($spaces) > 3) {
      $codigo = $db->escape($spaces[0]);
      $fecha = $spaces[1];
      $incidencia = $db->escape($spaces[2]);

      $datosFechaHora = explode(" ", $fecha);
      $datosFecha = explode("/", $datosFechaHora[0]);
      $datosHora = explode(":", $datosFechaHora[1]);
      $year = $datosFecha[2];
      $month = $datosFecha[1];
      $day = $datosFecha[0];

      $hora = $datosHora[0];
      $minuto = $datosHora[1];
      $segundo = $datosHora[2];

      $date = date($day . "/" . $month . "/" . $year . " " . $hora . ":" . $minuto . ":" . $segundo);
      return Marca::consumir($codigo, "", "", "", $date, $incidencia, 2, $id_lector);
    }
  }

  function importar()
  {
    global $Utilidades;
    ini_set('max_execution_time', '1800'); //30 min

    if (isset($_FILES['archivoshow']) && !empty($_FILES['archivoshow']['tmp_name'])) {
      $id_lector = $_POST['lector'];
      $ext = pathinfo($_FILES['archivoshow']['name'], PATHINFO_EXTENSION);
      $fp = fopen($_FILES['archivoshow']['tmp_name'], 'rb');
      if ($ext == "zip") {
        $zip = new ZipArchive;
        if ($zip->open($_FILES['archivoshow']['tmp_name']) === TRUE) {
          for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);
            $fp = $zip->getStream($name);
            if (!$fp) exit("failed\n");
            while (!feof($fp)) {
              while (($line = fgets($fp)) !== false) {
                $this->cargarMarcasDesdeLog($name, $line, null);
              }
            }
            fclose($fp);
          }
          $Utilidades->addError($this->message, 'Marcas importadas con exito.', "success");
        } else {
          $Utilidades->addError($this->message, 'Error al leer el archivo comprimido.', "warning");
        }
      } else if ($ext == "txt") {
        while (($line = fgets($fp)) !== false) {
          $this->cargarMarcasDesdeLog($_FILES['archivoshow']['tmp_name'], $line, $id_lector);
        }
        $Utilidades->addError($this->message, 'Marcas importadas con exito.', "success");
      } else if ($ext == "dat") {
        while (($line = fgets($fp)) !== false) {
          $trimmed = trim($line);
          $spaces = explode("\t", $trimmed);
          //0 -> codigo funcionario
          //1 -> fecha marca
          //2 -> ?
          //3 -> in out NO SE USA
          //4 -> ?
          //5 -> codigo incidencia
          $datosFechaHora = explode(" ", $spaces[1]);
          $datosFecha = explode("-", $datosFechaHora[0]);
          $datosHora = explode(":", $datosFechaHora[1]);
          $year = $datosFecha[0];
          $month = $datosFecha[1];
          $day = $datosFecha[2];

          $hora = $datosHora[0];
          $minuto = $datosHora[1];
          $segundo = $datosHora[2];

          $date = date($day . "/" . $month . "/" . $year . " " . $hora . ":" . $minuto . ":" . $segundo);
          Marca::consumir($spaces[0], "", "", "", $date, $spaces[5], 2, $id_lector);
        }
        $Utilidades->addError($this->message, 'Marcas importadas con exito.', "success");
      } else {
        $Utilidades->addError($this->message, 'Archivo no reconocido.');
      }
    }
  }
}
