<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_marcas_por_dia = $Filtro->obtenerParametro('marcas_dia', array('largo' => 10, 'strict' => false));
?>

<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="Sub-Total" class="control-label">Marcas por día (24 horas)</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6 checkbox checkbox-styled">
    <label>
      <input type="checkbox" id="marcas_dia" name="marcas_dia" <?php if ($get_marcas_por_dia) {
                                                                  echo "checked";
                                                                }; ?> />
    </label>
  </div>
</div>