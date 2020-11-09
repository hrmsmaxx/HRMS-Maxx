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
                <th>Ip</th>
                <th>Puerto</th>
                <th>Ubicacion</th>
                <th>Funcionarios para actualizar</th>
                <th>Estado</th>
                <th class="no-ordenar"></th>
                <?php if ($edit) { ?><th class="no-ordenar"></th><?php } ?>
                <?php if ($edit) { ?><th class="no-ordenar"></th><?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php $i = 0;
              foreach ($list as $row) : ?>
                <tr data-status="<?php echo $row->status; ?>" <?php if ($i % 2 == 0) {
                                                                echo ' class="par"';
                                                              } ?>>
                  <td><?php echo $row->ip; ?></td>
                  <td><?php echo $row->port; ?></td>
                  <td><?php echo $row->location_name; ?></td>
                  <td><?php
                      if (!empty($row->colaActualizacion)) {
                        echo $row->updateQueue;
                      } else {
                        echo "0";
                      } ?></td>
                  <td><?php
                      if ($row->status == 0) {
                        echo "Deshabilitado";
                      } else {
                        echo "Habilitado";
                      }
                      ?></td>
                  <td><button type="button" class="btn btn-icon-toggle funcionarios" onclick="modalfuncionarios('<?php echo $row->id; ?>');"><span style="color:#585858;font-size:15px;" class="md-account-child"></span></button></td>
                  <?php if ($edit) { ?><td><button type="button" class="btn btn-icon-toggle accion" onclick="modalaction('<?php echo $row->id; ?>');"><span style="color:#585858;font-size:14px;margin-top:-5px;" class="glyphicon glyphicon-th"></span></button></td><?php } ?>
                  <?php if ($edit) { ?><td><button type="button" class="btn btn-icon-toggle editar" onclick="modaledit('<?php echo $row->id; ?>');"><span class="label"><i class="fa fa-pencil"></i></span></button></td><?php } ?>
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