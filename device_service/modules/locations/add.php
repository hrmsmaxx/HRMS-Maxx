<div class="modal fade" id="Agregar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Agregar ubicación</h4>
      </div>
      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <div class="modal-body">
          <?php $inicio->agregarCampoForm('Nombre'); ?>
          <div class="form-group" style="padding: 0;">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Pertenece a la ubicación</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select name="padre" class="multiselect">
                <option value="">Seleccionar</option>
                <?php
                $tipos = $db->get_results("SELECT * FROM _location WHERE status = 1 ");
                if (!empty($tipos)) {
                  foreach ($tipos as $tipo) :
                    echo '<option value="' . $tipo->id . '">' . $tipo->name . '</option>';
                  endforeach;
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="agregar"><i class="glyphicon glyphicon-ok" style="color:white"></i> Agregar</button>
        </div>
      </form>
    </div>
  </div>
</div>