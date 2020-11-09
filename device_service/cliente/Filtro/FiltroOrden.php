<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_orden = $Filtro->obtenerParametro('orden', array('largo' => 4, 'strict' => false));
?>

<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4"><label for="moneda" class="control-label">Orden</label></div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <div class="radio radio-styled">
      <label>
        <input type="radio" name="orden" value="DESC" <?php if ($get_orden == "DESC") {
                                                        echo 'checked="checked"';
                                                      } ?> />
        <span>Mayor a menor</span>
      </label>
    </div>
    <div class="radio radio-styled">
      <label>
        <input type="radio" name="orden" value="ASC" <?php if ($get_orden != "DESC") {
                                                        echo 'checked="checked"';
                                                      } ?> />
        <span>Menor a mayor</span>
      </label>
    </div>
  </div>
</div>