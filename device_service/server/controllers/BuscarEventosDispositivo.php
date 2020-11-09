<?php
require_once ROOT_URL . "/server/models/EventoLector.php";

class BuscarEventosDispositivo
{
  public function listar()
  {
    global $EventoLector;
    return $EventoLector->listar(50);
  }
}

$BuscarEventosDispositivo = new BuscarEventosDispositivo();
