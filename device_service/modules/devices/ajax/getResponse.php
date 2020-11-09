<?php
header('Content-type: application/json; charset=UTF-8');
require_once ROOT_URL . "/server/models/ComunicacionReloj.php";
if (isset($_GET["iddata"])) {
  $iddata = $db->escape($_GET['iddata']);
  echo $ComunicacionReloj->getResponse($iddata);
} else {
  echo "{}";
}
exit;
