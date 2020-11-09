<?php
$iddata = $db->escape($_GET['iddata']);
$data = $seccion->cargar($iddata);
if ($inicio->can_do('agregar')) :
?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="simpleModalLabel">Editar</h4>
      </div>

      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <div class="modal-body">
          <input type="hidden" name="iddata" value="<?php echo $iddata; ?>">
          <?php $inicio->agregarCampoForm('Nombre', $data->name); ?>
          <div class="form-group" style="padding: 0;">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Pertenece a la ubicación</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select name="padre" class="multiselect">
                <option value="">Seleccionar</option>
                <?php
                $tipos = $db->get_results("SELECT * FROM _location WHERE status = 1");
                if (!empty($tipos)) {
                  foreach ($tipos as $tipo) :
                    if ($data->parent_location_id == $tipo->id) {
                      echo '<option value="' . $tipo->id . '" selected>' . $tipo->name . '</option>';
                    } else {
                      echo '<option value="' . $tipo->id . '">' . $tipo->name . '</option>';
                    }
                  endforeach;
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Estado</label></div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <div class="radio radio-styled">
                <label>
                  <input type="radio" id="estado_1" name="estado" value="1" <?php if ($data->status == 1) echo 'checked="checked"'; ?>>
                  <span>Activo</span>
                </label>
              </div>
              <div class="radio radio-styled">
                <label>
                  <input type="radio" id="estado_0" name="estado" value="0" <?php if ($data->status == 0) echo 'checked="checked"'; ?>>
                  <span>Inactivo - Deshabilitado</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="editar"><i class="glyphicon glyphicon-floppy-saved" style="color:white"></i> Guardar cambios</button>
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