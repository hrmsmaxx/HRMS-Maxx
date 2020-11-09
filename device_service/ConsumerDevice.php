<?php
set_time_limit(0);
ini_set('mysql.connect_timeout', '0');
ini_set('max_execution_time', '0');
header('Content-type: application/json; charset=UTF-8');
session_start();
ob_start();
$json = file_get_contents('php://input');
$json = json_decode($json, true);
$data = null;
if (empty($json)) {
  exit;
}

if (empty($json['apikey']) || empty($json['type']) || empty($json['dispositivo']) || empty($json['empresa'])) {
  exit;
}
$json['type'] = mb_strtolower($json['type']);

if (!empty($json["content"]) && !is_array($json["content"])) {
  $json["content"] = json_decode($json["content"], true);
}


$_SESSION['empresa'] = $json['empresa'];

include_once "server/preconfig.php";
include_once ROOT_URL . "/server/config.php";
$json['apikey'] = $db->escape($json['apikey']);
$json['dispositivo'] = $db->escape($json['dispositivo']);
$json['empresa'] = $db->escape($json['empresa']);
$data = $json["content"];
$info = explode(":", $json['dispositivo']);

$ip = 0;
$puerto = 0;

if (sizeof($info) > 0) {
  $ip = $info[0];
}
if (sizeof($info) > 1) {
  $puerto = $info[1];
}

$apikeyDB = $db->get_var("SELECT apikey FROM _subdomain");


if (!empty($json['apikey']) && $json['apikey'] === $apikeyDB) {
  require_once ROOT_URL . '/functions.php';
  require_once ROOT_URL . "/server/models/ComunicacionReloj.php";

  $inicio = new Inicio();

  $id_lector = $ComunicacionReloj->getLector($ip, $puerto);
  $inicio->id = 1;

  function addfuncionario()
  {
    global $data;
    global $id_lector;
    require_once ROOT_URL . "/server/models/Funcionario.php";
    require_once ROOT_URL . '/modules/employees/functions.php';
    $seccion = new Seccion();
    if (!empty($data)) {
      foreach ($data as $funcionario) {
        $codigo = $funcionario['codigo'];
        $nombre = trim(urldecode($funcionario['nombre']));
        $password = urldecode($funcionario['password']);
        $tarjeta = null;
        if (isset($funcionario['tarjeta'])) {
          $tarjeta = $funcionario['tarjeta'];
        }
        $activo = $funcionario['activo'];
        $huellas = $funcionario['huellas'];
        $rostro = $funcionario['rostro'];
        $rostroLength = $funcionario['rostroLength'];
        if (strtolower($activo) == "true") {
          $activo = 1;
        } else {
          $activo = 0;
        }
        $seccion->addFuncionarioLector($codigo, $nombre, $password, $activo, $id_lector, $tarjeta);

        if (!empty($huellas)) {
          foreach ($huellas as $h) {
            $seccion->addHuellaLector($codigo, 0, urldecode($h));
          }
        }
        if (!empty($rostro) && !empty($rostroLength)) {
          $seccion->addRostroLector($codigo, $rostro, $rostroLength);
        }
      }
    }
  }

  function addmarca()
  {
    global $data;
    global $id_lector;
    require_once ROOT_URL . "/server/models/Marca.php";
    if (!empty($data)) {
      foreach ($data as $marca) {
        $codigo = $marca['codigo'];
        $nombre = trim(urldecode($marca['nombre']));
        $password = urldecode($marca['password']);
        $activo = $marca['activo'];
        $fecha = $marca['fecha'];
        $incidencia = $marca['incidencia'];
        if (!empty($codigo) && !empty($fecha)) {
          Marca::consumir($codigo, $nombre, $password, $activo, $fecha, $incidencia, 3, $id_lector);
        }
      }
    }
  }

  function addevento()
  {
    global $db;
    global $json;
    global $data;
    global $id_lector;

    $data = $json;
    if (!empty($data)) {
      if (!isset($data["mensaje"]) && isset($data["content"])) {
        $data = $data["content"];
      }
      $tiempoAhora = time();
      $id_evento = 0;
      if (isset($data["evento"])) {
        $id_evento = intval($db->escape($data['evento']));
      } else if (isset($data["id_evento"])) {
        $id_evento = intval($db->escape($data['id_evento']));
      }
      if (!empty($id_evento)) {
        $mensaje = $db->escape($data['mensaje']);

        $manual = false;
        if (isset($data['manual']) && !empty($data['manual'])) {
          $manual = $data['manual'] == "true";
        }

        $terminado = true;
        if (isset($data['terminado']) && !empty($data['terminado'])) {
          $terminado = $data['terminado'] == "true";
        }

        if ($manual) {
          $manual = 1;
        } else {
          $manual = 0;
        }
        if ($terminado) {
          $terminado = 1;
        } else {
          $terminado = 0;
        }

        switch ($id_evento) {
          case 1: //verificaicon
            if ($mensaje == "-1") {
              $mensaje = "Verificación fallida";
            } else {
              $funcionario = $db->get_row("SELECT * FROM _employee WHERE device_code = '$mensaje'");
              if (!empty($funcionario)) {
                $mensaje = "Verificación correcta de " . $funcionario->codigo . " - " . $funcionario->nombre . " " . $funcionario->apellido;
              } else {
                $mensaje = "Verificación correcta de codigo: " . $mensaje;
              }
            }
            break;
          case 2: //huella
            $mensaje = "Se ingreso una huella";
            break;
          case 3: //tarjeta
            $mensaje = "Se ingreso la tarjeta " . $mensaje;
            break;
          case 1000:
            $mensaje = "";
            break;
          case 1001:
            $mensaje = "";
            break;
          case 1002:
            if ($terminado == 0) {
              $mensaje = "Inicio consumo de marcas";
            } else {
              $mensaje = $mensaje . " marcas consumidas";
            }
            break;
          case 1003:
            if (!empty($mensaje)) {
              $estado = explode(",", $data['mensaje']);
              $mensaje = "";
              if (!empty($estado)) {
                foreach ($estado as $value) {
                  $valores = explode(":", $value);
                  if (sizeof($valores) == 2) {
                    $mensaje .= $valores[0] . ": " . $valores[1] . " \n";
                  }
                }
              } else {
                $mensaje = "Estado del dispositivo no se pudo traducir";
              }
            } else {
              $mensaje = "Estado del dispositivo vacio";
            }
            break;
          case 1004:
            if (!empty($mensaje)) {
              $estado = explode(",", $mensaje);
              $mensaje = "";
              if (!empty($estado)) {
                foreach ($estado as $value) {
                  $valores = explode(":", $value);
                  if (sizeof($valores) == 2) {
                    $mensaje .= $valores[0] . ": " . $valores[1] . " \n";
                  }
                }
              } else {
                $mensaje = "Información del dispositivo no se pudo traducir";
              }
            } else {
              $mensaje = "Información del dispositivo vacio";
            }
            break;
          case 1005:
            if ($terminado == 0) {
              $mensaje = "Inicio subida usuarios";
            } else {
              $mensaje = $mensaje . " usuarios subidos";
            }
            break;
          case 1006:
            if ($terminado == 0) {
              $mensaje = "Inicio actualización usuarios";
            } else {
              $mensaje = $mensaje . " usuarios actualizados";
            }
            break;
          case 1007:
            if ($terminado == 0) {
              $mensaje = "Inicio actualización incidencias";
            } else {
              $mensaje = $mensaje . " incidencias actualizadas";
            }
            break;
          case 1008:
            $mensaje = "";
            break;
          case 1009:
            $mensaje = "";
            break;
          case 1010:
            $mensaje = "";
            break;
        }
        echo $mensaje;
        $mensaje = $db->escape($mensaje);
        //$db->query("INSERT INTO _device_event (device_id,id_lector_evento,fecha,mensaje,manual,terminado) VALUES ($id_lector,$id_evento,$tiempoAhora,'$mensaje','$manual','$terminado')");
      }
    }
  }

  function actualizarlector()
  {
    global $db;
    global $json;
    global $id_lector;
    include('modules/devices/functions.php');
    $seccion = new Seccion();
    if (
      isset($json["ultimoConsumo"]) && (!empty($json["ultimoConsumo"]) || $json["ultimoConsumo"] == 0) &&
      isset($json["ultimaActualizacion"]) && (!empty($json["ultimaActualizacion"]) || $json["ultimaActualizacion"] == 0)
    ) {
      $ultimoConsumo = $db->escape($json['ultimoConsumo']);
      $ultimaActualizacion = $db->escape($json['ultimaActualizacion']);

      $ultimoTiempo = 0;
      if (isset($json['ultimoTiempo'])) {
        $ultimoTiempo = $db->escape($json['ultimoTiempo']);
      }

      $seccion->actualizarLector($id_lector, $ultimoConsumo, $ultimaActualizacion, $ultimoTiempo);
    }
  }

  function setresponse()
  {
    global $db;
    global $ComunicacionReloj;
    global $json;
    global $data;
    global $id_lector;
    if (isset($json["executed"])) {
      $executed = mb_strtolower($db->escape($json['executed']));
      $mensaje = "";

      switch ($executed) {
        case "getmarcas":
          if (isset($json["count"])) {
            $count = intval($db->escape($json["count"]));
            $s = "";
            if ($count > 1) {
              $s = "s";
            }
            $mensaje = '{"message":"Se han bajado ' . $count . ' marca' . $s . '"}';
          }
          break;
        case "getstatus":
        case "getstatusfull":
          $querys = array(
            "cantidadAdmin" => "Cantidad de administradores",
            "cantidadFuncionarios" => "Cantidad de funcionarios",
            "cantidadHuellas" => "Cantidad de huellas",
            "cantidadContrasenas" => "Cantidad de contraseñas",
            "cantidadOperados" => "Cantidad de registros operados",
            "cantidadAsistencias" => "Cantidad de registros de asistencia",
            "capacidadHuellas" => "Capacidad de huellas",
            "capacidadFuncionarios" => "Capacidad de funcionarios",
            "capacidadAsistencias" => "Capacidad de asistencias",
            "restanteHuellas" => "Espacio restante para huellas",
            "restanteFuncionarios" => "Espacio restante para funcionarios",
            "restanteAsistencias" => "Espacio restante para asistencias",
            "cantidadCaras" => "Cantidad de caras",
            "capacidadCaras" => "Capacidad de caras"
          );
          $msg = array();
          foreach ($querys as $query => $description) {
            if (isset($json[$query])) {
              $data = $db->escape($json[$query]);
              if (!empty($data) || $data == 0) {
                array_push($msg, $description . ": " . $data);
              }
            }
          }
          $msgTxt = join("<br>", $msg);
          if ($executed == "getstatusfull") {
            $mensaje = '{"message":"' . $msgTxt . '"}';
          } else {
            $mensaje = '{"message":"' . $msgTxt . '","status":"Conexión exitosa"}';
          }
          break;
        case "getinfo":
          $msg = array();
          if (isset($json["serialNumber"])) {
            $serialNumber = $db->escape($json["serialNumber"]);
            if (!empty($serialNumber)) {
              array_push($msg, "Numero de serie: " . $serialNumber);
            }
          }
          if (isset($json["firmwareVersion"])) {
            $firmwareVersion = $db->escape($json["firmwareVersion"]);
            if (!empty($firmwareVersion)) {
              array_push($msg, "Versión del firmware: " . $firmwareVersion);
            }
          }
          $msgTxt = join("<br>", $msg);
          $mensaje = '{"message":"' . $msgTxt . '"}';
          break;
        case "actualizarfuncionarios":
          $mensaje = '{"message":"Actualización de funcionarios terminada."}';
          break;
        case "actualizarincidencias":
          $mensaje = '{"message":"Actualización de incidencias terminada."}';
          break;
        case "limpiardispositivo":
          $mensaje = '{"message":"Limpieza terminada."}';
          break;
        case "subirfuncionarios":
          $mensaje = '{"message":"Datos de funcionarios guardados con éxito."}';
          break;
        case "gettime":
          $mensaje = '{"message":"Actualización de hora terminada."}';
          break;
        default:
          $mensaje = '{"message":"Acción no encontrada"}';
          break;
      }
      if ($mensaje != "") {
        $ComunicacionReloj->setResponse($id_lector, $mensaje);
      }
    }
  }

  switch ($json["type"]) {
    case "actualizarfuncionariostope":
      if (!empty($id_lector)) {
        $ComunicacionReloj->actualizarFuncionariosTope($id_lector);
      }
      break;
    case "addfuncionario":
      if (!empty($id_lector)) {
        addfuncionario();
      }
      break;
    case "addmarca":
      if (!empty($id_lector)) {
        addmarca();
      }
      break;
    case "addevento":
      if (!empty($id_lector)) {
        addevento();
      }
      break;
    case "getfuncionariospaginados":
      if (!empty($id_lector)) {
        echo $ComunicacionReloj->getFuncionariosPaginados($id_lector, $db->escape($json["offset"]), $db->escape($json["limit"]));
      }
      break;
    case "finalizaractualizacion":
      if (!empty($id_lector)) {
        echo $ComunicacionReloj->finalizarActualizacion($id_lector);
      }
      break;
    case "actualizarlector":
      if (!empty($id_lector)) {
        actualizarlector();
      }
      break;
    case "getincidencias":
      echo $ComunicacionReloj->getIncidencias();
      break;
    case "getlectores":
      echo $ComunicacionReloj->getLectores();
      break;
    case "getaction":
      if (!empty($id_lector)) {
        echo $ComunicacionReloj->getAction($id_lector);
      }
      break;
    case "setresponse":
      if (!empty($id_lector)) {
        setresponse();
      }
      break;
    case "forcedownload":
      if (!empty($id_lector)) {
        echo $ComunicacionReloj->forceDownload($id_lector);
      }
      break;
    case "gettime":
      if (!empty($id_lector)) {
        echo $ComunicacionReloj->getTime($id_lector);
      }
      break;
    case "funcionariosactualizados":
      if (!empty($id_lector)) {
        echo $ComunicacionReloj->eliminarFuncionariosDeColaActualizacion($id_lector, $data);
      }
      break;
  }
}
exit;
