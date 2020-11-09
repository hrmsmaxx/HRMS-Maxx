<?php
require_once ROOT_URL . "/server/models/Reporte.php";

class Estadisticas
{
  public function __construct()
  {
  }
  var $icono = "md md-home";
  var $nombre = "Estadísticas";
  var $option = 'estadisticas';

  var $codigo = "";
  var $funcionario = "";
  var $turno = "";
  var $incidencia = "";
  var $departamento = "";
  var $fecha_desde = "";
  var $fecha_hasta = "";
  var $datosFuncionarios = null;
  var $datosPorFecha = null;
  var $presentes = null;
  var $seRetiraron = null;
  var $inasistencias = null;
  var $llegadasTarde = null;
  var $marcasPorFecha = null;
  var $fechaHoy = null;
  var $cantidadFuncionarios = 0;

  var $message = array();
  function url()
  {
    return 'index.php?option=' . $this->option . '&nofiltro';
  }
  function check_forms()
  {
    global $inicio;

    if (isset($_POST['actualizarOpcionesInicio'])) {
      if ($inicio->can_do('agregar')) {
        $this->editarOpcionesInicio();
      } else {
        array_push($this->message, array('msg' => 'No tienes permisos para editar usuarios.', 'msg_style' => 'danger'));
      }
    }
  }

  function getColumnasEstadisticas()
  {
    global $db;
    $config = $db->get_row("SELECT valor FROM opcion WHERE tipo = 'configuracion_inicio'");
    if (!empty($config)) {
      return json_decode($config->valor)->campos;
    } else {
      return json_decode("{}");
    }
  }

  function editarOpcionesInicio()
  {
    global $db;
    global $seccion;

    $total_accesos = $db->escape($_POST['total_accesos']);
    $total_accesos_activo = $db->escape($_POST['activo-total_accesos']);

    $asistieron = $db->escape($_POST['asistieron']);
    $asistieron_activo = $db->escape($_POST['activo-asistieron']);

    $continuan = $db->escape($_POST['continuan']);
    $continuan_activo = $db->escape($_POST['activo-continuan']);

    $retiraron = $db->escape($_POST['retiraron']);
    $retiraron_activo = $db->escape($_POST['activo-retiraron']);

    $regresaron = $db->escape($_POST['regresaron']);
    $regresaron_activo = $db->escape($_POST['activo-regresaron']);

    $retiraron_regresaron = $db->escape($_POST['retiraron_regresaron']);
    $retiraron_regresaron_activo = $db->escape($_POST['activo-retiraron_regresaron']);

    $o = array();
    $o["total_accesos"] = array();
    $o["total_accesos"]["texto"] = $total_accesos;
    $o["total_accesos"]["activo"] = $total_accesos_activo === "true";
    $o["asistieron"] = array();
    $o["asistieron"]["texto"] = $asistieron;
    $o["asistieron"]["activo"] = $asistieron_activo === "true";
    $o["continuan"] = array();
    $o["continuan"]["texto"] = $continuan;
    $o["continuan"]["activo"] = $continuan_activo === "true";
    $o["retiraron"] = array();
    $o["retiraron"]["texto"] = $retiraron;
    $o["retiraron"]["activo"] = $retiraron_activo === "true";
    $o["regresaron"] = array();
    $o["regresaron"]["texto"] = $regresaron;
    $o["regresaron"]["activo"] = $regresaron_activo === "true";
    $o["retiraron_regresaron"] = array();
    $o["retiraron_regresaron"]["texto"] = $retiraron_regresaron;
    $o["retiraron_regresaron"]["activo"] = $retiraron_regresaron_activo === "true";

    $json_campos = json_encode($o, JSON_UNESCAPED_UNICODE);

    $actividad = "";
    if (!empty($_POST['actividad'])) {
      $l = $_POST['actividad'];
      if (!empty($l) && is_array($l)) {
        $actividad = array();
        foreach ($l as $e) {
          if (is_numeric($e)) array_push($actividad, $e);
        }
      }
    }
    $asistencias = "";
    if (!empty($_POST['asistencias'])) {
      $l = $_POST['asistencias'];
      if (!empty($l) && is_array($l)) {
        $asistencias = array();
        foreach ($l as $e) {
          if (is_numeric($e)) array_push($asistencias, $e);
        }
      }
    }

    $o2 = array();
    $o2["actividad"] = $actividad;
    $o2["asistencias"] = $asistencias;

    $json_filtros = json_encode($o2, JSON_UNESCAPED_UNICODE);

    $realO = array();
    $realO["campos"] = $o;
    $realO["filtros"] = $o2;

    $json = json_encode($realO, JSON_UNESCAPED_UNICODE);

    $db->put("UPDATE opcion SET valor = '$json' WHERE tipo = 'configuracion_inicio'");
    array_push($seccion->message, array('msg' => 'Opciones guardadas con éxito.', 'msg_style' => 'success'));
  }


  function getFuncionario($id_funcionario)
  {
    global $db;

    $funcionario = $db->get_row("SELECT * FROM funcionario WHERE id_funcionario = '$id_funcionario'");
    if (!empty($funcionario)) {
      return $funcionario;
    } else {
      return null;
    }
  }

  function getMarcas()
  {
    global $db;

    $cuenta = $db->get_results("SELECT t.*, f.nombre AS funcionario_nombre, f.apellido AS funcionario_apellido, tu.nombre AS turno_nombre, d.nombre AS tipo_dia_nombre, oi.nombre AS incidencia_nombre FROM marca t INNER JOIN funcionario f ON t.id_funcionario = f.id_funcionario LEFT JOIN turno tu ON f.id_turno = tu.id_turno LEFT JOIN dia d ON d.id_dia = t.id_dia LEFT JOIN incidencia oi ON oi.id_incidencia = t.id_incidencia LEFT JOIN funcionario_departamento as fd ON f.id_funcionario = fd.id_funcionario " . $this->filtro);
    return $cuenta;
  }

  function ultimaMarcaHoy($id_funcionario)
  {
    global $db;
    $past = $this->funcionario;
    $this->funcionario = $id_funcionario;
    $this->listar();
    $marcas = $db->get_results("SELECT t.*, f.nombre AS funcionario_nombre, f.apellido AS funcionario_apellido, tu.nombre AS turno_nombre, d.nombre AS tipo_dia_nombre, oi.nombre AS incidencia_nombre FROM marca t INNER JOIN funcionario f ON t.id_funcionario = f.id_funcionario LEFT JOIN turno tu ON f.id_turno = tu.id_turno LEFT JOIN dia d ON d.id_dia = t.id_dia LEFT JOIN incidencia oi ON oi.id_incidencia = t.id_incidencia LEFT JOIN funcionario_departamento as fd ON f.id_funcionario = fd.id_funcionario " . $this->filtro);
    $this->funcionario = $past;
    if (!empty($marcas)) {
      return end($marcas);
    } else {
      return null;
    }
  }

  var $filtro = "";

  function listar()
  {
    global $db;
    global $db;
    global $inicio;
    if (!empty($_GET['codigo']) && is_numeric($_GET['codigo'])) $this->codigo = $db->escape($_GET['codigo']);
    if (!empty($_GET['funcionario'])) $this->funcionario = $db->escape($_GET['funcionario']);
    if (!empty($_GET['turno'])) $this->turno = $db->escape($_GET['turno']);
    if (!empty($_GET['incidencia'])) $this->incidencia = $db->escape($_GET['incidencia']);

    if (!empty($_GET['id_departamento'])) {
      $l = $_GET['id_departamento'];
      if (!empty($l) && is_array($l)) {
        $this->departamento = array();
        foreach ($l as $e) {
          if (is_numeric($e)) array_push($this->departamento, $e);
        }
      }
    }

    if (!empty($_GET['fecha_desde'])) $this->fecha_desde = $inicio->parse_fecha($_GET['fecha_desde']);
    if (!empty($_GET['fecha_hasta'])) $this->fecha_hasta = $inicio->parse_fecha($_GET['fecha_hasta']);

    if (empty($this->fecha_desde)) {
      $this->fecha_desde = strtotime(date('Y-m-d', strtotime(date("Y-m-d", time()) . ' - 13 days')));
    }
    if (empty($this->fecha_hasta)) {
      $this->fecha_hasta = strtotime(date('Y-m-d', time()));
    }
    $this->fecha_desde = strtotime(date("Y-m-d 00:00:00", $this->fecha_desde));
    $this->fecha_hasta = strtotime(date("Y-m-d 23:59:59", $this->fecha_hasta));

    $filtro = '';
    if (!empty($this->codigo)) $filtro .= " AND f.codigo = " . $this->codigo;
    if (!empty($this->funcionario)) $filtro .= " AND f.id_funcionario = " . $this->funcionario;
    if (!empty($this->turno)) $filtro .= " AND tu.id_turno = " . $this->turno;
    if (!empty($this->incidencia)) $filtro .= " AND oi.id_incidencia = " . $this->incidencia;
    if (!empty($this->departamento)) {
      $filtro .= " AND (";
      foreach ($this->departamento as $key) {
        $filtro .= " fd.id_departamento = " . $key . " OR";
      }
      $filtro = substr($filtro, 0, -3);
      $filtro .= ")";
    }
    if (!empty($this->fecha_desde)) $filtro .= " AND t.fecha >= " . $this->fecha_desde;
    if (!empty($this->fecha_hasta)) $filtro .= " AND t.fecha <= " . $this->fecha_hasta;

    if (!empty($filtro)) $filtro = " WHERE " . substr($filtro, 4);
    $filtro .= " ORDER BY t.fecha ASC";
    $this->filtro = $filtro;
    $this->obtenerDatos();
  }


  function getMarcasFecha($marcas, $fecha)
  {
    $startOfDay = strtotime(date("Y-m-d 00:00:00", $fecha));
    $endOfDay = strtotime(date("Y-m-d 23:59:59", $fecha));
    $marcasDeFecha = array();
    if (!empty($marcas)) {
      foreach ($marcas as $marca) {
        if ($marca->fecha >= $startOfDay && $marca->fecha <= $endOfDay) {
          $marcasDeFecha[$marca->id_marca] = $marca;
        }
      }
    }


    $funcionariosMarca = array();
    if (!empty($marcasDeFecha)) {
      foreach ($marcasDeFecha as $marca) {
        if (!array_key_exists($marca->id_funcionario, $funcionariosMarca)) {
          $funcionariosMarca[$marca->id_funcionario] = 1;
        } else {
          $funcionariosMarca[$marca->id_funcionario]++;
        }
      }
    }

    return $funcionariosMarca;
  }

  function obtenerDatos()
  {
    global $db;
    global $inicio;
    $this->cantidadFuncionarios = $this->cantidadFuncionarios();

    $this->datosPorFecha = array();
    $this->presentes = array();
    $this->seRetiraron = array();
    $this->inasistencias = array();
    $this->marcasPorFecha = array();
    $this->llegadasTarde = array();
    $this->fechaHoy = date('Y-m-d', $this->fecha_hasta);

    $todasLasMarcas = $this->getMarcas();

    $fechaActual = $this->fecha_hasta;

    $days = (($this->fecha_hasta - $this->fecha_desde) / (60 * 60 * 24));


    $fecha = date('Y-m-d', $fechaActual);
    $lastKey = date('Y-m-d', strtotime($fecha . " + 1 day"));
    $this->datosPorFecha[$lastKey] = array();
    $this->datosPorFecha[$lastKey]["total"] = 0;
    $this->datosPorFecha[$lastKey]["totalPasado"] = 0;

    for ($i = 0; $i <= $days; $i++) {
      $fecha = date('Y-m-d', $fechaActual);
      $this->marcasPorFecha[$fecha] = $this->getMarcasFecha($todasLasMarcas, $fechaActual);
      if ($i < 7) {
        $this->datosPorFecha[$fecha]["total"] = sizeof($this->marcasPorFecha[$fecha]);


        $this->datosPorFecha[$fecha]["totalAccesos"] = 0;
        $this->datosPorFecha[$fecha]["personasDentro1"] = 0;
        $this->datosPorFecha[$fecha]["personasCompletas1"] = 0;
        $this->datosPorFecha[$fecha]["personasDentro2"] = 0;
        $this->datosPorFecha[$fecha]["personasCompletas2"] = 0;
        foreach ($this->marcasPorFecha[$fecha] as $key => $funcionario) {
          $funcionarioDentro = $funcionario % 2 != 0; //Reporte::estaDentro($key);
          $this->datosPorFecha[$fecha]["totalAccesos"] += $funcionario;
          if ($fecha == $this->fechaHoy) {
            $funcionarioTarde = Reporte::llegadaTarde($key);
            if ($funcionarioTarde) {
              array_push($this->llegadasTarde, $key);
            }
            if ($funcionarioDentro) {
              $this->datosPorFecha[$fecha]["personasDentro1"]++;
              array_push($this->presentes, $key);
            } else {
              $this->datosPorFecha[$fecha]["personasCompletas1"]++;
              array_push($this->seRetiraron, $key);
            }
          }
          $divisionCantidad = intval($funcionario / 2);
          if ($funcionarioDentro) {
            if ($divisionCantidad > 1 && $divisionCantidad <= 2) {
              $this->datosPorFecha[$fecha]["personasDentro2"]++;
            }
          } else {
            if ($divisionCantidad >= 2 && $divisionCantidad < 3) {
              $this->datosPorFecha[$fecha]["personasCompletas2"]++;
            }
          }
        }
      } else {
        $fechaAuxiliar = strtotime(date('Y-m-d', strtotime(date("Y-m-d", $fechaActual) . ' + 7 days')));
        $fechaAux = date('Y-m-d', $fechaAuxiliar);
        $this->datosPorFecha[$fechaAux]["totalPasado"] = sizeof($this->marcasPorFecha[$fecha]);
      }
      $fechaActual = strtotime(date('Y-m-d', strtotime(date("Y-m-d", $fechaActual) . ' - 1 days')));
    }
    $numeroDia = date('N', $this->fecha_hasta);
    $tiempoAhora = time();
    $horaAhora = date("H", $tiempoAhora);
    $minutoAhora = date("i", $tiempoAhora);

    $filtro = "";
    if (!empty($this->codigo)) $filtro .= " AND f.codigo = " . $this->codigo;
    if (!empty($this->funcionario)) $filtro .= " AND f.id_funcionario = " . $this->funcionario;
    if (!empty($this->turno)) $filtro .= " AND t.id_turno = " . $this->turno;
    if (!empty($this->departamento)) {
      $filtro .= " AND (";
      foreach ($this->departamento as $key) {
        $filtro .= " fd.id_departamento = " . $key . " OR";
      }
      $filtro = substr($filtro, 0, -3);
      $filtro .= ")";
    }

    $tiempoAhora = time();
    $funcionariosConTurno = $db->get_results("SELECT DISTINCT f.id_funcionario FROM funcionario AS f LEFT JOIN turno AS t ON f.id_turno = t.id_turno LEFT JOIN horario AS h ON h.id_turno = t.id_turno LEFT JOIN funcionario_departamento as fd ON f.id_funcionario = fd.id_funcionario WHERE f.id_turno IS NOT NULL AND t.activo = 1 AND (h.fecha_fin IS NULL OR h.fecha_fin > $tiempoAhora) AND h.activo = 1  AND h.dias LIKE '%" . $numeroDia . "%' AND ($horaAhora>entrada_hasta_horas OR ($horaAhora = entrada_hasta_horas AND $minutoAhora>entrada_hasta_minutos)) " . $filtro);
    if (!empty($funcionariosConTurno)) {
      foreach ($funcionariosConTurno as $value) {
        if (!in_array($value->id_funcionario, $this->presentes) && !in_array($value->id_funcionario, $this->seRetiraron)) {
          array_push($this->inasistencias, $value->id_funcionario);
        }
      }
    }

    $this->datosFuncionarios = array();
    if (!empty($this->presentes)) {
      foreach ($this->presentes as $value) {
        $this->datosFuncionarios[$value] = $this->getFuncionario($value);
      }
    }
  }

  function cantidadFuncionarios()
  {
    global $db;

    $filtro = "WHERE activo = 1";
    if (!empty($this->codigo)) $filtro .= " AND f.codigo = " . $this->codigo;
    if (!empty($this->funcionario)) $filtro .= " AND f.id_funcionario = " . $this->funcionario;
    if (!empty($this->turno)) $filtro .= " AND f.id_turno = " . $this->turno;
    if (!empty($this->departamento)) {
      $filtro .= " AND (";
      foreach ($this->departamento as $key) {
        $filtro .= " fd.id_departamento = " . $key . " OR";
      }
      $filtro = substr($filtro, 0, -3);
      $filtro .= ")";
    }
    $cuenta = $db->get_row("SELECT COUNT(f.id_funcionario) as total FROM funcionario as f LEFT JOIN funcionario_departamento as fd ON f.id_funcionario = fd.id_funcionario " . $filtro);
    return $cuenta->total;
  }
}
