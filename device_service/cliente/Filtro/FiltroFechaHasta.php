<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_hasta_fecha = $Filtro->obtenerParametro('fecha_hasta', array('largo' => 20, 'strict' => false));
?>

<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="Sub-Total" class="control-label">Hasta fecha</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <input type="text" id="fecha_hasta" name="fecha_hasta" class="form-control fecha_hora" value="<?php if (!empty($get_hasta_fecha)) {
                                                                                                    echo $get_hasta_fecha;
                                                                                                  } ?>" autocomplete="off">
  </div>
</div>