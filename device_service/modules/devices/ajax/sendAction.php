<?php
require_once ROOT_URL . "/server/models/ComunicacionReloj.php";
if (isset($_GET["iddata"]) && isset($_GET["execute"])) {
  $iddata = $db->escape($_GET['iddata']);
  $execute = $db->escape($_GET['execute']);
  $ComunicacionReloj->sendAction($iddata, $execute);
}
