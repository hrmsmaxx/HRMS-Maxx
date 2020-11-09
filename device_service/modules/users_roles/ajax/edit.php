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
          <?php $inicio->agregarCampoForm('Rol', $data->name); ?>
          <div class="form-group" style="padding: 0;">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Menú</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select name="menu" id="menuEdit">
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
          <div id="listadoModulosEdit">
            <?php $modulos = $db->get_results("SELECT id, name, permissions FROM _menu_item ORDER BY name ASC");
            $permisos = json_decode($data->permissions, true);
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
                          <input type="checkbox" class="checkbox" data-o="<?php echo $e->o; ?>" data-modulo="<?php echo $modulo->id; ?>" value="1" <?php if (isset($permisos[$modulo->id][$e->o]) && $permisos[$modulo->id][$e->o]) {
                                                                                                                                                      echo 'checked="checked"';
                                                                                                                                                    } ?> /> <?php echo $e->n; ?>
                        </label>
                      </div>
                  <?php }
                  } ?>
                </div>
              </div>
            <?php } ?>
            <input type="hidden" name="opciones" id="opcionesEdit">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="editar" onclick="cargarOpcionesEditar()"><i class="glyphicon glyphicon-floppy-saved" style="color:white"></i> Guardar cambios</button>
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