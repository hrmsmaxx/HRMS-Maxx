<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_hora_hasta = $Filtro->obtenerParametro('hora_hasta', array('largo' => 20, 'strict' => false));
?>

<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="Sub-Total" class="control-label">Hasta hora</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <input type="text" name="hora_hasta" class="form-control hora" value="<?php if (!empty($get_hora_hasta)) {
                                                                            echo $get_hora_hasta;
                                                                          } ?>" autocomplete="off">
  </div>
</div>