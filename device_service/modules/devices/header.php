<div class="col-xs col-sm col-lg">
  <div class="card transparente">
    <h2 style="margin:0;"><i class="glyphicon glyphicon-phone" style="padding-right:15px;"></i><b>Dispositivos</b></h2>
  </div>
</div>
<div class="col-xs col-sm col-lg">
  <div class="card transparente">
    <?php if ($add) : ?>
      <div class="col-xs-6 col-sm-6 col-lg-2 buttonBox">
        <button class="btn btn-biocloud-green" data-toggle="modal" data-target="#Agregar"><i class="glyphicon glyphicon-plus" style="color:white"></i> Agregar <?php echo $seccion->nombreSingular; ?></button>
      </div>
      <div class="col-xs-6 col-sm-6 col-lg-2 buttonBox">
        <button class="btn btn-biocloud-green" data-toggle="modal" data-target="#Credenciales"><i class="materialadmin md md-lock-outline" style="color:white"></i> Credenciales</button>
      </div>
    <?php endif; ?>
  </div>
</div>