<?php $list = $seccion->listar(); ?>
<div class="col-xs col-sm col-lg">
  <div class="card card-underline">
    <div class="card-head">
      <header><i class="<?php echo $seccion->icono; ?>" style="margin: 10px 15px 0 0;"></i><?php echo $seccion->nombre; ?><div id="filtrar_listado"><label><i class="fa fa-search"></i><input type="input" placeholder="Buscar..."></label></div>
      </header>
    </div>
    <div class="card-body" style="padding: 0">
      <div class="dataTables_wrapper no-footer">
        <table id="listado_elementos" class="table">
          <thead>
            <?php if (!empty($list)) : ?>
              <tr>
                <th>Usuario</th>
                <th>Nombre y Apellido</th>
                <th>Rol</th>
                <th>Estado</th>
                <?php if ($view) { ?><th class="no-ordenar"></th><?php } ?>
                <?php if ($edit) { ?><th class="no-ordenar"></th><?php } ?>
              </tr>
          </thead>
          <tbody>
            <?php $i = 0;
              foreach ($list as $row) : ?>
              <tr data-status="<?php echo $row->status; ?>" <?php if ($i % 2 == 0) {
                                                              echo ' class="par"';
                                                            } ?>>
                <td><?php echo $row->username; ?></td>
                <td><?php echo $row->first_name . ' ' . $row->last_name; ?></td>
                <td><?php echo $row->role; ?></td>
                <?php if ($row->status) { ?><td><span class="icon activo"><i class="md md-check" style="color: green;"></i></span> Habilitado</td>
                <?php } else { ?><td><span class="icon inactivo"><i class="md md-close" style="color: red;"></i></span> Deshabilitado</td><?php } ?>
                <?php if ($view) { ?><td class="txtcenter"><button type="button" class="btn btn-icon-toggle info" onclick="modalview('<?php echo $row->id; ?>');"><span class="label"><i class="fa fa-info"></i></span></button></td><?php } ?>
                <?php if ($edit) { ?><td class="txtcenter"><button type="button" class="btn btn-icon-toggle editar" onclick="modaledit('<?php echo $row->id; ?>');"><span class="label"><i class="fa fa-pencil"></i></span></button></td><?php } ?>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else : ?>
      <tr>
        <td>
          <h2 style="text-align: center; width: 100%; color: #999; font-weight: normal;">No se han encontrado usuarios</h2>
        </td>
      </tr>
      </tbody>
      </table>
    <?php endif; ?>
    </div>
  </div>
</div>