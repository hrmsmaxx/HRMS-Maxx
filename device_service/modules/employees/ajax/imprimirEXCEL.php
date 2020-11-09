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

$titulo = 'Funcionarios - ' . $fechaAhora . ' ' . $horaAhora;
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Biocloud")
  ->setLastModifiedBy("Biocloud")
  ->setTitle($titulo);
$objPHPExcel->setActiveSheetIndex(0)
  ->setCellValue('A1', "Funcionarios")
  ->setCellValue('A2', 'Fecha impresion')
  ->setCellValue('B2', $fechaAhora)
  ->setCellValue('A3', 'Hora impresion')
  ->setCellValue('B3', $horaAhora)
  ->setCellValue('A4', "Estado")
  ->setCellValue('B4', $tipoEstado)
  ->setCellValue('A5', "Código")
  ->setCellValue('B5', $tipoCodigo)
  ->setCellValue('A6', "Funcionario")
  ->setCellValue('B6', $tipoFuncionario)
  ->setCellValue('A7', "Funcionario responsable")
  ->setCellValue('B7', $tipoResponsable)
  ->setCellValue('A8', "Turno")
  ->setCellValue('B8', $tipoTurno)
  ->setCellValue('A9', "Departamento")
  ->setCellValue('B9', $tipoDepartamento)
  ->setCellValue('A10', "Centro")
  ->setCellValue('B10', $tipoCentro);


if (!empty($list)) {
  $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A12', "Código")
    ->setCellValue('B12', "Nombre")
    ->setCellValue('C12', "Apellido")
    ->setCellValue('D12', "Turno")
    ->setCellValue('E12', "Estado");

  $i = 13;
  foreach ($list as $row) {
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, $row->codigo);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $row->nombre);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, $row->apellido);
    if (empty($row->turno_nombre)) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, "Sin turno");
    } else {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, $row->turno_nombre);
    }
    if ($row->activo == 0) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, "Deshabilitado");
    } else {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, "Habilitado");
    }
    $i++;
  }
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle("Reporte");
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $titulo . '.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
