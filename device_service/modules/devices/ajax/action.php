<?php

$iddata = $db->escape($_GET['iddata']);
$data = $seccion->cargar($iddata);

if ($inicio->can_do('agregar')) :
?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="simpleModalLabel">Acciones de lectores</h4>
      </div>

      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <div class="modal-body">
          <input id="lectorInput" type="hidden" name="iddata" data-nombre="<?php echo $data->id . ' - ' . $data->ip . ':' . $data->port; ?>" value="<?php echo $iddata; ?>">

          <div class="form-group" style="padding: 0;">
            <div class="col-sm-12" align="center">
              <h2>Lector <?php echo $data->ip . ":" . $data->port; ?></h2>
            </div>
          </div>

          <div class="form-group" style="padding: 0;">
            <div class="col-xs col-sm col-md-6 col-lg-6" align="center" style="margin-bottom:15px;">
              <button style="width:100%" onclick="Comunicacion_sendAction('getStatusFull');" type="button" class="comButton btn btn-biocloud-green">Leer estado</button>
            </div>
            <div class="col-xs col-sm col-md-6 col-lg-6" align="center" style="margin-bottom:15px;">
              <button style="width:100%" onclick="Comunicacion_sendAction('getInfo');" type="button" class="comButton btn btn-biocloud-green">Leer información</button>
            </div>
          </div>

          <div class="form-group" style="padding: 0;">
            <div class="col-xs col-sm col-md-6 col-lg-6" align="center" style="margin-bottom:15px;">
              <button style="width:100%" onclick="Comunicacion_sendAction('getMarcas');" type="button" class="comButton btn btn-biocloud-green">Bajar marcas</button>
            </div>
            <div class="col-xs col-sm col-md-6 col-lg-6" align="center" style="margin-bottom:15px;">
              <button style="width:100%" onclick="Comunicacion_sendAction('subirfuncionarios');" type="button" class="comButton btn btn-biocloud-green">Guardar datos funcionarios</button>
            </div>
          </div>

          <div class="form-group" style="padding: 0;">
            <div class="col-xs col-sm col-md-6 col-lg-6" align="center" style="margin-bottom:15px;">
              <button style="width:100%" onclick="Comunicacion_sendAction('actualizarFuncionarios');" type="button" class="comButton btn btn-biocloud-green">Actualizar funcionarios</button>
            </div>
            <div class="col-xs col-sm col-md-6 col-lg-6" align="center" style="margin-bottom:15px;">
              <button style="width:100%" onclick="Comunicacion_sendAction('actualizarIncidencias');" type="button" class="comButton btn btn-biocloud-green">Actualizar incidencias</button>
            </div>
          </div>

          <div class="form-group" style="padding: 0;">
            <div class="col-xs col-sm col-md-6 col-lg-6" align="center" style="margin-bottom:15px;">
              <button style="width:100%" onclick="Conf_Forzar_Actualizar_Func();" type="button" class="comButton btn btn-biocloud-green">Forzar actualizar funcionarios</button>
            </div>
            <div class="col-xs col-sm col-md-6 col-lg-6" align="center" style="margin-bottom:15px;">
              <button style="width:100%" onclick="Comunicacion_sendAction('');" type="button" class="comButton btn btn-biocloud-green">Limpiar acciones</button>
            </div>
          </div>
          <div class="form-group" style="padding: 0;">
            <div class="col-xs col-sm col-md-6 col-lg-6" align="center" style="margin-bottom:15px;">
              <button style="width:100%" onclick="Comunicacion_sendAction('gettime');" type="button" class="comButton btn btn-biocloud-green">Actualizar hora del dispositivo</button>
            </div>
          </div>
          <hr />
          <div class="form-group" style="padding: 0;">
            <div class="col-sm-12" id="response" style="text-align:center;font-weight:bold">

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" onclick="Comunicacion_sendAction('');" data-dismiss="modal">Cancelar</button>
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