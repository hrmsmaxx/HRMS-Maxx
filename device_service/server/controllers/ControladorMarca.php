<?php
require_once ROOT_URL . "/server/Utilidades.php";
require_once ROOT_URL . "/server/controllers/ControladorEntidadAbstracto.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadMarca.php";
class ControladorMarca extends ControladorEntidadAbstracto
{
  public function crearInformacion()
  {
    global $db;
    global $Utilidades;

    $errores = array();
    $informacion = array();

    $informacion["id_marca"] = $Utilidades->getPost('iddata', "int");
    $informacion["id_funcionario"] = $Utilidades->getPost('funcionario', "int");
    $informacion["id_incidencia"] = $Utilidades->getPost('incidencia', "int", 0);
    $informacion["id_dia"] = $Utilidades->getPost('id_dia', "int", 0);
    $informacion["fecha"] = $Utilidades->getPost('fecha', "date");
    $informacion["id_marca_origen"] = $Utilidades->getPost('id_marca_origen', "int", 0);
    $informacion["id_lector"] = $Utilidades->getPost('dispositivo_reloj', "int", 0);
    $informacion["id_verificacion"] = $Utilidades->getPost('id_verificacion', "int");
    $informacion["id_funcionario_documento"] = $Utilidades->getPost('funcionario_documento', "int", 0);
    $informacion["observacion"] = $Utilidades->getPost('observacion', "string", "");
    if (empty($informacion["fecha"]) || empty($informacion["id_funcionario"])) $Utilidades->addError($errores, 'Complete todos los campos para continuar.');

    if (sizeof($errores) == 0) {
      $year = date('Y', $informacion["fecha"]);
      $month = date('m', $informacion["fecha"]);
      $day = date('d', $informacion["fecha"]);
      $marcaCerrada = $db->get_results("SELECT * FROM marca_cierre WHERE id_funcionario = '" . $informacion["id_funcionario"] . "' AND dia = '$day' AND mes = '$month' AND año = '$year' AND (supervisada = 1 OR cerrada = 1)");
      if (!empty($marcaCerrada)) {
        $Utilidades->addError($errores, 'Esta marca no se puede modificar, la fecha para el funcionario esta cerrada.');
      } else {
        $marcaPasada = $db->get_row("SELECT * FROM marca WHERE id_funcionario = '" . $informacion["id_funcionario"] . "'  AND fecha = '" . $informacion["fecha"] . "' AND id_marca != '" . $informacion["id_marca"] . "'");
        if (!empty($marcaPasada)) {
          $Utilidades->addError($errores, 'La fecha y hora ingresada en la marca ya existe para otra marca en este funcionario.');
        }
      }
    }
    return array("error" => $errores, "data" => $informacion);
  }
}

$ControladorMarca = new ControladorMarca($EntidadMarca);
