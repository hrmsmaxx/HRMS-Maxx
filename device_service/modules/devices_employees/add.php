<div class="modal fade" id="AgregarFuncionario" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Agregar funcionario</h4>
      </div>
      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <input type="hidden" name="lector" value="<?php echo $seccion->lector; ?>">
        <div class="modal-body">
          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="email1" class="control-label">Funcionario</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select class="multiselect" name="funcionario" id="FiltroFuncionario1">
                <option value="">Escribe para buscar</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="tope" class="control-label">Tope</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <input type="text" name="tope" id="tope" class="form-control " value="0" placeholder="Tope" autocomplete="off">
              <div class="form-control-line"></div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-3 col-sm-3 col-lg-3">
              <label for="tope" class="control-label">Privilegio</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-6">
              <select class="multiselect" name="privilegio">
                <option value="default">Usuario común</option>
                <option value="moderator">Registrar</option>
                <option value="administrator">Administrador</option>
                <option value="owner">Super administrador</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="agregarFuncionario"><i class="glyphicon glyphicon-ok" style="color:white"></i> Agregar Funcionario</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ExportarFuncionarios" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-biocloud-orange">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Exportar funcionarios</h4>
      </div>
      <form class="form-horizontal" role="form" method="post" action="index.php?option=<?php echo $option; ?>">
        <input type="hidden" name="lector" value="<?php echo $seccion->lector; ?>">
        <div class="modal-body">
          <h3>Se exportaran todos los usuarios del dispositivo <?php
                                                                echo $seccion->infoLector->ip . ":" . $seccion->infoLector->port . " - " . $seccion->infoLector->ubicacion_nombre;
                                                                ?> a un archivo para su posterior carga en el dispositivo</h3>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-biocloud-yellow" name="exportarFuncionarios"><i class="glyphicon glyphicon-ok" style="color:white"></i> Exportar</button>
        </div>
      </form>
    </div>
  </div>
</div>