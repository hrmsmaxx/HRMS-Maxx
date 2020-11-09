<?php
$buscar = $db->escape($_GET['nombre']);
$activo = -1;
if (isset($_GET['activo'])) {
  $activo = $db->escape($_GET['activo']);
}
if ($activo == 1) {
  $activo = "AND status = 1";
} else if ($activo == 0) {
  $activo = "AND status = 0";
} else {
  $activo = "";
}
$resultado = $db->get_results("SELECT id AS value, CONCAT(device_code, ' - ',first_name, ' ',  last_name) AS label FROM _employee WHERE (CONCAT(first_name, ' ',  last_name) LIKE '%" . $buscar . "%' OR device_code LIKE '%" . $buscar . "%') " . $activo . " LIMIT 0, 100");
echo json_encode($resultado);
