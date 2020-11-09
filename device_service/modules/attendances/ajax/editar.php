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
          <input type="hidden" name="iddata" class="inputForm" value="<?php echo $iddata; ?>">
          <input type="hidden" name="id_marca_origen" class="inputForm" value="1">
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Funcionario <span style="color:red;">(*)</span></label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select class="inputForm multiselect" name="funcionario" id="FiltroFuncionarioEditar">
                <option value="">Escribe para buscar</option>
                <?php
                if (!empty($data->id_funcionario)) {
                  $info = $db->get_row("SELECT id_funcionario AS value, CONCAT(nombre, ' ',  apellido, ' - ', codigo) AS label FROM funcionario WHERE id_funcionario = " . $data->id_funcionario);
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
              <input type="text" name="fecha" class="inputForm form-control fecha_hora" value="<?php echo date("d/m/Y H:i:s", $data->fecha); ?>">
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
                    if ($data->id_incidencia == $tipo->id_incidencia) {
                      echo '<option value="' . $tipo->id_incidencia . '" selected>' . $tipo->codigo . ' - ' . $tipo->nombre . '</option>';
                    } else {
                      echo '<option value="' . $tipo->id_incidencia . '">' . $tipo->codigo . ' - ' . $tipo->nombre . '</option>';
                    }
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
                    if ($data->id_lector == $each->id_lector) {
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

          <div class="form-group" style="padding: 0;">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Observacion</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <textarea name="observacion" id="observacion" class="inputForm form-control" rows="3" placeholder=""><?php echo $data->observacion; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Adjuntar documento</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <div style="margin-bottom:5px;">
                <select class="inputForm multiselect" name="funcionario_documento" id="DocumentosFuncionario">
                  <option value="">Seleccionar</option>
                  <?php
                  if (!empty($data->id_funcionario)) {
                    $documentos_funcionario = $db->get_results("SELECT fd.*, d.nombre as documento_nombre FROM funcionario_documento as fd LEFT JOIN documento as d ON d.id_documento = fd.id_documento WHERE id_funcionario = '$data->id_funcionario'");
                    if (!empty($documentos_funcionario)) {
                      foreach ($documentos_funcionario as $df) {
                        if ($df->id_funcionario_documento == $data->id_funcionario_documento) {
                          echo '<option value="' . $df->id_funcionario_documento . '" selected>' . $df->id_funcionario_documento . ' - ' . $df->documento_nombre . '</option>';
                        } else {
                          echo '<option value="' . $df->id_funcionario_documento . '">' . $df->id_funcionario_documento . ' - ' . $df->documento_nombre . '</option>';
                        }
                      }
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="text-center">
                <button type="button" class="btn btn-biocloud-blue" onclick="modaldocumento();">Agregar documento</button>
                <div id="mensajeErrorAgregarDocumento"></div>
              </div>
            </div>
          </div>
          <hr />
          <div class="form-group">
            <div class="col-xs-9 col-sm-9 col-lg-9">
            </div>
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <button type="submit" class="btn btn-biocloud-blue" style="float:right;width:165px;" name="borrar">Borrar marca</button>
            </div>
          </div>
          <hr />
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