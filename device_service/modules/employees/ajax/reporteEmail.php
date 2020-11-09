<?php

$iddata = $db->escape($_GET['iddata']);
if ($inicio->can_do('agregar')) :
  $data = $seccion->cargar($iddata);
  $datosreporte = $db->get_row("SELECT * FROM funcionario_reporte WHERE id_funcionario = '$iddata'");
  $reportes = $db->get_results("SELECT id_reporte,nombre FROM reporte WHERE activo = 1");

  $dias = null;
  $id_reporte = 0;
  $activo = 1;
  $activoFalta = $data->enviar_alerta_falta;
  if (!empty($datosreporte)) {
    $dias = $datosreporte->dias;
    if (!empty($dias)) {
      $dias = explode(",", $dias);
    }
    $id_reporte = $datosreporte->id_reporte;
    $activo = $datosreporte->activo;
  }
?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="simpleModalLabel">Enviar email</h4>
      </div>

      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <input type="hidden" name="iddata" value="<?php echo $iddata; ?>">
        <div class="modal-body">
          <div class="col-sm-12">
            <center>
              <h2 style="margin:0;margin-bottom:20px;font-size:22px;">Enviar alerta de falta por email</h2>
            </center>
          </div>
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Estado</label></div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <div class="radio radio-styled">
                <label>
                  <input type="radio" name="activoFalta" value="1" <?php if ($activoFalta == 1) echo 'checked="checked"'; ?>>
                  <span>Activo</span>
                </label>
              </div>
              <div class="radio radio-styled">
                <label>
                  <input type="radio" name="activoFalta" value="0" <?php if ($activoFalta == 0) echo 'checked="checked"'; ?>>
                  <span>Inactivo - Deshabilitado</span>
                </label>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <center>
              <h2 style="margin:0;margin-bottom:20px;font-size:22px;">Enviar reporte por email</h2>
            </center>
          </div>
          <div class="form-group" <?php if (filter_var($data->mail, FILTER_VALIDATE_EMAIL)) {
                                    echo 'style="display:none;"';
                                  } ?>>
            <div class="col-sm-12">
              <center>
                <h3 style="color:red">Asigne un email al funcionario para activar esta función.</h3>
              </center>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Reporte</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select class="multiselect" name="idReporte">
                <option value="">Seleccionar</option>
                <?php
                if (!empty($reportes)) {
                  foreach ($reportes as $t) {
                    if ($id_reporte == $t->id_reporte) {
                      echo '<option value="' . $t->id_reporte . '" selected>' . $t->nombre . '</option>';
                    } else {
                      echo '<option value="' . $t->id_reporte . '">' . $t->nombre . '</option>';
                    }
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="Nombre" class="control-label">Enviar reporte los siguientes días de cada mes</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select id="dias" name="dias[]" class="multiselect" multiple="multiple">`
                <?php
                for ($i = 1; $i <= 31; $i++) {
                  if (!empty($dias) && in_array($i, $dias)) {
                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                  } else {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                  }
                }
                ?>
              </select>
              <br />
              <i>Si el mes termina antes que el máximo día se enviara al finalizar el mes, por ejemplo en febrero si se selecciona 30 se enviara el 28 o 29 en su defecto</i>
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Estado</label></div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <div class="radio radio-styled">
                <label>
                  <input type="radio" name="activo" value="1" <?php if ($activo == 1) echo 'checked="checked"'; ?>>
                  <span>Activo</span>
                </label>
              </div>
              <div class="radio radio-styled">
                <label>
                  <input type="radio" name="activo" value="0" <?php if ($activo == 0) echo 'checked="checked"'; ?>>
                  <span>Inactivo - Deshabilitado</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="reporte">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
<?php else : ?><div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
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