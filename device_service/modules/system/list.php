<?php
$list = $seccion->entidades();
$cantidadFuncionarios = $list["funcionario"]->cantidad;
$cantidadMarcas = $list["marca"]->cantidad;
$cantidadDocumentos = $list["funcionario_documento"]->cantidad;
$cantidadDispositivos = $list["lector"]->cantidad;
?>

<div class="row">
  <!-- BEGIN ALERT - REVENUE -->
  <div class="col-md-3 col-sm-6">
    <div class="card">
      <div class="card-body no-padding">
        <div class="alert alert-callout alert-info no-margin">
          <strong class="text-xl"><?php echo number_format($cantidadFuncionarios, 0, ',', '.'); ?></strong><br>
          <span class="opacity-50">Funcionarios</span>
          <div class="stick-bottom-left-right">
            <div class="height-2 sparkline-revenue" data-line-color="#bdc1c1"><canvas width="385" height="80" style="display: inline-block; width: 385px; height: 80px; vertical-align: top;"></canvas></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END ALERT - REVENUE -->

  <!-- BEGIN ALERT - VISITS -->
  <div class="col-md-3 col-sm-6">
    <div class="card">
      <div class="card-body no-padding">
        <div class="alert alert-callout alert-warning no-margin">
          <strong class="text-xl"><?php echo number_format($cantidadMarcas, 0, ',', '.'); ?></strong><br>
          <span class="opacity-50">Marcas</span>
          <div class="stick-bottom-right">
            <div class="height-1 sparkline-visits" data-bar-color="#e5e6e6"><canvas width="376" height="40" style="display: inline-block; width: 376px; height: 40px; vertical-align: top;"></canvas></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END ALERT - VISITS -->

  <!-- BEGIN ALERT - BOUNCE RATES -->
  <div class="col-md-3 col-sm-6">
    <div class="card">
      <div class="card-body no-padding">
        <div class="alert alert-callout alert-danger no-margin">
          <h1 class="pull-right"><i class="glyphicon glyphicon-folder-open"></i></h1>
          <strong class="text-xl"><?php echo number_format($cantidadDocumentos, 0, ',', '.'); ?></strong><br>
          <span class="opacity-50">Documentos</span>
          <div class="stick-bottom-left-right">
            <div class="progress progress-hairline no-margin">
              <div class="progress-bar progress-bar-danger" style="width:43%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END ALERT - BOUNCE RATES -->

  <!-- BEGIN ALERT - TIME ON SITE -->
  <div class="col-md-3 col-sm-6">
    <div class="card">
      <div class="card-body no-padding">
        <div class="alert alert-callout alert-success no-margin">
          <h1 class="pull-right"><i class="glyphicon glyphicon-phone"></i></h1>
          <strong class="text-xl"><?php echo number_format($cantidadDispositivos, 0, ',', '.'); ?></strong><br>
          <span class="opacity-50">Dispositivos</span>
        </div>
      </div>
    </div>
  </div>
  <!-- END ALERT - TIME ON SITE -->
</div>

<script>
  var points = [20, 10, 25, 15, 30, 20, 30, 10, 15, 10, 20, 25, 25, 15, 20, 25, 10, 67, 10, 20, 25, 15, 25, 97, 10, 30, 10, 38, 20, 15, 82, 44, 20, 25, 20, 10, 20, 38];

  materialadmin.App.callOnResize(function() {
    var options = $('.sparkline-revenue').data();
    options.type = 'line';
    options.width = '100%';
    options.height = $('.sparkline-revenue').height() + 'px';
    options.fillColor = false;
    $('.sparkline-revenue').sparkline(points, options);
  });

  materialadmin.App.callOnResize(function() {
    var parent = $('.sparkline-visits').closest('.card-body');
    var barWidth = 6;
    var spacing = (parent.width() - (points.length * barWidth)) / points.length;

    var options = $('.sparkline-visits').data();
    options.type = 'bar';
    options.barWidth = barWidth;
    options.barSpacing = spacing;
    options.height = $('.sparkline-visits').height() + 'px';
    options.fillColor = false;
    $('.sparkline-visits').sparkline(points, options);
  });
</script>

<div class="col-xs col-sm col-lg-12">
  <div class="card">
    <?php
    $limite_funcionarios = 0;

    function random_color_part()
    {
      return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    function random_color()
    {
      return random_color_part() . random_color_part() . random_color_part();
    }

    $colors = array();
    if (!empty($list)) {
      foreach ($list as $value) {
        array_push($colors, "" . random_color());
      }
    }
    $colors = implode(",", $colors);
    $espacio = 2;
    if (!empty($limite_funcionarios)) {
      $espacio = 3;
    ?>
      <div class="col-xs col-sm col-lg-<?php echo 12 / $espacio; ?> text-center">
        <center><span style="font-weight:bold;font-size:21px;">Funcionarios</span></center>
        <div id="graficaAsistencia" class="height-8" data-colors="#13bd9b,#3598d9"></div>
      </div>
      <script>
        let data = [];
        data.push({
          value: <?php echo $cantidadFuncionarios; ?>,
          label: "Creados",
          formatted: <?php echo number_format($cantidadFuncionarios, 0, ',', '.'); ?>
        });
        data.push({
          value: <?php echo $limite_funcionarios; ?>,
          label: "Restantes",
          formatted: <?php echo number_format($limite_funcionarios, 0, ',', '.'); ?>
        });
        Morris.Donut({
          element: 'graficaAsistencia',
          data: data,
          colors: $('#graficaAsistencia').data('colors').split(','),
          formatter: function(x, data) {
            return data.formatted;
          }
        });
      </script>
    <?php
    }
    ?>
    <div class="col-xs col-sm col-lg-<?php echo 12 / $espacio; ?>  text-center">
      <center><span style="font-weight:bold;font-size:21px;">Cantidades</span></center>
      <div id="graficaCantidad" class="height-8" data-colors="<?php echo $colors; ?>"></div>
    </div>

    <div class="col-xs col-sm col-lg-<?php echo 12 / $espacio; ?>  text-center">
      <center><span style="font-weight:bold;font-size:21px;">Espacio MB</span></center>
      <div id="graficaEspacio" class="height-8" data-colors="<?php echo $colors; ?>"></div>
    </div>
  </div>
</div>

<script>
  let dataCantidad = [];
  let dataCantidadRegistros = [];
  let dataEspacio = [];
  let dataEspacioRegistros = [];
  <?php if (!empty($list)) {
    foreach ($list as $key => $value) {
      $nombre = $value->nombre;
      if (strlen($nombre) > 15) {
        $nombre = substr($nombre, 0, 15) . "...";
      }
      $numero1 = $value->cantidad;
      if ($numero1 < 0) {
        $numero1 = 0;
      }
      echo 'dataCantidad.push({
       value: "' . $numero1 . '",
       label: "' . $value->nombre . '",
       formatted: "' . number_format($numero1, 0, ',', '.') . '"
     });';
      $numero2 = $value->registros;
      if ($numero2 < 0) {
        $numero2 = 0;
      }
      echo 'dataCantidad.push({
       value: "' . $numero2 . '",
       label: "Registros ' . $value->nombre . '",
       formatted: "' . number_format($numero2, 0, ',', '.') . '"
     });';

      $numero3 = $value->espacio;
      if ($numero3 < 0) {
        $numero3 = 0;
      }
      echo 'dataEspacio.push({
       value: "' . $numero3 . '",
       label: "' . $value->nombre . '",
       formatted: "' . $numero3 . '"
     });';
      $numero4 = $value->espacio_registros;
      if ($numero4 < 0) {
        $numero4 = 0;
      }
      echo 'dataEspacio.push({
       value: "' . $numero4 . '",
       label: "Registros ' . $value->nombre . '",
       formatted: "' . $numero4 . '"
     });';
    }
  }
  ?>
  Morris.Donut({
    element: 'graficaCantidad',
    data: dataCantidad,
    colors: $('#graficaCantidad').data('colors').split(','),
    formatter: function(x, data) {
      return data.formatted;
    }
  });
  Morris.Donut({
    element: 'graficaEspacio',
    data: dataEspacio,
    colors: $('#graficaEspacio').data('colors').split(','),
    formatter: function(x, data) {
      return data.formatted;
    }
  });
</script>

<div class="col-xs col-sm col-lg-12">
  <div class="card card-underline">
    <div class="card-head">
      <header>
        <i class="<?php echo $seccion->icono; ?>" style="margin: 10px 15px 0 0;"></i><?php echo $seccion->nombre; ?>
      </header>
    </div>
    <div class="card-body" style="padding: 0">
      <div class="dataTables_wrapper no-footer">
        <table id="listado_elementos" class="table">
          <thead>
            <tr>
              <th>Entidad</th>
              <th>Cantidad</th>
              <th>Espacio ocupado (MB)</th>
              <th>Registros</th>
              <th>Espacio ocupado de registros (MB)</th>
            </tr>
          </thead>
          <tbody>
            <?php
            usort($list, function ($item1, $item2) {
              return $item2->cantidad <=> $item1->cantidad;
            });
            array_push($list, $seccion->totales);
            $i = 0;
            foreach ($list as $row) : ?>
              <tr <?php if ($i % 2 == 0) {
                    echo ' class="par"';
                  } ?>>
                <td><?php echo $row->nombre; ?></td>
                <td><?php echo number_format($row->cantidad, 0, ',', '.'); ?></td>
                <td><?php echo $row->espacio; ?></td>
                <td><?php
                    if ($row->registros == -1) {
                      echo "-";
                    } else {
                      echo number_format($row->registros, 0, ',', '.');
                    } ?></td>
                <td><?php
                    if ($row->espacio_registros == -1) {
                      echo "-";
                    } else {
                      echo $row->espacio_registros;
                    } ?></td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  var customConfig = dataTableConfig;
  customConfig["ordering"] = false;
  $('#listado_elementos').DataTable(customConfig);
</script>

<style>
  #listado_elementos tr:last-child {
    font-weight: bold;
  }
</style>