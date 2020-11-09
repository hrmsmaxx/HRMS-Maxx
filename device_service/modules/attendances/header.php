<div class="col-xs col-sm col-lg">
  <div class="card transparente">
    <h2 class="tituloSeccion" style="margin:0;"><i class="glyphicon glyphicon-hand-up" style="padding-right: 15px;"></i><b><?php echo $seccion->nombre; ?></b></h2>
  </div>
</div>
<div class="col-xs col-sm col-lg">
  <div class="card transparente">
    <?php if ($add) : ?>
      <div class="col-xs-6 col-sm-6 col-lg-2 buttonBox">
        <button class="btn btn-biocloud-orange" data-toggle="modal" data-target="#Bajar"><i class="glyphicon glyphicon-download" style="color:white"></i> Bajar <?php echo $seccion->nombre; ?></button>
      </div>
      <div class="col-xs-6 col-sm-6 col-lg-2 buttonBox">
        <button class="btn btn-biocloud-orange" data-toggle="modal" data-target="#Importar"><i class="glyphicon glyphicon-import" style="color:white"></i> Importar <?php echo $seccion->nombre; ?></button>
      </div>
    <?php endif; ?>
  </div>
</div>