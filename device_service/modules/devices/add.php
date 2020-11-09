<div class="modal fade" id="Agregar" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Agregar <?php echo mb_strtolower($seccion->nombreSingular, "UTF-8"); ?></h4>
      </div>
      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <div class="modal-body">
          <div id="rootwizard2" class="form-wizard form-wizard-horizontal">
            <div class="form-wizard-nav">
              <div class="progress">
                <div class="progress-bar progress-bar-primary"></div>
              </div>
              <ul class="nav nav-justified horizontalNav">
                <li class="active"><a href="#step1" data-toggle="tab"><span class="step">1</span> <span class="title">Configuración general</span></a></li>
                <li><a href="#step2" data-toggle="tab"><span class="step">2</span> <span class="title">Consumo de datos automático</span></a></li>
              </ul>
            </div>
            <!--end .form-wizard-nav -->
            <div class="tab-content clearfix">
              <div class="tab-pane active" id="step1">
                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="Puerto" class="control-label">Numero de serie</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="serial" id="serial" class="form-control " value="" placeholder="Numero de serie" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="Ip" class="control-label">IP <span style="color:red;">(*)</span></label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="Ip" id="Ip" class="form-control " value="0.0.0.0" placeholder="IP" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="Puerto" class="control-label">Puerto <span style="color:red;">(*)</span></label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="Puerto" id="Puerto" class="form-control " value="0" placeholder="Puerto" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>

                <div class="form-group" style="padding: 0;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="email1" class="control-label">Ubicación</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select name="Ubicacion" class="multiselect">
                      <option value="">Seleccionar</option>
                      <?php
                      $tipos = $db->get_results("SELECT * FROM _location WHERE status = 1");
                      if (!empty($tipos)) {
                        foreach ($tipos as $tipo) :
                          echo '<option value="' . $tipo->id . '">' . $tipo->name . '</option>';
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group" id="contenedorFormaTiempo">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Zona horaria</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select id="FormaTiempo" name="FormaTiempo" class="multiselect">
                      <option value="0">Sin establecer</option>
                      <option value="1">Hora del servidor</option>
                      <option value="2">Hora de computadora</option>
                    </select>
                  </div>
                </div>

              </div>
              <!--end #step1 -->
              <div class="tab-pane" id="step2">

                <div class="col-sm-12">
                  <center>
                    <h2 style="margin:0;margin-bottom:20px;font-size:18px;">Funcionarios</h2>
                  </center>
                </div>


                <div class="form-group" style="padding: 0;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Modalidad</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select id="ModalidadActualizacion" name="ModalidadActualizacion" class="multiselect">
                      <option value="" selected>No actualizar automáticamente</option>
                      <option value="time">Hora</option>
                      <option value="interval">Intervalo</option>
                    </select>
                  </div>
                </div>

                <div class="form-group" id="contenedorIntervaloActualizacion" style="display:none;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Intervalo (minutos)</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="number" name="IntervaloActualizacion" id="IntervaloActualizacion" class="form-control " value="0" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>

                <div class="form-group" id="contenedorHoraActualizacion" style="display:none;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Hora</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="HoraActualizacion" class="form-control hora salida_desde" placeholder="00:00">
                  </div>
                </div>

                <div class="col-sm-12">
                  <center>
                    <h2 style="margin:0;margin-bottom:20px;font-size:18px;">Actualización de tiempo de dispositivo</h2>
                  </center>
                </div>

                <div class="form-group" style="padding: 0;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Modalidad</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select id="ModalidadTiempo" name="ModalidadTiempo" class="multiselect">
                      <option value="" selected>No actualizar automáticamente</option>
                      <option value="time">Hora</option>
                      <option value="interval">Intervalo</option>
                    </select>
                  </div>
                </div>

                <div class="form-group" id="contenedorIntervaloTiempo" style="display:none;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Intervalo (minutos)</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="number" name="IntervaloTiempo" id="IntervaloTiempo" class="form-control " value="0" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>

                <div class="form-group" id="contenedorHoraTiempo" style="display:none;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Hora</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="HoraTiempo" class="form-control hora salida_desde" placeholder="00:00">
                  </div>
                </div>


                <div class="col-sm-12">
                  <center>
                    <h2 style="margin:0;margin-bottom:20px;font-size:18px;">Descarga de marcas automáticas</h2>
                  </center>
                </div>

                <div class="form-group" style="padding: 0;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Modalidad</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select id="ModalidadConsumo" name="ModalidadConsumo" class="multiselect">
                      <option value="" selected>No consumir automáticamente</option>
                      <option value="time">Hora</option>
                      <option value="interval">Intervalo</option>
                    </select>
                  </div>
                </div>

                <div class="form-group" id="contenedorIntervalo" style="display:none;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Intervalo (minutos)</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="number" name="IntervaloConsumo" id="IntervaloConsumo" class="form-control " value="0" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>

                <div class="form-group" id="contenedorHora" style="display:none;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Hora</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="HoraConsumo" class="form-control hora salida_desde" placeholder="00:00">
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Borrar marcas</label></div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <div class="radio radio-styled">
                      <label>
                        <input type="radio" id="borrar_marcas_1" name="borrar_marcas" value="1">
                        <span>Si</span>
                      </label>
                    </div>
                    <div class="radio radio-styled">
                      <label>
                        <input type="radio" id="borrar_marcas_1" name="borrar_marcas" value="0" checked="checked">
                        <span>No</span>
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Crear funcionario al subir marcas</label></div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <div class="radio radio-styled">
                      <label>
                        <input type="radio" id="crear_funcionario_1" name="crear_funcionario" value="1" checked="checked">
                        <span>Si</span>
                      </label>
                    </div>
                    <div class="radio radio-styled">
                      <label>
                        <input type="radio" id="crear_funcionario_1" name="crear_funcionario" value="0">
                        <span>No</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <!--end #step2 -->
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

<div class="modal fade" id="Credenciales" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Gestionar credenciales</h4>
      </div>
      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <div class="modal-body">
          <?php $inicio->agregarCampoForm('ApiKey', $db->get_var("SELECT apikey FROM _subdomain")); ?>
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <span id="generarApiKey" class="btn btn-biocloud-yellow" style="width:100%">Generar nueva clave</span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="credenciales"><i class="glyphicon glyphicon-ok" style="color:white"></i> Agregar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function makeid(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789/_-';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
  }

  document.querySelector("#ApiKey").onclick = function() {
    this.select();
  }

  const botonApiKey = document.querySelector("#generarApiKey");
  if (botonApiKey) {
    botonApiKey.onclick = function() {
      document.querySelector("#ApiKey").value = makeid(50);
    }
  }
</script>