<?php
if ($inicio->can_do('agregar')) :
  require_once ROOT_URL . "/server/models/Dispositivo.php";
  $iddata = $db->escape($_GET['iddata']);
  $data = $seccion->cargar($iddata);
?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="simpleModalLabel">Editar</h4>
      </div>

      <form id="formEditar" class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="iddata" value="<?php echo $iddata; ?>">
          <div id="rootwizard2-editar" class="form-wizard form-wizard-horizontal">
            <div class="form-wizard-nav">
              <div class="progress">
                <div class="progress-bar progress-bar-primary"></div>
              </div>
              <ul class="nav nav-justified horizontalNav">
                <li class="active"><a href="#step1-editar" data-toggle="tab"><span class="step">1</span> <span class="title">Datos personales</span></a></li>
                <li><a href="#step3-editar" data-toggle="tab"><span class="step">3</span> <span class="title">Verificación en reloj</span></a></li>
              </ul>
            </div>
            <!--end .form-wizard-nav -->
            <div class="tab-content clearfix">
              <div class="tab-pane active" id="step1-editar">
                <?php
                $inicio->agregarCampoForm2(array("name" => "nombre", "label" => "Nombre", "value" => $data->first_name, "mandatory" => true));
                $inicio->agregarCampoForm2(array("name" => "apellido", "label" => "Apellido", "value" => $data->last_name, "mandatory" => true));
                $inicio->agregarCampoForm2(array("name" => "codigo", "label" => "Código", "value" => $data->device_code, "mandatory" => true));
                ?>
              </div>
              <div class="tab-pane" id="step3-editar">
                <?php
                $devices = explode(",", $data->devices);
                $inicio->agregarCampoForm2(array("name" => "lectores", "label" => "lector", "label" => "Asignar funcionario a relojes", "type" => "select", "multiple" => true, "fields" => Dispositivo::obtenerSelectInfo(), "value" => $devices));
                $inicio->agregarCampoForm2(array("name" => "tarjeta_rfid", "label" => "Tarjeta RFID", "value" => $data->rfid_card));
                $inicio->agregarCampoForm2(array("name" => "contrasena_reloj", "label" => "Contraseña reloj", "value" => $data->device_password));
                ?>

                <div class="form-group escanerDeHuella">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="huella" class="labelHuella control-label">Huella (Desactivado)</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <span class="escanearHuella btn btn-biocloud-yellow" style="width:100%">Activar escaner huella</span>
                    <span class="huellaResult" style="display:none">Ingrese el dedo en el lector<br /><img width="250" src="images/ImagenDedo.png" /></span>
                    <input type="hidden" name="huella" class="Huella form-control" value="" placeholder="" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>
                <script>
                  var huellaActual = -1;
                  $("#escanearHuella").on("click", function() {
                    $(this).hide();
                    var contenedor = $(this).parents(".escanerDeHuella");
                    contenedor.find(".huellaResult").show();
                    delete_cookie("huella_id");
                    huellaActual = get_cookie("huella_id");
                    contenedor.find(".labelHuella").text("Huella (Activado)");
                    setInterval(function() {
                      var tmpHuella = get_cookie("huella_id");
                      if (tmpHuella != huellaActual) {
                        contenedor.find(".Huella").val(tmpHuella);
                        contenedor.find(".huellaResult").text("Huella escaneada, id: " + tmpHuella);
                      }
                    }, 100);
                  });
                </script>
              </div>
              <!--end #step3 -->
            </div>
            <!--end .tab-content -->
          </div>
          <!--end #rootwizard -->
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Estado</label></div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <div class="radio radio-styled">
                <label>
                  <input type="radio" name="activo" value="1" <?php if ($data->status == 1) echo 'checked="checked"'; ?>>
                  <span>Activo</span>
                </label>
              </div>
              <div class="radio radio-styled">
                <label>
                  <input type="radio" name="activo" value="0" <?php if ($data->status == 0) echo 'checked="checked"'; ?>>
                  <span>Inactivo - Deshabilitado</span>
                </label>
              </div>
            </div>
          </div>

          <hr />

          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="eliminarTodas" class="control-label">Eliminar todas las huellas del usuario</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select id="eliminarTodas" name="eliminarTodas" class="multiselect">
                <option value="0">No</option>
                <option value="1">Si</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-9 col-sm-9 col-lg-9">
            </div>
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <script>
                function clicked(e) {
                  if (confirm('Esta a punto de eliminar un funcionario. ¿Realmente quiere hacerlo?')) {
                    document.querySelector("#borrarFuncionario").click();
                  } else {
                    return false;
                  }
                }
              </script>
              <button type="button" onclick="clicked()" class="btn btn-biocloud-blue" style="float:right;width:165px;">Borrar funcionario</button>
              <button id="borrarFuncionario" type="submit" style="display:none" name="borrar">Borrar funcionario</button>
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