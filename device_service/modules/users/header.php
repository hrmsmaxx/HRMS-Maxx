<div class="col-xs col-sm col-lg">
  <div class="card transparente">
    <h2 class="tituloSeccion" style="margin:0;"><i class="md md-group" style="padding-right:15px;"></i><b><?php echo $seccion->nombre; ?></b></h2>
  </div>
</div>
<div class="col-xs col-sm col-lg">
  <div class="card transparente">
    <?php if ($add) : ?>
      <div class="col-xs-6 col-sm-6 col-lg-2 buttonBox">
        <button class="btn btn-biocloud-green" data-toggle="modal" data-target="#Agregar"><i class="glyphicon glyphicon-plus" style="color:white"></i> Agregar <?php echo $seccion->nombre; ?></button>
      </div>
    <?php endif; ?>
    <div class="col-xs-6 col-sm-6 col-lg-2 buttonBox">
      <span class="btn btn-biocloud-orange"><a style="text-decoration:none" href="index.php?option=users_roles"><i class="glyphicon glyphicon-log-in" style="color:white"></i> Roles de usuario</a></span>
    </div>
  </div>
</div>