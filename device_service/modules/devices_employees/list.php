<div class="col-xs col-sm col-lg">
  <div class="card card-underline">
    <div class="card-head">
      <header>
        <i class="<?php echo $seccion->icono; ?>" style="margin: 10px 15px 0 0;"></i><?php echo $seccion->nombre; ?>
      </header>
    </div>
    <div class="card-body" style="padding: 0">
      <?php if (!empty($seccion->list)) : ?>
        <div class="dataTables_wrapper no-footer table-responsive">
          <table id="listado_elementos" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Privilegio</th>
                <th>Tope de accesos</th>
                <th>Estado en el lector</th>
                <th>Estado real</th>
                <?php if ($edit) { ?><th class="no-ordenar"></th><?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php $i = 0;
              foreach ($seccion->list as $row) : ?>
                <tr data-status="<?php echo $row->activo; ?>" <?php if ($i % 2 == 0) {
                                                                echo ' class="par"';
                                                              } ?>>
                  <td><?php echo $row->funcionario_codigo; ?></td>
                  <td><?php echo $row->funcionario_nombre . " " . $row->funcionario_apellido; ?></td>
                  <td><?php
                      switch ($row->privilege_type) {
                        case "moderator":
                          echo "Registrar";
                          break;
                        case "administrator":
                          echo "Administrador";
                          break;
                        case "owner":
                          echo "Super administrador";
                          break;
                        case "default":
                          echo "Usuario común";
                      }
                      ?></td>
                  <td><?php echo $row->tope; ?></td>
                  <td><?php
                      if ($row->activo == 0) {
                        echo "Deshabilitado";
                      } else {
                        echo "Habilitado";
                      }
                      ?></td>
                  <td><?php
                      if ($row->funcionario_activo == 0) {
                        echo "Deshabilitado";
                      } else {
                        echo "Habilitado";
                      }
                      ?></td>
                  <?php if ($edit) { ?><td><button type="button" class="btn btn-icon-toggle editar" onclick="modaledit('<?php echo $row->id_lector; ?>','<?php echo $row->id_funcionario; ?>');"><span class="label"><i class="fa fa-pencil"></i></span></button></td><?php } ?>
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