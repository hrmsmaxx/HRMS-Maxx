<?php
$list = $seccion->listar();

$documento = array();

$tipoCodigo = "Todos";
$tipoFuncionario = "Todos";
$tipoTurno = "Todos";
$tipoIncidencia = "Todas";
$tipoDepartamento = "Todos";
$tipoFechaDesde = "Todas";
$tipoFechaHasta = "Todas";
$tipoDispositivo = "Todos";
$tipoDia = "Todos";

if (!empty($seccion->codigo)) {
  $tipoCodigo = $seccion->codigo;
}

if (!empty($seccion->funcionario)) {
  $funcionario = $db->get_row("SELECT * FROM funcionario WHERE id_funcionario = " . $seccion->funcionario);
  $tipoFuncionario = $funcionario->nombre . ' ' . $funcionario->apellido;
}

if (!empty($seccion->turno)) {
  $turno = $db->get_row("SELECT * FROM turno WHERE id_turno = " . $seccion->turno);
  if (!empty($turno)) {
    $tipoTurno = $turno->nombre;
  }
}

if (!empty($seccion->incidencia)) {
  $incidencia = $db->get_row("SELECT * FROM incidencia WHERE id_incidencia = " . $seccion->incidencia);
  if (!empty($incidencia)) {
    $tipoIncidencia = $incidencia->nombre;
  }
}

if (!empty($seccion->departamento)) {
  $departamento = $db->get_row("SELECT * FROM departamento WHERE id_departamento = " . $seccion->departamento);
  if (!empty($departamento)) {
    $tipoDepartamento = $departamento->nombre;
  }
}

if (!empty($seccion->fecha_desde)) {
  $tipoFechaDesde = date("d/m/Y H:i:s", $seccion->fecha_desde);
}

if (!empty($seccion->fecha_hasta)) {
  $tipoFechaHasta = date("d/m/Y H:i:s", $seccion->fecha_hasta);
}

if (!empty($seccion->dispositivo)) {
  $dispositivo = $db->get_row("SELECT CONCAT(l.ip,':',l.puerto,' - ',COALESCE(u.nombre,'')) as nombre FROM lector as l LEFT JOIN ubicacion as u ON l.id_ubicacion = u.id_ubicacion WHERE id_departamento = " . $seccion->dispositivo);
  if (!empty($dispositivo)) {
    $tipoDispositivo = $dispositivo->nombre;
  }
}

if (!empty($seccion->dia)) {
  $dia = $db->get_row("SELECT * FROM dia WHERE id_dia = " . $seccion->dia);
  if (!empty($dia)) {
    $tipoDia = $dia->nombre;
  }
}


$logo = $db->get_row("SELECT valor FROM opcion WHERE tipo = 'logo'");


$tiempoAhora = time();
$fechaAhora = date("d/m/Y", $tiempoAhora);
$horaAhora = date("H:i:s", $tiempoAhora);


array_push($documento, array("Marcas", "Fecha impresion", $fechaAhora, "Hora impresion", $horaAhora));
array_push($documento, array("Código", $tipoCodigo));
array_push($documento, array("Funcionario", $tipoFuncionario));
array_push($documento, array("Desde fecha", $tipoFechaDesde));
array_push($documento, array("Hasta fecha", $tipoFechaHasta));
array_push($documento, array("Departamento", $tipoDepartamento));
array_push($documento, array("Incidencia", $tipoIncidencia));
array_push($documento, array("Dispositivo", $tipoDispositivo));
array_push($documento, array("Turno", $tipoTurno));
array_push($documento, array("Dia", $tipoDia));


if (!empty($list)) {
  array_push($documento, array("Código", "Funcionario", "Fecha", "Hora", "Incidencia", "Turno", "Día", "Dispositivo", "Origen"));
  $i = 0;
  foreach ($list as $row) {
    $datosFuncionario = array();
    array_push($datosFuncionario, $row->funcionario_codigo);

    array_push($datosFuncionario, $row->funcionario_nombre . ' ' . $row->funcionario_apellido);

    array_push($datosFuncionario, date("d/m/Y", $row->fecha));

    array_push($datosFuncionario, date("H:i:s", $row->fecha));

    if (!empty($row->incidencia_nombre)) {
      array_push($datosFuncionario, $row->incidencia_nombre);
    } else {
      array_push($datosFuncionario, "Sin incidencia");
    }

    if (!empty($row->turno_nombre)) {
      array_push($datosFuncionario, $row->turno_nombre);
    } else {
      array_push($datosFuncionario, "Sin turno");
    }

    if (!empty($row->tipo_dia_nombre)) {
      array_push($datosFuncionario, $row->tipo_dia_nombre);
    } else {
      array_push($datosFuncionario, "Sin día");
    }

    if (!empty($row->dispositivo)) {
      array_push($datosFuncionario, $row->dispositivo);
    } else {
      array_push($datosFuncionario, "Sin dispositivo");
    }

    if (!empty($row->origen)) {
      array_push($datosFuncionario, $row->origen);
    } else {
      array_push($datosFuncionario, "Sin datos");
    }

    $i++;
    array_push($documento, $datosFuncionario);
  }
}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="Marcas - ' . $fechaAhora . ' ' . $horaAhora . 'csv;');
$f = fopen('php://output', 'w');

foreach ($documento as $line) {
  fputcsv($f, $line, ";");
}
