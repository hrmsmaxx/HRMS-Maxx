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
          <div id="rootwizard2-editar" class="form-wizard form-wizard-horizontal">
            <div class="form-wizard-nav">
              <div class="progress">
                <div class="progress-bar progress-bar-primary"></div>
              </div>
              <ul class="nav nav-justified horizontalNav">
                <li class="active"><a href="#step1-editar" data-toggle="tab"><span class="step">1</span> <span class="title">Configuración general</span></a></li>
                <li><a href="#step2-editar" data-toggle="tab"><span class="step">2</span> <span class="title">Consumo de datos automático</span></a></li>
              </ul>
            </div>
            <!--end .form-wizard-nav -->
            <div class="tab-content clearfix">
              <div class="tab-pane active" id="step1-editar">

                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="Puerto" class="control-label">Numero de serie</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="serial" id="serial" class="form-control " value="<?php echo $data->serial_number; ?>" placeholder="Numero de serie" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="Ip" class="control-label">IP <span style="color:red;">(*)</span></label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="Ip" id="Ip" class="form-control " value="<?php echo $data->ip; ?>" placeholder="IP" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>
                <?php $inicio->agregarCampoForm('Puerto', $data->port, '', '', true); ?>

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
                          if ($data->location_id == $tipo->id) {
                            echo '<option value="' . $tipo->id . '" selected>' . $tipo->name . '</option>';
                          } else {
                            echo '<option value="' . $tipo->id . '">' . $tipo->name . '</option>';
                          }
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Zona horaria</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select id="FormaTiempo" name="FormaTiempo" class="multiselect">
                      <option value="0">Sin establecer</option>
                      <option value="1" <?php if ($data->timezone == 1) {
                                          echo "selected";
                                        } ?>>Hora del servidor</option>
                      <option value="2" <?php if ($data->timezone == 2) {
                                          echo "selected";
                                        } ?>>Hora de computadora</option>
                    </select>
                  </div>
                </div>

              </div>
              <div class="tab-pane" id="step2-editar">

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
                    <select id="ModalidadActualizacionEditar" name="ModalidadActualizacion" class="multiselect">
                      <option value="" <?php if ($data->update_mode == 0) {
                                          echo "selected";
                                        } ?>>No actualizar automáticamente</option>
                      <option value="time" <?php if ($data->update_mode == 'time') {
                                              echo "selected";
                                            } ?>>Hora</option>
                      <option value="interval" <?php if ($data->update_mode == 'interval') {
                                                  echo "selected";
                                                } ?>>Intervalo</option>
                    </select>
                  </div>
                </div>

                <div class="form-group" id="contenedorIntervaloActualizacionEditar" <?php if ($data->update_mode != 'interval') {
                                                                                      echo 'style="display:none;"';
                                                                                    } ?>>
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Intervalo (minutos)</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="IntervaloActualizacion" id="IntervaloActualizacion" class="form-control hora" value="<?php echo $data->update_interval; ?>" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>

                <div class="form-group" id="contenedorHoraActualizacionEditar" <?php if ($data->update_mode != 'time') {
                                                                                  echo 'style="display:none;"';
                                                                                } ?>>
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Hora</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="HoraActualizacion" class="form-control hora salida_desde" placeholder="00:00" value="<?php echo $data->update_time; ?>">
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
                    <select id="ModalidadTiempoEditar" name="ModalidadTiempo" class="multiselect">
                      <option value="" <?php if (empty($data->clock_mode)) {
                                          echo "selected";
                                        } ?>>No actualizar automáticamente</option>
                      <option value="time" <?php if ($data->clock_mode == 'time') {
                                              echo "selected";
                                            } ?>>Hora</option>
                      <option value="interval" <?php if ($data->clock_mode == 'interval') {
                                                  echo "selected";
                                                } ?>>Intervalo</option>
                    </select>
                  </div>
                </div>



                <div class="form-group" id="contenedorIntervaloTiempoEditar" <?php if ($data->clock_mode != 'interval') {
                                                                                echo 'style="display:none;"';
                                                                              } ?>>
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Intervalo (minutos)</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="IntervaloTiempo" id="IntervaloTiempo" class="form-control hora" value="<?php echo $data->clock_interval; ?>" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>

                <div class="form-group" id="contenedorHoraTiempoEditar" <?php if ($data->clock_mode != 'time') {
                                                                          echo 'style="display:none;"';
                                                                        } ?>>
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Hora</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="HoraTiempo" class="form-control hora salida_desde" placeholder="00:00" value="<?php echo $data->clock_time; ?>">
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
                    <select id="ModalidadConsumoEditar" name="ModalidadConsumo" class="multiselect">
                      <option value="" <?php if ($data->consume_mode == 0) {
                                          echo "selected";
                                        } ?>>No consumir automáticamente</option>
                      <option value="time" <?php if ($data->consume_mode == 'time') {
                                              echo "selected";
                                            } ?>>Hora</option>
                      <option value="interval" <?php if ($data->consume_mode == 'interval') {
                                                  echo "selected";
                                                } ?>>Intervalo</option>
                    </select>
                  </div>
                </div>

                <div class="form-group" id="contenedorIntervaloEditar" <?php if ($data->consume_mode != 'interval') {
                                                                          echo 'style="display:none;"';
                                                                        } ?>>
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Intervalo (minutos)</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="IntervaloConsumo" id="IntervaloConsumo" class="form-control hora" value="<?php echo $data->consume_interval; ?>" autocomplete="off">
                    <div class="form-control-line"></div>
                  </div>
                </div>

                <div class="form-group" id="contenedorHoraEditar" <?php if ($data->consume_mode != 'time') {
                                                                    echo 'style="display:none;"';
                                                                  } ?>>
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Hora</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <input type="text" name="HoraConsumo" class="form-control hora salida_desde" placeholder="00:00" value="<?php echo $data->consume_time; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Borrar marcas</label></div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <div class="radio radio-styled">
                      <label>
                        <input type="radio" id="borrar_marcas_1" name="borrar_marcas" value="1" <?php if ($data->clean_attendance == 1) echo 'checked="checked"'; ?>>
                        <span>Si</span>
                      </label>
                    </div>
                    <div class="radio radio-styled">
                      <label>
                        <input type="radio" id="borrar_marcas_1" name="borrar_marcas" value="0" <?php if ($data->clean_attendance == 0) echo 'checked="checked"'; ?>>
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
                        <input type="radio" id="crear_funcionario_1" name="crear_funcionario" value="1" <?php if ($data->save_employee == 1) echo 'checked="checked"'; ?>>
                        <span>Si</span>
                      </label>
                    </div>
                    <div class="radio radio-styled">
                      <label>
                        <input type="radio" id="crear_funcionario_1" name="crear_funcionario" value="0" <?php if ($data->save_employee == 0) echo 'checked="checked"'; ?>>
                        <span>No</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--end .tab-content -->
          </div>
          <!--end #rootwizard -->
          <hr />
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Estado</label></div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <div class="radio radio-styled">
                <label>
                  <input type="radio" id="estado_1" name="estado" value="1" <?php if ($data->status == 1) echo 'checked="checked"'; ?>>
                  <span>Activo</span>
                </label>
              </div>
              <div class="radio radio-styled">
                <label>
                  <input type="radio" id="estado_0" name="estado" value="0" <?php if ($data->status == 0) echo 'checked="checked"'; ?>>
                  <span>Inactivo - Deshabilitado</span>
                </label>
              </div>
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