<?php if ($add) : ?>
  <div class="modal fade" id="Agregar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header header-biocloud-orange">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="formModalLabel">Agregar <?php echo mb_strtolower($seccion->nombre, "UTF-8"); ?></h4>
        </div>
        <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
          <div class="modal-body">
            <?php $inicio->agregarCampoForm('Rol'); ?>
            <div class="form-group" style="padding: 0;">
              <div class="col-xs-3 col-sm-3 col-lg-3">
                <label for="email1" class="control-label">Menú</label>
              </div>
              <div class="col-xs-9 col-sm-9 col-lg-6">
                <select name="menu" id="menu">
                  <?php
                  $menus = $db->get_results("SELECT id, name FROM _menu");
                  if (!empty($menus)) {
                    foreach ($menus as $menu) :
                      echo '<option value="' . $menu->id . '">' . $menu->name . '</option>';
                    endforeach;
                  }
                  ?>
                </select>
              </div>
            </div>
            <div id="listadoModulos">
              <?php $modulos = $db->get_results("SELECT id, name, permissions FROM _menu_item ORDER BY name ASC");
              foreach ($modulos as $modulo) {
                $opciones = json_decode($modulo->permissions); ?>
                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="Porcentaje-IVA-venta-servicios" class="control-label"><?php echo $modulo->name; ?></label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <?php if (!empty($opciones)) {
                      foreach ($opciones as $e) { ?>
                        <div class="checkbox checkbox-styled">
                          <label>
                            <input type="checkbox" class="checkbox" data-o="<?php echo $e->o; ?>" data-modulo="<?php echo $modulo->id; ?>" value="1" /> <?php echo $e->n; ?>
                          </label>
                        </div>
                    <?php }
                    } ?>
                  </div>
                </div>
              <?php } ?>
            </div>

            <input type="hidden" name="opciones" id="opciones">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-biocloud-yellow" name="agregar" onclick="cargarOpciones()"><i class="glyphicon glyphicon-ok" style="color:white"></i> Agregar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    function cargarOpciones() {
      var opciones = [];
      $('#listadoModulos .checkbox:checked').each(function() {
        var m = new Object();
        m.o = $(this).data('o');
        m.modulo = $(this).data('modulo');
        opciones.push(m);
      });

      var opcionesJson = JSON.stringify(opciones);
      $('#opciones').val(opcionesJson);

    }

    $(document).ready(function() {
      $('#rango').multiselect({
        maxHeight: 350
      });
      $("#menu").multiselect({
        maxHeight: 350
      });
    });
  </script>
<?php endif; ?>