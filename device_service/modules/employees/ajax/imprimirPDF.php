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

$html .= '<table style="width: 100%;">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<td><img class="logos" src="' . $logo->valor . '" /></td>';
$html .= '<td colspan="2" class="titulo_reporte">Funcionarios</td>';
$html .= '<td><img class="logos" style="width:150px;" src="images/logo_texto.png" /></td>';
$html .= '</tr>';
$html .= '</thead>';

$tiempoAhora = time();
$fechaAhora = date("d/m/Y", $tiempoAhora);
$horaAhora = date("H:i:s", $tiempoAhora);

$html .= '<tbody>';
$html .= '<tr>';
$html .= '<td>Estado</td>';
$html .= '<td>' . $tipoEstado . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Código</td>';
$html .= '<td>' . $tipoCodigo . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Funcionario</td>';
$html .= '<td>' . $tipoFuncionario . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Funcionario responsable</td>';
$html .= '<td>' . $tipoResponsable . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Turno</td>';
$html .= '<td>' . $tipoTurno . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Departamento</td>';
$html .= '<td>' . $tipoDepartamento . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td>Centro</td>';
$html .= '<td>' . $tipoCentro . '</td>';
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
  $html .= '<th>Nombre</th>';
  $html .= '<th>Apellido</th>';
  $html .= '<th>Turno</th>';
  $html .= '<th>Estado</th>';
  $html .= '</tr>';
  $html .= '</thead>';
  $html .= '<tbody>';
  $i = 0;
  foreach ($list as $row) {
    $html .= '<tr>';
    $html .= '<td>' . $row->codigo . '</td>';
    $html .= '<td>' . $row->nombre . '</td>';
    $html .= '<td>' . $row->apellido . '</td>';
    $html .= '<td>';
    if (empty($row->turno_nombre)) {
      $html .= "<i>Sin turno</i>";
    } else {
      $html .= $row->turno_nombre;
    }
    $html .= '</td>';
    $html .= '<td>';
    if ($row->activo == 0) {
      $html .= "Deshabilitado";
    } else {
      $html .= "Habilitado";
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
$dompdf->stream("Funcionarios " . $info_reporte->nombre . " - " . $fechaAhora . " " . $horaAhora . ".pdf", array(
  "Attachment" => true
));
exit;
