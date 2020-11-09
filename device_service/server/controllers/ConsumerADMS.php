<?php
class ConsumerADMS
{
  static public function request($json)
  {
    $dispositivo = ConsumerADMS::getDevice($json["serial_number"]);
    if (!empty($dispositivo)) {
      switch ($json["type"]) {
        case "addmarca":
          ConsumerADMS::addMarca($dispositivo, $json);
          break;
        case "updateinfo":
          ConsumerADMS::updateInfo($dispositivo, $json);
          break;
        case "updatestate":
          ConsumerADMS::updateState($dispositivo, $json);
          break;
        case "getinfo":
          echo ConsumerADMS::getInfo($dispositivo, $json);
          break;
      }
    }
  }

  static public function getDevice($serial_number)
  {
    global $db;
    return $db->get_row("SELECT * FROM lector WHERE serial_number = '$serial_number'");
  }

  static public function addMarca($dispositivo, $json)
  {
    require_once ROOT_URL . "/server/models/Marca.php";
    $codigo = $json['codigo'];
    $dateTime = explode(" ", $json['fecha']);
    $date = explode("-", $dateTime[0]);
    $fecha = $date[2] . "/" . $date[1] . "/" . $date[0] . " " . $dateTime[1];
    $incidencia = $json['incidencia'];
    if (!empty($codigo) && !empty($fecha)) {
      Marca::consumir($codigo, "", "", 1, $fecha, $incidencia, 4, $dispositivo->id_lector);
    }
  }

  static public function updateState($dispositivo, $json)
  {
    require_once ROOT_URL . "/server/models/Dispositivo.php";
    $state = $json['state'];
    $last_activity = $json['last_activity'];
    Dispositivo::actualizarEstado($dispositivo->id_lector, $state, $last_activity);
  }

  static private function setExist(&$array, $json, $key, $arrayKey = null)
  {
    if (isset($json[$key])) {
      if (empty($arrayKey)) {
        $array[$key] = $json[$key];
      } else {
        $array[$arrayKey] = $json[$key];
      }
    }
  }

  static public function updateInfo($dispositivo, $json)
  {
    require_once ROOT_URL . "/server/models/Dispositivo.php";
    $info = array();
    ConsumerADMS::setExist($info, $json, "device_name", "name");
    ConsumerADMS::setExist($info, $json, "alias_name", "alias");
    ConsumerADMS::setExist($info, $json, "dept_id", "dept");
    ConsumerADMS::setExist($info, $json, "state");
    ConsumerADMS::setExist($info, $json, "last_activity");
    ConsumerADMS::setExist($info, $json, "trans_times");
    ConsumerADMS::setExist($info, $json, "trans_interval");
    ConsumerADMS::setExist($info, $json, "log_stamp");
    ConsumerADMS::setExist($info, $json, "op_log_stamp");
    ConsumerADMS::setExist($info, $json, "photo_stamp");
    ConsumerADMS::setExist($info, $json, "fw_version");
    ConsumerADMS::setExist($info, $json, "user_count");
    ConsumerADMS::setExist($info, $json, "fp_count");
    ConsumerADMS::setExist($info, $json, "trans_count");
    ConsumerADMS::setExist($info, $json, "fp_alg_ver");
    ConsumerADMS::setExist($info, $json, "push_version");
    ConsumerADMS::setExist($info, $json, "device_type");
    ConsumerADMS::setExist($info, $json, "ipaddress");
    ConsumerADMS::setExist($info, $json, "dev_language");
    ConsumerADMS::setExist($info, $json, "push_comm_key");
    ConsumerADMS::setExist($info, $json, "face_count");
    ConsumerADMS::setExist($info, $json, "face_alg_ver");
    Dispositivo::actualizarInformacion($dispositivo->id_lector, $info);
  }

  static public function getInfo($dispositivo, $json)
  {
    global $mainDB;
    require_once ROOT_URL . "/server/models/Dispositivo.php";
    $data = Dispositivo::obtenerInformacion($dispositivo->id_lector);
    $data->device_id = $mainDB->get_var("SELECT id FROM _dispositivos WHERE serial_number = '$dispositivo->serial_number'");
    $data = json_decode(json_encode($data, true), true);
    if (!empty($data)) {
      foreach ($data as $key => $value) {
        if (empty($data[$key])) {
          if ($data[$key] !== 0 && $data[$key] !== "0") {
            $data[$key] = "";
          }
        }
      }
    }
    return json_encode($data, true);
  }
}
