<?php
$iddata = null;
$fecha = null;
if (isset($_GET['iddata'])) {
  $iddata = $db->escape($_GET['iddata']);
}
if (isset($_GET['fecha'])) {
  $fecha = $db->escape($_GET['fecha']);
}
if ($inicio->can_do('agregar')) :
?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Agregar <?php echo mb_strtolower($seccion->nombreSingular, "UTF-8"); ?> parcial</h4>
      </div>
      <form id="formAgregar" class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <input type="hidden" name="id_marca_origen" class="inputForm" value="1">
        <div class="modal-body">
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Funcionario <span style="color:red;">(*)</span></label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select class="inputForm multiselect" name="funcionario" id="FiltroFuncionarioAgregarMarcaParcial">
                <option value="">Escribe para buscar</option>
                <?php
                if (!empty($iddata)) {
                  $info = $db->get_row("SELECT id_funcionario AS value, CONCAT(nombre, ' ',  apellido, ' - ', codigo) AS label FROM funcionario WHERE id_funcionario = " . $iddata);
                  echo '<option value="' . $info->value . '" selected>' . $info->label . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Fecha <span style="color:red;">(*)</span></label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <input type="text" name="fecha" autocomplete="off" class="inputForm form-control fecha_hora" value="<?php if (!empty($fecha)) {
                                                                                                                    echo $fecha . " 00:00";
                                                                                                                  } ?>">
            </div>
          </div>
          <div class="form-group" style="padding: 0;">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Incidencia</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select name="incidencia" class="inputForm multiselect">
                <option value="">Seleccionar</option>
                <?php
                $tipos = $db->get_results("SELECT * FROM incidencia");
                if (!empty($tipos)) {
                  foreach ($tipos as $tipo) :
                    echo '<option value="' . $tipo->id_incidencia . '">' . $tipo->codigo . ' - ' . $tipo->nombre . '</option>';
                  endforeach;
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group" style="padding: 0;">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Dispositivo</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select name="dispositivo_reloj" class="inputForm multiselect">
                <option value="">Seleccionar</option>
                <?php
                $lectores = $db->get_results("SELECT l.*, u.nombre as ubicacion_nombre FROM lector as l LEFT JOIN ubicacion as u ON l.id_ubicacion = u.id_ubicacion WHERE l.activo = 1");

                if (!empty($lectores)) {
                  foreach ($lectores as $each) {
                    if (!empty($lector) && $lector == $each->id_lector) {
                      echo '<option value="' . $each->id_lector . '" selected>' . $each->ip . ':' . $each->puerto . ' - ' . $each->ubicacion_nombre . '</option>';
                    } else {
                      echo '<option value="' . $each->id_lector . '">' . $each->ip . ' ' . $each->puerto . ' - ' . $each->ubicacion_nombre . '</option>';
                    }
                  }
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="agregarParcial"><i class="glyphicon glyphicon-ok" style="color:white"></i> Agregar</button>
        </div>
      </form>
    </div>
  </div>
<?php else : ?><div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3>Error</h3>
      </div>
      <div class="modal-body">
        <p style="font-size: 18px; margin: 15px 0 25px 0;">No cuentas con los suficientes permisos para realizar esta acción</p>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
      </div>
    </div>
  </div>
<?php endif; ?>

<script>
  $('#hora_de_cierre').datetimepicker({
    format: 'hh:ii',
    language: 'es',
    autoclose: 1,
    startView: 1,
    forceParse: 0,
    showMeridian: 1
  });

  $('.fecha_dia').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: "dd/mm/yyyy"
  });
</script>