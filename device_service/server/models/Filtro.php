<?php

class Filtro
{
  public function __construct()
  {
  }
  private function generarOpciones($opciones)
  {
    if ($opciones === null) {
      $opciones = array();
    }

    if (!isset($opciones["tipo"])) {
      $opciones["tipo"] = "int";
    }
    if (!isset($opciones["modalidad"])) {
      $opciones["modalidad"] = "GET";
    }
    if (!isset($opciones["espacios"])) {
      $opciones["espacios"] = false;
    }
    if (!isset($opciones["largo"])) {
      $opciones["largo"] = -1;
    }
    if (!isset($opciones["error"])) {
      $opciones["error"] = false;
    }
    if (!isset($opciones["strict"])) {
      $opciones["strict"] = true;
    }
    return $opciones;
  }

  public function obtenerParametro($clave, $opciones = null)
  {
    global $db;
    global $inicio;
    global $seccion;
    $opciones = $this->generarOpciones($opciones);
    $dato = null;

    if ($opciones["modalidad"] === "GET") {
      if (isset($_GET[$clave]) && !empty($_GET[$clave])) {
        $dato = $db->escape(strip_tags($_GET[$clave]));
      } else if (!isset($_GET["nofiltro"]) && isset($_SESSION["filtro"]) && isset($_SESSION["filtro"][$seccion->option]) && isset($_SESSION["filtro"][$seccion->option][$clave])) {
        $dato = $db->escape(strip_tags($_SESSION["filtro"][$seccion->option][$clave]));
      } else {
        return null;
      }
    } else if ($opciones["modalidad"] === "POST") {
      if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
        $dato = $db->escape(strip_tags($_POST[$clave]));
      } else {
        return null;
      }
    }
    if ($opciones["espacios"] === false) {
      $dato = trim($dato);
    }

    switch ($opciones["tipo"]) {
      case "int":
        if (!filter_var($dato, FILTER_VALIDATE_INT)) {
          if ($opciones["error"]) {
            array_push($seccion->message, array('msg' => 'El filtro de ' . $clave . ' debe ser un número entero.', 'msg_style' => 'warning'));
          }
          if ($opciones["strict"]) {
            return null;
          }
        }
        break;
      case "date":
        $dato = $inicio->parse_fecha($dato);
    }

    if ($opciones["largo"] !== -1) {
      if (strlen($dato) > $opciones["largo"]) {
        if ($opciones["error"]) {
          array_push($seccion->message, array('msg' => 'El filtro de ' . $clave . ' tiene un máximo de ' . $opciones["largo"] . ' caracteres.', 'msg_style' => 'warning'));
        }
        if ($opciones["strict"]) {
          return null;
        }
      }
    }
    return $dato;
  }
}

$Filtro = new Filtro();
