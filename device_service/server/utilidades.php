<?php
include_once('config.php');

class Utilidades
{
  public function imprimirJson($response)
  {
    return json_encode($response);
  }

  public function getPost($name, $type, $default = null)
  {
    global $db;
    global $inicio;
    if (isset($_POST[$name]) && (!empty($_POST[$name]) || $_POST[$name] === "0")) {
      if ($type == "json") {
        $value = json_decode($_POST[$name]);
      } else if ($type == "jsonA") {
        $value = json_decode($_POST[$name], true);
      } else if ($type == "array") {
        $l = $_POST[$name];
        if (!empty($l) && is_array($l)) {
          $value = array();
          foreach ($l as $e) {
            if (is_numeric($e)) array_push($value, $db->escape(strip_tags($e)));
          }
        }
      } else if ($type != "noescape") {
        $value = $db->escape(strip_tags($_POST[$name]));
        switch ($type) {
          case "int":
            if (is_numeric($value)) {
              $value = intval($value);
            } else {
              $value = $default;
            }
            break;
          case "date":
            $value = $inicio->parse_fecha($value);
            break;
          case "float":
          case "double":
            if (is_numeric($value)) {
              $value = floatval($value);
            } else {
              $value = $default;
            }
            break;
        }
      }
      return $value;
    }
    return $default;
  }

  public function getFile($name)
  {
    if (isset($_FILES[$name]) && $_FILES[$name]['size'] > 0 && !empty($_FILES[$name])) {
      return $_FILES[$name];
    }
    return null;
  }

  public function addError(&$error, $msg = "", $type = "warning")
  {
    array_push($error, array('msg' => $msg, 'msg_style' => $type));
  }

  public function countErrors(&$error)
  {
    return sizeof($error);
  }
}

$Utilidades = new Utilidades();
