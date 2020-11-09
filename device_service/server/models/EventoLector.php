<?php

class EventoLector
{
  public function __construct()
  {
  }
  private $table = "registro_lector_evento";

  public function listar($cantidad)
  {
    global $db;
    global $inicio;
    return $db->get_results("SELECT rle.*, CONCAT_WS( ' - ', rle.id_lector, CONCAT(l.ip, ':', l.puerto), u.nombre) as dispositivo, le.nombre as evento, CONCAT(us.id_usuario, ' - ',us.nombre,' ',us.apellido) as usuario FROM registro_lector_evento as rle LEFT JOIN lector_evento as le ON rle.id_lector_evento = le.id_lector_evento LEFT JOIN lector as l ON rle.id_lector = l.id_lector LEFT JOIN ubicacion as u ON l.id_ubicacion = u.id_ubicacion LEFT JOIN usuario as us ON us.id_usuario = rle.id_usuario WHERE 1 ORDER BY fecha DESC, terminado DESC LIMIT 0," . $cantidad);
  }
}

$EventoLector = new EventoLector();
