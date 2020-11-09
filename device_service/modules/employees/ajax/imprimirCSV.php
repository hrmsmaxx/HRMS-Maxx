<?php
$list = $seccion->listar();

$documento = array();
$tipoEstado = "Todos";
$tipoCodigo = "Todos";
$tipoFuncionario = "Todos";
$tipoTurno = "Todos";
$tipoCentro = "Todos";
$tipoDepartamento = "Todos";
$tipoResponsable = "Todos";

if (!empty($seccion->estado)) {
  if ($seccion->estado == 1) {
    $tipoEstado = "Habilitado";
  } else if ($seccion->estado == 2) {
    $tipoEstado = "Deshabilitado";
  }
}

if (!empty($seccion->codigo)) {
  $tipoCodigo = $seccion->codigo;
}

if (!empty($seccion->funcionario)) {
  $funcionario = $db->get_row("SELECT * FROM funcionario WHERE id_funcionario = " . $seccion->funcionario);
  $tipoFuncionario = $funcionario->nombre . ' ' . $funcionario->apellido;
}

if (!empty($seccion->centro)) {
  $centro = $db->get_row("SELECT * FROM centro WHERE id_centro = " . $seccion->centro);
  if (!empty($centro)) {
    $tipoCentro = $centro->nombre;
  }
}

if (!empty($seccion->departamento)) {
  $departamento = $db->get_row("SELECT * FROM departamento WHERE id_departamento = " . $seccion->departamento);
  if (!empty($departamento)) {
    $tipoDepartamento = $departamento->nombre;
  }
}

if (!empty($seccion->turno)) {
  $turno = $db->get_row("SELECT * FROM turno WHERE id_turno = " . $seccion->turno);
  if (!empty($turno)) {
    $tipoTurno = $turno->nombre;
  }
}


if (!empty($seccion->responsable)) {
  $responsable = $db->get_row("SELECT * FROM funcionario WHERE id_funcionario = " . $seccion->responsable);
  if (!empty($responsable)) {
    $tipoResponsable = $responsable->nombre;
  }
}


$logo = $db->get_row("SELECT valor FROM opcion WHERE tipo = 'logo'");


$tiempoAhora = time();
$fechaAhora = date("d/m/Y", $tiempoAhora);
$horaAhora = date("H:i:s", $tiempoAhora);


array_push($documento, array("Funcionarios", "Fecha impresion", $fechaAhora, "Hora impresion", $horaAhora));
array_push($documento, array("Estado", $tipoEstado));
array_push($documento, array("Código", $tipoCodigo));
array_push($documento, array("Funcionario", $tipoFuncionario));
array_push($documento, array("Funcionario responsable", $tipoResponsable));
array_push($documento, array("Turno", $tipoTurno));
array_push($documento, array("Departamento", $tipoDepartamento));
array_push($documento, array("Centro", $tipoCentro));


if (!empty($list)) {
  array_push($documento, array("Código", "Nombre", "Apellido", "Turno", "Estado"));
  $i = 0;
  foreach ($list as $row) {
    $datosFuncionario = array();
    array_push($datosFuncionario, $row->codigo);
    array_push($datosFuncionario, $row->nombre);
    array_push($datosFuncionario, $row->apellido);
    if (empty($row->turno_nombre)) {
      array_push($datosFuncionario, "Sin turno");
    } else {
      array_push($datosFuncionario, $row->turno_nombre);
    }
    if ($row->activo == 0) {
      array_push($datosFuncionario, "Deshabilitado");
    } else {
      array_push($datosFuncionario, "Habilitado");
    }
    $i++;
    array_push($documento, $datosFuncionario);
  }
}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="Funcionarios - ' . $fechaAhora . ' ' . $horaAhora . 'csv;');
$f = fopen('php://output', 'w');

foreach ($documento as $line) {
  fputcsv($f, $line, ";");
}
