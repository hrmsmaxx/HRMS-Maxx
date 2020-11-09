<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_estado = $Filtro->obtenerParametro('estado', array('largo' => 1, 'strict' => false));
?>
<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="email1" class="control-label">Estado</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <select name="estado" class="multiselect" id="estado">
      <option value="0">Todos</option>
      <option value="1" <?php if ($get_estado == 1) {
                          echo "selected";
                        } ?>>Habilitado</option>
      <option value="2" <?php if ($get_estado == 2) {
                          echo "selected";
                        } ?>>Deshabilitado</option>
    </select>
  </div>
</div>