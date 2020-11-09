<div class="modal fade" id="Agregar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Agregar <?php echo mb_strtolower($seccion->nombreSingular, "UTF-8"); ?></h4>
      </div>
      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <div class="modal-body">
          <?php $inicio->agregarCampoForm('Nombre', '', '', '', true); ?>

          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="Codigo" class="control-label">Código</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <input type="text" name="Codigo" id="Codigo" class="form-control " value="0" placeholder="Código" autocomplete="off">
              <div class="form-control-line"></div>
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


<div class="modal fade" id="Actualizar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Actualizar <?php echo mb_strtolower($seccion->nombre, "UTF-8"); ?></h4>
      </div>
      <form id="formBajar" class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <div class="modal-body">
          <div class="form-group" style="padding: 0;">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Lector</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select id="lectorInput" name="lector[]" class="multiselect" multiple="multiple">
                <option value="">Seleccionar</option>
                <?php
                $devices = $db->get_results("SELECT d.*, l.name as location_name FROM _device as d LEFT JOIN _location as l ON l.id = d.location_id WHERE d.status = 1 ", array("d"));
                if (!empty($devices)) {
                  foreach ($devices as $device) :
                    echo '<option value="' . $device->id . '">' . $device->id . ' - ' . $device->ip . ':' . $device->port . ' - ' . $device->location_name . '</option>';
                  endforeach;
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group" style="padding: 0;">
            <div class="col-xs-3 col-sm-3 col-lg-3">
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <button style="width:100%;" onclick="Comunicacion_sendAction('getStatus');" type="button" class="comButton btn btn-biocloud-yellow" name="corregir">Comprobar Estado</button>
            </div>
          </div>
          <hr />
          <div class="form-group" style="padding: 0;">
            <div class="col-sm-12" id="response" style="text-align:center;font-weight:bold">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button onclick="Comunicacion_sendAction('actualizarIncidencias');" type="button" class="comButton btn btn-biocloud-yellow" name="corregir"><i class="glyphicon glyphicon-ok" style="color:white"></i> Actualizar incidencias</button>
        </div>
      </form>
    </div>
  </div>
</div>