<?php
$data = $seccion->cargar($inicio->id);
?>

<div class="card-body">
  <form id="formOpciones" class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>" enctype="multipart/form-data">
    <input name="formOpciones" type="hidden" value="1">
    <div class="panel-group" id="accordion-fe">
      <div class="card panel">
        <div class="card-head" data-toggle="collapse" data-parent="#accordion-fe" data-target="#accordion-fe-1">
          <header>
            <h3 style="color: #13bd9b;"><a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>Configuracion general</h3>
          </header>
        </div>
        <div id="accordion-fe-1" class="collapse in">
          <div class="card-body">
            <?php $inicio->agregarCampoForm('Nombre empresa', $inicio->opciones['generales']['nombre_empresa']['valor']); ?>
            <div class="form-group">
              <div class="col-xs-3 col-sm-3 col-lg-3">
                <label for="Razon-social" class="control-label">Razón social</label>
              </div>
              <div class="col-xs-9 col-sm-9 col-lg-6">
                <input type="text" name="Razon-social" id="Razon-social" class="form-control " value="<?php echo $inicio->opciones['generales']['razon_social']['valor']; ?>" placeholder="Razón social" autocomplete="off">
                <div class="form-control-line"></div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-3 col-sm-3 col-lg-3">
                <label for="Direccion" class="control-label">Dirección</label>
              </div>
              <div class="col-xs-9 col-sm-9 col-lg-6">
                <input type="text" name="Direccion" id="Direccion" class="form-control " value="<?php echo $inicio->opciones['generales']['direccion']['valor']; ?>" placeholder="Dirección" autocomplete="off">
                <div class="form-control-line"></div>
              </div>
            </div>
            <?php $inicio->agregarCampoForm('Ciudad', $inicio->opciones['generales']['ciudad']['valor']); ?>
            <?php $inicio->agregarCampoForm('Pais', $inicio->opciones['generales']['pais']['valor']); ?>
            <div class="form-group">
              <div class="col-xs-3 col-sm-3 col-lg-3">
                <label for="Rut" class="control-label">RUT</label>
              </div>
              <div class="col-xs-9 col-sm-9 col-lg-6">
                <input type="text" name="Rut" id="Rut" class="form-control " value="<?php echo $inicio->opciones['generales']['rut']['valor']; ?>" placeholder="RUT" autocomplete="off">
                <div class="form-control-line"></div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-3 col-sm-3 col-lg-3">
                <label for="Telefono" class="control-label">Teléfono</label>
              </div>
              <div class="col-xs-9 col-sm-9 col-lg-6">
                <input type="text" name="Telefono" id="Telefono" class="form-control " value="<?php echo $inicio->opciones['generales']['telefono']['valor']; ?>" placeholder="Teléfono" autocomplete="off">
                <div class="form-control-line"></div>
              </div>
            </div>
            <?php $inicio->agregarCampoForm('Email', $inicio->opciones['generales']['email']['valor']); ?>
            <?php $inicio->agregarCampoForm('Fax', $inicio->opciones['generales']['fax']['valor']); ?>
            <?php $inicio->agregarCampoForm('Web', $inicio->opciones['generales']['web']['valor']); ?>
            <div class="form-group">
              <div class="col-xs-3 col-sm-3 col-lg-3">
                <label for="Alerta-dias-liquidacion" class="control-label">Cierre de marcas</label>
              </div>
              <div class="col-xs-9 col-sm-9 col-lg-6">
                <select name="cierreMarcas" id="cierreMarcas" class="multiselect">
                  <option value="">Seleccionar</option>
                  <option value="1" <?php if (!empty($inicio->opciones['generales']['cierreMarcas']['valor']) && $inicio->opciones['generales']['cierreMarcas']['valor'] == 1) {
                                      echo "selected";
                                    } ?>>Diario</option>
                  <option value="2" <?php if (!empty($inicio->opciones['generales']['cierreMarcas']['valor']) && $inicio->opciones['generales']['cierreMarcas']['valor'] == 2) {
                                      echo "selected";
                                    } ?>>Semanal</option>
                  <option value="3" <?php if (!empty($inicio->opciones['generales']['cierreMarcas']['valor']) && $inicio->opciones['generales']['cierreMarcas']['valor'] == 3) {
                                      echo "selected";
                                    } ?>>Quincena</option>
                  <option value="4" <?php if (!empty($inicio->opciones['generales']['cierreMarcas']['valor']) && $inicio->opciones['generales']['cierreMarcas']['valor'] == 4) {
                                      echo "selected";
                                    } ?>>Mensual</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-3 col-sm-3 col-lg-3">
                <label for="email1" class="control-label">Fecha liquidación</label>
              </div>
              <div class="col-xs-9 col-sm-9 col-lg-6">
                <input type="text" value="<?php
                                          if (!empty($inicio->opciones['generales']['fecha_liquidacion']['valor'])) {
                                            echo date("d/m/Y", $inicio->opciones['generales']['fecha_liquidacion']['valor']);
                                          } ?>" name="fecha_liquidacion" autocomplete="off" class="form-control fecha_hora">
                <div class="form-control-line"></div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-3 col-sm-3 col-lg-3">
                <label for="Alerta-dias-liquidacion" class="control-label">Alerta días liquidación</label>
              </div>
              <div class="col-xs-9 col-sm-9 col-lg-6">
                <input type="text" name="Alerta-dias-liquidacion" id="Alerta-dias-liquidacion" class="form-control " value="<?php echo $inicio->opciones['generales']['alerta_liquidacion']['valor']; ?>" placeholder="Alerta días liquidación" autocomplete="off">
                <div class="form-control-line"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="mensaje" class="col-md-offset-1 col-md-10"></div>
    <button type="button" id="submitForm" class="btn btn-biocloud-yellow" name="editar" style="margin: 5px 0 0 25%;">Guardar cambios</button>
  </form>
</div>

<style type="text/css">
  header h3 {
    cursor: pointer;
  }
</style>

<script>
  $('input.fecha_hora').datetimepicker({
    minView: 2,
    format: 'dd/mm/yyyy',
    language: 'es',
    autoclose: 1
  });
</script>