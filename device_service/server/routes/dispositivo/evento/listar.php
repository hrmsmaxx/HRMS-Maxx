<?php
session_start();
include_once "../../../Utilidades.php";
include_once "../../../controllers/BuscarEventosDispositivo.php";
header("Content-Type: application/json");

echo $Utilidades->imprimirJson($BuscarEventosDispositivo->listar());
