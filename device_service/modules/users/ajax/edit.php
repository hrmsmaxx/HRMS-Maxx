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

      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="iddata" value="<?php echo $iddata; ?>">
          <?php
          $inicio->agregarCampoForm('Nombre', $data->first_name);
          $inicio->agregarCampoForm('Apellido', $data->last_name);
          $inicio->agregarCampoForm('Usuario', $data->username);
          $inicio->agregarCampoForm('Contraseña', '', 'Dejar vacía para no cambiar');
          ?>

          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="rol" class="control-label">Rol</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select name="rol" class="multiselect">
                <?php
                $roles = $db->get_results("SELECT * FROM _user_role WHERE 1 ORDER BY id ASC");
                foreach ($roles as $c) {
                  if ($c->id == $data->user_role_id) {
                    echo '<option value="' . $c->id . '" selected>' . $c->name . '</option>';
                  } else {
                    echo '<option value="' . $c->id . '">' . $c->name . '</option>';
                  }
                }
                ?>
              </select>
            </div>
          </div>

          <hr />
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="editactivo" class="control-label">Activo</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select name="activo" class="multiselect" id="editactivo">
                <option value="ac_1" <?php if ($data->status) echo 'selected'; ?>>Si</option>
                <option value="ac_0" <?php if (!$data->status) echo 'selected'; ?>>Bloqueado</option>
              </select>
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
<script>
  $(document).ready(function() {
    $(".multiselect").multiselect({
      maxHeight: 350
    });
  });
</script>