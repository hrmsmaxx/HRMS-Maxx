<?php

$list = $seccion->listar();

ini_set('xdebug.//var_display_max_depth', 50);
ini_set('xdebug.//var_display_max_children', 256);
ini_set('xdebug.//var_display_max_data', 1024);
header('Content-type: text/html; charset=UTF-8');

$html = '<html>';
$html = '<head>
<style>

@page { margin: 60px 50px 70px 50px; }
#header { position: fixed; left: 0px; top: -160px; right: 0px; height: 200px; }
#header .page:after { content: counter(page, upper-roman); }
#footer { position: fixed; left: 0px; bottom: -70px; right: 0px; height: 100px; width: 100%; }

* { font-size: 14px; font-family: \'Roboto\'; }
@font-face {
  font-family: \'ROBOTO\';
  font-style: normal;
  font-weight: 400;
  src: url(' . ROOT_URL_PANEL . 'conf/domPDF/lib/fonts/Roboto-Regular.ttf) format(\'truetype\');
}

td{ padding: 4px; }
.tablaDetalle td{ padding: 5px; border: 1px solid #666; font-size: 13px; }
.tdtitle,.nombreFuncionario,.totales { font-weight:bold; }
.titulo_reporte { font-weight:bold; text-align:center; font-size:21px; }
#content table {border-collapse: collapse;}
#content table,#content th,#content td {border: 1px solid black;}
</style>
</head>';
$html .= '<body>';

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
  $dispositivo = $db->get_row("SELECT CONCAT(l.ip,':',l.puerto,' - ',COALESCE(u.nombre,'')) as nombre FROM lector as l LEFT JOIN ubicacion as u ON l.id_ubicacion = u.id_ubicacion WHERE l.id_lector = " . $seccion->dispositivo);
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

$html .= '<table style="width: 100%;">';
$html .= '<thead>';
$html .= '<tr>';
if (!empty($logo) && !empty($logo->valor)) {
  $html .= '<td><img class="logos" src="' . $logo->valor . '" /></td>';
} else {
  $html .= '<td></td>';
}
$html .= '<td colspan="2" class="titulo_reporte">Marcas</td>';
$html .= '<td><img class="logos" style="width:150px;" src="images/logo_texto.png" /></td>';
$html .= '</tr>';
$html .= '</thead>';

$tiempoAhora = time();
$fechaAhora = date("d/m/Y", $tiempoAhora);
$horaAhora = date("H:i:s", $tiempoAhora);

$html .= '<tbody>';
$html .= '<tr>';
$html .= '<td>Código</td>';
$html .= '<td>' . $tipoCodigo . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Funcionario</td>';
$html .= '<td>' . $tipoFuncionario . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Desde fecha</td>';
$html .= '<td>' . $tipoFechaDesde . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Hasta fecha</td>';
$html .= '<td>' . $tipoFechaHasta . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Departamento</td>';
$html .= '<td>' . $tipoDepartamento . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Incidencia</td>';
$html .= '<td>' . $tipoIncidencia . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Dispositivo</td>';
$html .= '<td>' . $tipoDispositivo . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Turno</td>';
$html .= '<td>' . $tipoTurno . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Dia</td>';
$html .= '<td>' . $tipoDia . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Fecha impresion</td>';
$html .= '<td>' . $fechaAhora . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Hora impresion</td>';
$html .= '<td>' . $horaAhora . '</td>';
$html .= '</tr>';
$html .= '</tbody>';
$html .= '</table>';
$html .= '<div id="content">';

if (!empty($list)) {
  $html .= '<table id="listado_elementos" style="width:100%" class="table">';
  $html .= '<thead>';
  $html .= '<tr>';
  $html .= '<th>Código</th>';
  $html .= '<th>Funcionario</th>';
  $html .= '<th>Fecha</th>';
  $html .= '<th>Hora</th>';
  $html .= '<th>Incidencia</th>';
  $html .= '<th>Turno</th>';
  $html .= '<th>Día</th>';
  $html .= '<th>Dispositivo</th>';
  $html .= '<th>Manual</th>';
  $html .= '</tr>';
  $html .= '</thead>';
  $html .= '<tbody>';
  $i = 0;
  foreach ($list as $row) {
    $html .= '<tr>';
    $html .= '<td>' . $row->funcionario_codigo . '</td>';
    $html .= '<td>' . $row->funcionario_nombre . ' ' . $row->funcionario_apellido . '</td>';
    $html .= '<td>' . date("d/m/Y", $row->fecha) . '</td>';
    $html .= '<td>' . date("H:i:s", $row->fecha) . '</td>';
    $html .= '<td>';
    if (!empty($row->incidencia_nombre)) {
      $html .= $row->incidencia_nombre;
    } else {
      $html .= "<i>Sin incidencia</i>";
    }
    $html .= '</td>';
    $html .= '<td>';
    if (empty($row->turno_nombre)) {
      $html .= "<i>Sin turno</i>";
    } else {
      $html .= $row->turno_nombre;
    }
    $html .= '</td>';
    $html .= '<td>';
    if (empty($row->tipo_dia_nombre)) {
      $html .= "<i>Sin día</i>";
    } else {
      $html .= $row->tipo_dia_nombre;
    }
    $html .= '</td>';
    $html .= '<td>';
    if (empty($row->dispositivo)) {
      $html .= "<i>Sin dispositivo</i>";
    } else {
      $html .= $row->dispositivo;
    }
    $html .= '</td>';
    $html .= '<td>';
    if (!empty($row->origen)) {
      $html .= $row->origen;
    } else {
      $html .= "Sin datos";
    }
    $html .= '</td>';
    $html .= '</tr>';
    $i++;
  }
  $html .= '</tbody>';
  $html .= '</table>';
}

$html .= '</div></body></html>';

//echo $html; exit;


$dompdf = new DOMPDF();

$dompdf->set_paper('A4', 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Marcas " . $info_reporte->nombre . " - " . $fechaAhora . " " . $horaAhora . ".pdf", array(
  "Attachment" => true
));
exit;
