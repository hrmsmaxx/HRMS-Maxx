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

$titulo = 'Marcas - ' . $fechaAhora . ' ' . $horaAhora;
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Biocloud")
  ->setLastModifiedBy("Biocloud")
  ->setTitle($titulo);
$objPHPExcel->setActiveSheetIndex(0)
  ->setCellValue('A1', "Marcas")
  ->setCellValue('A2', 'Fecha impresion')
  ->setCellValue('B2', $fechaAhora)
  ->setCellValue('A3', 'Hora impresion')
  ->setCellValue('B3', $horaAhora)
  ->setCellValue('A4', "Código")
  ->setCellValue('B4', $tipoCodigo)
  ->setCellValue('A5', "Funcionario")
  ->setCellValue('B5', $tipoFuncionario)
  ->setCellValue('A6', "Desde fecha")
  ->setCellValue('B6', $tipoFechaDesde)
  ->setCellValue('A7', "Hasta fecha")
  ->setCellValue('B7', $tipoFechaHasta)
  ->setCellValue('A8', "Departamento")
  ->setCellValue('B8', $tipoDepartamento)
  ->setCellValue('A9', "Incidencia")
  ->setCellValue('B9', $tipoIncidencia)
  ->setCellValue('A10', "Dispositivo")
  ->setCellValue('B10', $tipoDispositivo)
  ->setCellValue('A11', "Turno")
  ->setCellValue('B11', $tipoTurno)
  ->setCellValue('A12', "Dia")
  ->setCellValue('B12', $tipoDia);


if (!empty($list)) {
  $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A14', "Código")
    ->setCellValue('B14', "Funcionario")
    ->setCellValue('C14', "Fecha")
    ->setCellValue('D14', "Hora")
    ->setCellValue('E14', "Incidencia")
    ->setCellValue('F14', "Turno")
    ->setCellValue('G14', "Día")
    ->setCellValue('H14', "Dispositivo")
    ->setCellValue('I14', "Manual");

  $i = 15;
  foreach ($list as $row) {
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, $row->funcionario_codigo);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $row->funcionario_nombre . ' ' . $row->funcionario_apellido);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, date("d/m/Y", $row->fecha));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, date("H:i:s", $row->fecha));

    if (!empty($row->incidencia_nombre)) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $row->incidencia_nombre);
    } else {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, "Sin incidencia");
    }

    if (!empty($row->turno_nombre)) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $row->turno_nombre);
    } else {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, "Sin turno");
    }

    if (!empty($row->tipo_dia_nombre)) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, $row->tipo_dia_nombre);
    } else {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, "Sin día");
    }

    if (!empty($row->dispositivo)) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i, $row->dispositivo);
    } else {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i, "Sin dispositivo");
    }
    if (!empty($row->origen)) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, $row->origen);
    } else {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, "Sin datos");
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
