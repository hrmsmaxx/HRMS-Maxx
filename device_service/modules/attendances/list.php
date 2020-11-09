<?php $list = $seccion->listar(); ?>
<div class="col-xs col-sm col-lg">
  <div class="card card-underline">
    <div class="card-head">
      <header>
        <i class="<?php echo $seccion->icono; ?>" style="margin: 10px 15px 0 0;"></i><?php echo $seccion->nombre; ?>
        <div id="filtrar_listado"><label><i class="fa fa-search"></i><input type="input" placeholder="Buscar..."></label></div>
      </header>
    </div>
    <div class="card-body" style="padding: 0">
      <?php if (!empty($list)) : ?>
        <div class="dataTables_wrapper no-footer">
          <table id="listado_elementos" class="table">
            <thead>
              <tr>
                <th>Código</th>
                <th>Funcionario</th>
                <th>Fecha y hora</th>
                <th>Incidencia</th>
                <th>Dispositivo</th>
                <th>Manual</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 0;
              foreach ($list as $row) : ?>
                <tr data-id="<?php echo $row->id; ?>" <?php if ($i % 2 == 0) {
                                                        echo ' class="par"';
                                                      } ?>>
                  <td><?php echo $row->employee_device_code; ?></td>
                  <td data-id="<?php echo $row->id; ?>"><?php echo $row->employee_first_name . ' ' . $row->employee_last_name; ?></td>
                  <td><?php echo $row->date; ?></td>
                  <td><?php
                      if (!empty($row->workcode_name)) {
                        echo $row->workcode_name;
                      } else {
                        echo "<i>Sin incidencia</i>";
                      }
                      ?></td>
                  <td><?php
                      if (empty($row->device)) {
                        echo "<i>Sin dispositivo</i>";
                      } else {
                        echo $row->device;
                      }
                      ?></td>
                  <td><?php
                      if (!empty($row->origin_type)) {
                        echo $row->origin_type;
                      } else {
                        echo "<i>Sin info</i>";
                      }
                      ?></td>
                </tr>
                <?php $i++; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else : ?>
        <h3 style="text-align: center; opacity: 0.6;">No se han encontrado <?php echo mb_strtolower($seccion->nombre, "UTF-8"); ?></h3>
      <?php endif; ?>
    </div>
  </div>
</div>