<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_mes = $Filtro->obtenerParametro('mes', array('largo' => 2, 'strict' => false));
?>

<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="mes" class="control-label">Mes</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <input type="text" name="mes" class="form-control mes" value="<?php if (!empty($get_mes)) {
                                                                    echo $get_mes;
                                                                  } ?>" autocomplete="off">
  </div>
</div>