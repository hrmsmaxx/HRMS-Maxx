<?php
$iddata = $db->escape($_GET['iddata']);
$data = $seccion->cargar($iddata);
if ($inicio->can_do('agregar')) :
?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="simpleModalLabel">Información ampliada</h4>
      </div>

      <div class="modal-body">
        <?php
        $inicio->mostrarCampo('Nombre', $data->nombre);
        $inicio->mostrarCampo('Apellido', $data->apellido);
        $inicio->mostrarCampo('Usuario', $data->usuario);
        $inicio->mostrarCampo('Mail', $data->mail);
        $inicio->mostrarCampo('Rango', $data->rol);

        if ($data->activo) $o = '<span class="label green activo"><i class="glyphicon glyphicon-ok"></i></span>';
        else $o = '<span class="label red noactivo"><i class="glyphicon glyphicon-remove"></i></span> Bloqueado';
        $inicio->mostrarCampo('Activo', $o);

        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
<?php else : ?><div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
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