<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_dispositivo = $Filtro->obtenerParametro('dispositivo', array('largo' => 11, 'strict' => false));
?>

<div class="form-group" style="padding: 0;">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="email1" class="control-label">Dispositivo</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <select name="dispositivo" class="multiselect">
      <option value="">Todos</option>
      <?php
      $devices = Dispositivo::obtenerSelectInfo();

      if (!empty($devices)) {
        foreach ($devices as $each) {
          if ($get_dispositivo == $each->value) {
            echo '<option value="' . $each->value . '" selected>' . $each->name . '</option>';
          } else {
            echo '<option value="' . $each->value . '">' . $each->name . '</option>';
          }
        }
      }
      ?>
    </select>
  </div>
</div>