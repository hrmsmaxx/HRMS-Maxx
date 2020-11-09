<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_desde_fecha = $Filtro->obtenerParametro('fecha_desde', array('largo' => 20, 'strict' => false));
?>

<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="Sub-Total" class="control-label">Desde fecha</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <input type="text" id="fecha_desde" name="fecha_desde" class="form-control fecha_hora" value="<?php if (!empty($get_desde_fecha)) {
                                                                                                    echo $get_desde_fecha;
                                                                                                  } ?>" autocomplete="off">
  </div>
</div>