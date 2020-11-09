<div class="modal fade" id="Agregar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Agregar <?php echo mb_strtolower($seccion->nombre, "UTF-8"); ?></h4>
      </div>
      <form id="formUsuarios" class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <?php
          $inicio->agregarCampoForm('Nombre');
          $inicio->agregarCampoForm('Apellido');
          $inicio->agregarCampoForm('Usuario');
          $inicio->agregarCampoForm('Contraseña');
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
                  echo '<option value="' . $c->id . '">' . $c->name . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-biocloud-yellow"><i class="glyphicon glyphicon-ok" style="color:white"></i> Agregar</button>
          </div>
          <input type="hidden" name="agregar" value="1">
        </div>
      </form>
    </div>
  </div>
</div>