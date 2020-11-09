<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_hora_desde = $Filtro->obtenerParametro('hora_desde', array('largo' => 20, 'strict' => false));
?>

<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="Sub-Total" class="control-label">Desde hora</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <input type="text" name="hora_desde" class="form-control hora" value="<?php if (!empty($get_hora_desde)) {
                                                                            echo $get_hora_desde;
                                                                          } ?>" autocomplete="off">
  </div>
</div>