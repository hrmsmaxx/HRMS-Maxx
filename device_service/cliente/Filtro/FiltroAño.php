<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_año = $Filtro->obtenerParametro('año', array('largo' => 4, 'strict' => false));
?>

<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="Sub-Total" class="control-label">Año</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <input type="text" name="año" class="form-control año" value="<?php if (!empty($get_año)) {
                                                                    echo $get_año;
                                                                  } ?>" autocomplete="off">
  </div>
</div>