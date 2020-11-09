<?php

class Dispositivo
{
  public static $table = "_device";
  public static $identificador = "id";

  public static $selectInfo = null;
  public static function obtenerSelectInfo()
  {
    global $db;
    if (Dispositivo::$selectInfo === null) {
      Dispositivo::$selectInfo = $db->get_results("SELECT d.id as value, CONCAT(d.id,' - ',d.ip,':',d.port,' - ',COALESCE(l.name,'')) as name FROM " . Dispositivo::$table . " as d LEFT JOIN _location as l ON d.location_id = l.id WHERE d.status = 1 ORDER BY d.id", array("d", "l"));
    }
    return Dispositivo::$selectInfo;
  }

  public static function actualizarEstado($id_lector, $estado, $ultima_actividad)
  {
    global $db;
    $informacion_anterior = $db->get_row("SELECT * FROM lector_info WHERE id_lector = '$id_lector'");
    if (!empty($informacion_anterior)) {
      $db->put("UPDATE lector_info SET state='$estado',last_activity='$ultima_actividad' WHERE id_lector = '$id_lector'");
    } else {
      $db->put("INSERT INTO lector_info (id_lector, state, last_activity) VALUES ('$id_lector','$estado','$ultima_actividad')");
    }
  }

  public static function actualizarInformacion($id_lector, $info)
  {
    global $db;
    $pastInfo = $db->get_row("SELECT * FROM lector_info WHERE id_lector = '$id_lector'");
    if (empty($pastInfo)) {
      $query = "INSERT INTO lector_info (id_lector";
      foreach ($info as $key => $value) {
        $query .= "," . $key;
      }
      $query .= ") VALUES ('$id_lector'";
      foreach ($info as $key => $value) {
        $query .= ",'$value'";
      }
      $query .= ")";
      $db->put($query);
    } else {
      $query = "UPDATE lector_info SET ";
      foreach ($info as $key => $value) {
        $query .= $key . "='$value',";
      }
      $query = rtrim($query, ',');
      $query .= " WHERE id_lector = '$id_lector'";
      $db->put($query);
    }
  }

  public static function obtenerInformacion($id_lector)
  {
    global $db;
    $object = $db->get_row("SELECT * FROM lector_info WHERE id_lector = '$id_lector'");
    if (empty($object)) {
      $db->put("INSERT INTO lector_info (id_lector) VALUES('$id_lector')");
      $object = $db->get_row("SELECT * FROM lector_info WHERE id_lector = '$id_lector'");
    }
    return $object;
  }
}
