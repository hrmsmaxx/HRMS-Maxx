<div class="col-xs col-sm col-lg">
  <div class="card card-underline">
    <div class="card-head">
      <header>
        <i class="<?php echo $seccion->icono; ?>" style="margin: 10px 15px 0 0;"></i><?php echo $seccion->nombre; ?>
        <span style="float:right;color:black;margin-right:160px;" class="label"><button type="button" class="btn btn-icon-toggle" onclick="modalEditarMultiple();"><i class="fa fa-pencil"></i> Editar seleccionados</button></span>
      </header>
    </div>
    <div class="card-body" style="padding: 0">
      <?php if (!empty($list)) : ?>
        <table id="listado_elementos" class="table">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Estado</th>
              <?php if ($edit) { ?><th class="no-ordenar"></th><?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php $i = 0;
            foreach ($list as $row) : ?>
              <tr data-funcionario="<?php echo $row->id; ?>" data-status="<?php echo $row->status; ?>" <?php if ($i % 2 == 0) {
                                                                                                          echo ' class="par"';
                                                                                                        } ?>>
                <td><?php echo $row->device_code; ?></td>
                <td><?php echo $row->first_name; ?></td>
                <td><?php echo $row->last_name; ?></td>

                <td><?php
                    if ($row->status == 0) {
                      echo "Deshabilitado";
                    } else {
                      echo "Habilitado";
                    }
                    ?></td>
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

<style>
  .selected,
  .selected td {
    background-color: #0AAEA3 !important;
    opacity: 1 !important;
  }

  .selected:hover,
  .selected td:hover {
    background-color: #0AAEA3 !important;
    opacity: 1 !important;
  }

  .selected:active,
  .selected td:hover {
    background-color: #0AAEA3 !important;
    opacity: 1 !important;
  }
</style>