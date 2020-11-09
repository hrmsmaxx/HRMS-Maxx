<?php
$seccion->cargarInfo();
?>

<div class="col-xs col-sm col-lg">
  <div class="card transparente">
    <h2 style="margin:0;"><i class="glyphicon glyphicon-phone" style="padding-right:15px;"></i><b>Dispositivos > Administrar funcionarios > <?php echo $seccion->infoLector->ip . ":" . $seccion->infoLector->port . " - " . $seccion->infoLector->ubicacion_nombre; ?></b></h2>
  </div>
</div>


<div class="col-xs col-sm col-lg">
  <div class="card transparente">
    <div class="col-xs-6 col-sm-6 col-lg-2 buttonBox">
      <span class="btn btn-biocloud-grey"><a style="text-decoration:none" href="index.php?option=devices_employees"><i class="md md-arrow-back" style="color:white"></i> Volver</a></span>
    </div>
    <?php if ($add) : ?>
      <div class="col-xs-6 col-sm-6 col-lg-2 buttonBox">
        <button class="btn btn-biocloud-green" data-toggle="modal" data-target="#AgregarFuncionario"><i class="glyphicon glyphicon-plus" style="color:white"></i> Agregar individual</button>
      </div>
      <div class="col-xs-6 col-sm-6 col-lg-2 buttonBox">
        <span class="btn btn-biocloud-orange"><a href="index.php?option=opciones-lectores-funcionarios&ajaxenable=true&action=exportarFuncionarios&lector=<?php echo $seccion->lector; ?>" target="_blank" style="text-decoration:none;"><i class="glyphicon glyphicon-export" style="color:white"></i> Exportar</a></span>
      </div>
    <?php endif; ?>
  </div>
</div>