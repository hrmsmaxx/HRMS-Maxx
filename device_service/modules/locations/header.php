<div class="col-xs col-sm col-lg">
  <div class="card transparente">
    <h2 style="margin:0;"><i class="glyphicon glyphicon-calendar" style="padding-right:15px;"></i><b><?php echo $seccion->nombre; ?></b></h2>
  </div>
</div>
<div class="col-xs col-sm col-lg">
  <div class="card transparente">
    <?php if ($add) : ?>
      <div class="col-xs-6 col-sm-6 col-lg-2 buttonBox">
        <button class="btn btn-biocloud-green" data-toggle="modal" data-target="#Agregar"><i class="iconoBoton glyphicon glyphicon-plus" style="color:white"></i> Agregar <?php echo $seccion->nombreSingular; ?></button>
      </div>
    <?php endif; ?>
  </div>
</div>