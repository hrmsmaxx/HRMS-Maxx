<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_codigo = $Filtro->obtenerParametro('codigo', array('largo' => 10, 'strict' => false));
?>

<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="email1" class="control-label">Código</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <input type="text" name="codigo" id="codigo" class="form-control " value="<?php echo $get_codigo; ?>" placeholder="Codigo" autocomplete="off">
    <div class="form-control-line"></div>
  </div>
</div>