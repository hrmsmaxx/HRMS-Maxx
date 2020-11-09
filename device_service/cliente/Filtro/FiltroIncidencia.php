<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_incidencia = $Filtro->obtenerParametro('incidencia', array('largo' => 11, 'strict' => false));
?>
<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="email1" class="control-label">Incidencia</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <select id="incidencia" name="incidencia" class="multiselect">
      <option value="">Todas</option>
      <?php
      $incidencias = $db->get_results("SELECT * FROM _workcode WHERE status = 1");
      if (!empty($incidencias)) {
        foreach ($incidencias as $each) {
          if (!empty($get_incidencia) && $get_incidencia == $each->id) {
            echo '<option value="' . $each->id . '" selected>' . $each->device_code . ' ' . $each->name . '</option>';
          } else {
            echo '<option value="' . $each->id . '">' . $each->device_code . ' ' . $each->name . '</option>';
          }
        }
      }
      ?>
    </select>
  </div>
</div>