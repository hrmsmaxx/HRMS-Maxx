<div class="col-xs col-sm col-lg">
  <div class="card card-underline card-slideToggle">
    <div class="card-head">
      <header><a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a> <i class="glyphicon glyphicon-search" style="width:15px;"></i>Filtros <?php if (!isset($_GET["nofiltro"])) : ?><a href="<?php echo $seccion->url(); ?>"><span style="float:right;margin:10px;">Eliminar filtro <i class="fa fa-remove" style="width:15px;"></i></span></a><?php endif; ?></header>
      </a>
    </div>
    <div class="card-body" style="display: none;">
      <form class="form-horizontal floating-label filtros" role="form" method="get" action="index.php" id="formularioFiltros">
        <div class="col-xs-12 col-sm-12 col-lg-6">
          <input type="hidden" name="option" value="<?php echo $option; ?>">

          <?php
          include(ROOT_URL . "//cliente/Filtro/FiltroCodigo.php");
          include(ROOT_URL . "//cliente/Filtro/FiltroFuncionario.php");
          include(ROOT_URL . "//cliente/Filtro/FiltroEstado.php");
          ?>

          <div class="form-group">
            <div class="col-xs-4 col-sm-4 col-lg-4"></div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <a src="" id="exportarReporte" target="_blank" style="display:none">click me</a>
              <button class="btn btn-biocloud-green filtrar" style="margin-bottom:15px;" name="filtrar"><i class="glyphicon glyphicon-search" style="color:white"></i> Filtrar</button>
              <span class="btn btn-biocloud-green" id="buttonExportar" style="width:100%;margin-bottom:10px;"><i class="glyphicon glyphicon-share" style="color:white"></i> Exportar PDF</span>
              <span class="btn btn-biocloud-green" id="buttonExportarEXCEL" style="float:left;margin-right:4%;width:48%;font-size:11px;"><i class="glyphicon glyphicon-share" style="color:white"></i> Exportar Excel</span>
              <span class="btn btn-biocloud-green" id="buttonExportarCSV" style="width:48%;font-size:11px;"><i class="glyphicon glyphicon-share" style="color:white"></i> Exportar CSV</span>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>