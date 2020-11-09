<?php
require_once ROOT_URL . "/server/models/Dispositivo.php";
?>

<div class="modal fade" id="Agregar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Agregar funcionario</h4>
      </div>
      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div id="rootwizard2" class="form-wizard form-wizard-horizontal">
            <div class="form-wizard-nav">
              <div class="progress">
                <div class="progress-bar progress-bar-primary"></div>
              </div>
              <ul class="nav nav-justified horizontalNav">
                <li class="active"><a href="#step1" data-toggle="tab"><span class="step">1</span> <span class="title">Datos personales</span></a></li>
                <li><a href="#step3" data-toggle="tab"><span class="step">3</span> <span class="title">Verificación en reloj</span></a></li>
              </ul>
            </div>
            <!--end .form-wizard-nav -->
            <div class="tab-content clearfix">
              <div class="tab-pane active" id="step1">
                <?php
                $inicio->agregarCampoForm2(array("name" => "nombre", "label" => "Nombre", "mandatory" => true));
                $inicio->agregarCampoForm2(array("name" => "apellido", "label" => "Apellido", "mandatory" => true));
                $inicio->agregarCampoForm2(array("name" => "codigo", "label" => "Código", "mandatory" => true));
                ?>
              </div>
              <div class="tab-pane" id="step3">
                <?php
                $inicio->agregarCampoForm2(array("name" => "lectores", "label" => "lector", "label" => "Asignar funcionario a relojes", "type" => "select", "multiple" => true, "fields" => Dispositivo::obtenerSelectInfo()));
                $inicio->agregarCampoForm2(array("name" => "tarjeta_rfid", "label" => "Tarjeta RFID"));
                $inicio->agregarCampoForm2(array("name" => "contrasena_reloj", "label" => "Contraseña reloj"));
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
                <?php if (!empty($inicio->opciones['generales']['sistema_prestamos']['valor'])) {
                  $inicio->agregarCampoForm2(array("name" => "pin_prestamos", "type" => "password", "label" => "PIN prestamos"));
                ?>
                  <div class="form-group">
                    <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Estado prestamos</label></div>
                    <div class="col-xs-9 col-sm-9 col-lg-6">
                      <div class="radio radio-styled">
                        <label>
                          <input type="radio" name="activo_prestamos" value="1" checked="checked">
                          <span>Activo</span>
                        </label>
                      </div>
                      <div class="radio radio-styled">
                        <label>
                          <input type="radio" name="activo_prestamos" value="0">
                          <span>Inactivo - Deshabilitado</span>
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Asistencia prestamos</label></div>
                    <div class="col-xs-9 col-sm-9 col-lg-6">
                      <div class="radio radio-styled">
                        <label>
                          <input type="radio" name="asistencia_prestamos" value="1">
                          <span>Activo</span>
                        </label>
                      </div>
                      <div class="radio radio-styled">
                        <label>
                          <input type="radio" name="asistencia_prestamos" value="0" checked="checked">
                          <span>Inactivo - Deshabilitado</span>
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Autorizacion retiro control de edad en prestamos</label></div>
                    <div class="col-xs-9 col-sm-9 col-lg-6">
                      <div class="radio radio-styled">
                        <label>
                          <input type="radio" name="autorizacion_prestamos" value="1">
                          <span>Activo</span>
                        </label>
                      </div>
                      <div class="radio radio-styled">
                        <label>
                          <input type="radio" name="autorizacion_prestamos" value="0" checked="checked">
                          <span>Inactivo - Deshabilitado</span>
                        </label>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
              <!--end #step3 -->
            </div>
            <!--end .tab-content -->
          </div>
          <!--end #rootwizard -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="agregar"><i class="glyphicon glyphicon-ok" style="color:white"></i> Agregar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="Importar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Importar <?php echo mb_strtolower($seccion->nombre, "UTF-8"); ?></h4>
      </div>
      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <?php
          $inicio->agregarCampoForm2(array("label" => "Lector", "type" => "select", "multiple" => true, "fields" => Dispositivo::obtenerSelectInfo()));
          ?>
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="Número-factura" class="control-label">Archivo de funcionarios (user.dat)</label>
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

<div class="modal fade" id="Bajar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Bajar <?php echo mb_strtolower($seccion->nombre, "UTF-8"); ?></h4>
      </div>
      <form id="formBajar" class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <div class="modal-body">
          <?php
          $inicio->agregarCampoForm2(array("label" => "lector", "label" => "Lector", "id" => "lectorInputgetFuncionarios", "type" => "select", "multiple" => true, "fields" => Dispositivo::obtenerSelectInfo()));
          ?>
          <div class="form-group" style="padding: 0;">
            <div class="col-xs-3 col-sm-3 col-lg-3">
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <button style="width:100%" onclick="Comunicacion_sendAction('getStatus','#lectorInputgetFuncionarios','#responseBajar');" type="button" class="comButton btn btn-biocloud-yellow" name="corregir">Comprobar Estado</button>
            </div>
          </div>
          <hr />
          <div class="form-group" style="padding: 0;">
            <div class="col-sm-12" id="responseBajar" style="text-align:center;font-weight:bold"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button onclick="Comunicacion_sendAction('getFuncionarios','#lectorInputgetFuncionarios','#responseBajar');" type="button" class="comButton btn btn-biocloud-yellow" name="corregir"><i class="glyphicon glyphicon-ok" style="color:white"></i> Bajar funcionarios</button>
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
      <form id="formActualizar" class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <div class="modal-body">
          <div class="form-group" style="padding: 0;">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Lector</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select id="lectorInputactualizarFuncionarios" name="lector[]" class="multiselect" multiple="multiple">
                <option value="">Seleccionar</option>
                <?php
                $tipos = Dispositivo::obtenerSelectInfo();
                if (!empty($tipos)) {
                  foreach ($tipos as $tipo) :
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
              <button style="width:100%" onclick="Comunicacion_sendAction('getStatus','#lectorInputactualizarFuncionarios','#responseActualizar');" type="button" class="comButton btn btn-biocloud-yellow" name="corregir">Comprobar Estado</button>
            </div>
          </div>
          <hr />
          <div class="form-group" style="padding: 0;">
            <div class="col-sm-12" id="responseActualizar" style="text-align:center;font-weight:bold">

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button onclick="Comunicacion_sendAction('actualizarFuncionarios','#lectorInputactualizarFuncionarios','#responseActualizar');" type="button" class="comButton btn btn-biocloud-yellow" name="corregir"><i class="glyphicon glyphicon-ok" style="color:white"></i> Actualizar funcionarios</button>
        </div>
      </form>
    </div>
  </div>
</div>