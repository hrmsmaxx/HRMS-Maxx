<?php

$iddata = $db->escape($_GET['iddata']);

if ($inicio->can_do('agregar')) :
  $inicio->cargarOpciones();
?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="simpleModalLabel">Editar</h4>
      </div>
      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="iddata" value="<?php echo $iddata; ?>">
          <div id="rootwizard2-editar" class="form-wizard form-wizard-horizontal">
            <div class="form-wizard-nav">
              <div class="progress">
                <div class="progress-bar progress-bar-primary"></div>
              </div>
              <ul class="nav nav-justified horizontalNav">
                <li><a href="#step2-editar" data-toggle="tab"><span class="step">2</span> <span class="title">Datos de funcionario</span></a></li>
                <li><a href="#step3-editar" data-toggle="tab"><span class="step">3</span> <span class="title">Verificación en reloj</span></a></li>
              </ul>
            </div>
            <!--end .form-wizard-nav -->
            <div class="tab-content clearfix">
              <div class="tab-pane active" id="step2-editar">
                <div class="form-group" style="padding: 0;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Cargo</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select name="Cargo[]" class="multiselect" multiple>
                      <option value="not" selected>No modificar</option>
                      <option value="">Vaciar</option>
                      <?php
                      $tipos = $db->get_results("SELECT * FROM cargo WHERE activo = 1 ORDER BY id_cargo");
                      if (!empty($tipos)) {
                        foreach ($tipos as $tipo) :
                          echo '<option value="' . $tipo->id_cargo . '">' . $tipo->nombre . '</option>';
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group" style="padding: 0;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Turno</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select name="Turno" class="multiselect">
                      <option value="not" selected>No modificar</option>
                      <option value="">Vaciar</option>
                      <option value="-1">Automático</option>
                      <?php
                      $tipos = $db->get_results("SELECT * FROM turno WHERE activo = 1 ORDER BY id_turno");
                      if (!empty($tipos)) {
                        foreach ($tipos as $tipo) :
                          echo '<option value="' . $tipo->id_turno . '">' . $tipo->id_turno . ' - ' . $tipo->nombre . '</option>';
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group" style="padding: 0;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Centro</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select name="Centro" class="multiselect">
                      <option value="not" selected>No modificar</option>
                      <option value="">Vaciar</option>
                      <?php
                      $tipos = $db->get_results("SELECT * FROM centro WHERE activo = 1");
                      if (!empty($tipos)) {
                        foreach ($tipos as $tipo) :
                          echo '<option value="' . $tipo->id_centro . '">' . $tipo->nombre . '</option>';
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group" style="padding: 0;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="turno" class="control-label">Departamento</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select name="Departamento" class="multiselect">
                      <option value="not" selected>No modificar</option>
                      <option value="">Vaciar</option>
                      <?php
                      $tipos = $db->get_results("SELECT * FROM departamento WHERE activo = 1");
                      if (!empty($tipos)) {
                        foreach ($tipos as $tipo) :
                          echo '<option value="' . $tipo->id_departamento . '">' . $tipo->nombre . '</option>';
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="email1" class="control-label">Funcionario responsable</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select class="multiselect" name="Responsable" id="FiltroFuncionarioResponsable-Editar">
                      <option value="not" selected>No modificar</option>
                      <option value="">Escribe para buscar</option>
                    </select>
                  </div>
                </div>
              </div>
              <!--end #step2 -->
              <div class="tab-pane" id="step3-editar">
                <div class="form-group" style="padding: 0;">
                  <div class="col-xs-3 col-sm-3 col-lg-3">
                    <label for="email1" class="control-label">Asignar funcionario a relojes</label>
                  </div>
                  <div class="col-xs-9 col-sm-9 col-lg-6">
                    <select id="lectorInputgetFuncionarios" name="lector[]" class="multiselect" multiple="multiple">
                      <option value="not" selected>No modificar</option>
                      <option value="">Vaciar</option>
                      <?php

                      $tipos = $db->get_results("SELECT l.*, u.nombre as ubicacion_nombre FROM lector as l LEFT JOIN ubicacion as u ON l.id_ubicacion = u.id_ubicacion WHERE l.activo = 1");
                      if (!empty($tipos)) {
                        foreach ($tipos as $tipo) :
                          echo '<option value="' . $tipo->id_lector . '">' . $tipo->id_lector . ' - ' . $tipo->ip . ':' . $tipo->puerto . ' - ' . $tipo->ubicacion_nombre . '</option>';
                        endforeach;
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <?php
                if (!empty($inicio->opciones['generales']['sistema_prestamos']['valor'])) {
                ?>
                  <div class="form-group">
                    <div class="col-xs-3 col-sm-3 col-lg-3"><label for="moneda" class="control-label">Estado presestamos</label></div>
                    <div class="col-xs-9 col-sm-9 col-lg-6">
                      <div class="radio radio-styled">
                        <label>
                          <input type="radio" name="activo_prestamos" value="not" checked>
                          <span>No modificar</span>
                        </label>
                      </div>
                      <div class="radio radio-styled">
                        <label>
                          <input type="radio" name="activo_prestamos" value="1">
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
                <?php } ?>
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
                  <input type="radio" name="activo" value="not" checked>
                  <span>No modificar</span>
                </label>
              </div>
              <div class="radio radio-styled">
                <label>
                  <input type="radio" name="activo" value="1">
                  <span>Activo</span>
                </label>
              </div>
              <div class="radio radio-styled">
                <label>
                  <input type="radio" name="activo" value="0">
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

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="editarMultiple"><i class="glyphicon glyphicon-floppy-saved" style="color:white"></i> Guardar cambios</button>
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