<?php
require_once ROOT_URL . "/server/models/Filtro.php";
$get_funcionario = $Filtro->obtenerParametro('funcionario', array('largo' => 11, 'strict' => false));
?>
<div class="form-group">
  <div class="col-xs-3 col-sm-2 col-lg-4">
    <label for="email1" class="control-label">Funcionario</label>
  </div>
  <div class="col-xs-9 col-sm-10 col-lg-6">
    <select class="multiselect" name="funcionario" id="FiltroFuncionario">
      <option value="">Escribe para buscar</option>
      <?php
      if (!empty($get_funcionario)) {
        $info = $db->get_row("SELECT id_funcionario AS value, CONCAT(nombre, ' ',  apellido, ' - ', codigo) AS label FROM funcionario WHERE id_funcionario = " . $get_funcionario);
        echo '<option value="' . $info->value . '" selected>' . $info->label . '</option>';
      }
      ?>
    </select>
  </div>
</div>

<script>
  window.onload = function() {
    inicalizarFiltroSocio($("#FiltroFuncionario"));
  }
</script>