<?php
require_once ROOT_URL . "/server/models/Dispositivo.php";
?>
<div class="modal fade" id="Importar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="row">
    <div class="col-sm-12">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header header-biocloud-orange">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="formModalLabel">Importar <?php echo mb_strtolower($seccion->nombre, "UTF-8"); ?></h4>
          </div>
          <form id="formImportar" class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group" style="padding: 0;">
                <div class="col-xs-3 col-sm-3 col-lg-3">
                  <label for="email1" class="control-label">Lector</label>
                </div>
                <div class="col-xs-9 col-sm-9 col-lg-6">
                  <select name="lector" class="multiselect">
                    <option value="">Seleccionar</option>
                    <?php
                    $devices = Dispositivo::obtenerSelectInfo();
                    if (!empty($devices)) {
                      foreach ($devices as $tipo) :
                        echo '<option value="' . $tipo->value . '">' . $tipo->name . '</option>';
                      endforeach;
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-3 col-sm-3 col-lg-3">
                  <label for="Número-factura" class="control-label">Archivo de asistencias (.dat)</label>
                </div>
                <div class="col-xs-9 col-sm-9 col-lg-6">
                  <input id="filename" type="file" class="input disabled" name="archivoshow" style="width: 290px;" readonly>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-biocloud-yellow" name="importar"><i class="glyphicon glyphicon-ok" style="color:white"></i> Importar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="Bajar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="row">
    <div class="col-sm-12">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header header-biocloud-orange">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="formModalLabel">Bajar <?php echo mb_strtolower($seccion->nombre, "UTF-8"); ?></h4>
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
                    if (!empty($devices)) {
                      foreach ($devices as $tipo) :
                        echo '<option value="' . $tipo->value . '">' . $tipo->name . '</option>';
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
                  <button style="width:100%" id="com_estado" onclick="Comunicacion_sendAction('getStatus');" type="button" class="comButton btn btn-biocloud-yellow" name="corregir">Comprobar Estado</button>
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
              <button id="com_corregir" onclick="Comunicacion_sendAction('getMarcas');" type="button" class="comButton btn btn-biocloud-yellow" name="corregir"><i class="glyphicon glyphicon-ok" style="color:white"></i> Bajar marcas</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('#hora_de_cierre').datetimepicker({
    format: 'hh:ii',
    language: 'es',
    autoclose: 1,
    startView: 1,
    forceParse: 0,
    showMeridian: 1
  });

  $('.fecha_dia').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: "dd/mm/yyyy"
  });
</script>