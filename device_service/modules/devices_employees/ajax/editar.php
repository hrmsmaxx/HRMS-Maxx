<?php
$funcionario = $db->escape($_GET['funcionario']);
$lector = $db->escape($_GET['lector']);
$data = $seccion->cargarFuncionario($lector, $funcionario);
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
          <input type="hidden" name="funcionario" value="<?php echo $funcionario; ?>">
          <input type="hidden" name="lector" value="<?php echo $lector; ?>">
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3"><label for="funcionario" class="control-label">Funcionario</label></div>
            <div class="col-xs-9 col-sm-9 col-lg-9"><?php echo $data->funcionario_codigo . " - " . $data->funcionario_nombre . " " . $data->funcionario_apellido ?></div>
          </div>

          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="tope" class="control-label">Tope</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <input type="text" name="tope" id="tope" class="form-control " value="<?php echo $data->tope; ?>" placeholder="Tope" autocomplete="off">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="tope" class="control-label">Privilegio</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select class="multiselect" name="privilegio">

                <option value="default" <?php if ($data->privilege_type == "default") {
                                          echo "selected";
                                        } ?>>Usuario común</option>
                <option value="moderator" <?php if ($data->privilege_type == "moderator") {
                                            echo "selected";
                                          } ?>>Registrar</option>
                <option value="administrator" <?php if ($data->privilege_type == "administrator") {
                                                echo "selected";
                                              } ?>>Administrador</option>
                <option value="owner" <?php if ($data->privilege_type == "owner") {
                                        echo "selected";
                                      } ?>>Super administrador</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Estado</label></div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <div class="radio radio-styled">
                <label>
                  <input type="radio" id="estado_1" name="estado" value="1" <?php if ($data->activo == 1) echo 'checked="checked"'; ?>>
                  <span>Activo</span>
                </label>
              </div>
              <div class="radio radio-styled">
                <label>
                  <input type="radio" id="estado_0" name="estado" value="0" <?php if ($data->activo == 0) echo 'checked="checked"'; ?>>
                  <span>Inactivo - Deshabilitado</span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-9 col-sm-9 col-lg-9">
            </div>
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <button type="submit" class="btn btn-biocloud-blue" style="float:right;width:165px;" name="borrarFuncionario">Eliminar</button>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="editarFuncionario"><i class="glyphicon glyphicon-floppy-saved" style="color:white"></i> Guardar cambios</button>
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