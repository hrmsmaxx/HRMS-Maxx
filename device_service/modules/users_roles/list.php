<?php

$list = $seccion->listar();

?>

<div class="col-xs col-sm col-lg">
  <div class="card card-underline">
    <div class="card-head">
      <header><i class="<?php echo $seccion->icono; ?>"></i><?php echo $seccion->nombre; ?></header>
      <div class="tools">
        <div class="btn-group">
          <a class="btn btn-icon-toggle btn-collapse"><i class="fa fa-angle-down"></i></a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <table id="listado" class="table table-striped table-hover">
        <thead>
          <?php if (!empty($list)) : ?>
            <tr>
              <th>Rol</th>
              <th class="no-ordenar"></th>
            </tr>
        </thead>
        <tbody>
          <?php foreach ($list as $row) : ?>
            <tr>
              <td><?php echo $row->name; ?></td>
              <td class="txtcenter"><button type="button" class="btn btn-icon-toggle editar" onclick="modaledit('<?php echo $row->id; ?>');"><span class="label"><i class="fa fa-pencil"></i></span></button></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
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
</div>



<script>
  function modaledit(iddata) {
    const tempModal = createModal("ModalEdit");
    opeajax = $.ajax({
      type: "GET",
      url: "index.php",
      data: {
        option: "<?php echo $option; ?>",
        action: "edit",
        ajaxenable: "true",
        iddata: iddata
      },
      cache: false
    }).done(function(html) {
      $(tempModal).html(html);
      $("#menuEdit").multiselect({
        maxHeight: 350
      });
      materialadmin.AppForm._initRadioAndCheckbox();
      $(tempModal).modal('show');
    });
  };

  $(document).ready(function() {
    $('#listado_elementos').DataTable(dataTableConfig);
    $('.dataTables_length select').multiselect({
      maxHeight: 350
    });
  });

  function cargarOpcionesEditar() {
    var opciones = [];
    $('#listadoModulosEdit .checkbox:checked').each(function() {
      var m = new Object();
      m.o = $(this).data('o');
      m.modulo = $(this).data('modulo');
      opciones.push(m);
    });

    var opcionesJson = JSON.stringify(opciones);
    $('#opcionesEdit').val(opcionesJson);

  }
</script>