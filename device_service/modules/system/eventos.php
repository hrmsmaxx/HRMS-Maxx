<style>
  .readLess {
    height: 20px;
    max-height: 20px;
  }

  .readMore {
    height: 200px;
  }
</style>

<div class="col-xs col-sm col-lg">
  <div class="card">
    <div class="alert alert-callout alert-success no-margin">
      <div class="row">
        <div class="col-xs col-sm col-lg">
          <div class="card-head">
            <header><b>Registro de eventos dispositivos - <a href="index.php?option=reportes&reporte=-9">Ir al reporte completo</a></b></header>
          </div>
          <!--end .card-head -->
        </div>
        <!--end .col -->
        <div class="dataTables_wrapper no-footer table-responsive">
          <table class="table table-striped table-hover" style="text-align:center">
            <thead>
              <tr>
                <th style="text-align:center">Fecha</th>
                <th style="text-align:center">Dispositivo</th>
                <th style="text-align:center">Evento</th>
                <th style="text-align:center">Mensaje</th>
                <th style="text-align:center">Terminado</th>
                <th style="text-align:center">Manual</th>
                <th style="text-align:center">Usuario</th>
              </tr>
            </thead>
            <tbody id="listado_eventos">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function createTd(parent, text) {
    var td = document.createElement("td");
    if (text) {
      if (text.length > 100) {
        td.textContent = text.substring(0, 100) + "...";
      } else {
        td.textContent = text;
      }
    } else {
      td.textContent = "";
    }
    td.setAttribute("class", "readLess");
    parent.appendChild(td);
  }

  function cargarTablaEventos() {
    $.get("server/routes/dispositivo/evento/listar.php", function(data, status) {
      if (data) {
        $("#listado_eventos")[0].innerHTML = "";
        var i = 0;
        for (var d in data) {
          console.log(data);
          var tr = document.createElement("tr");
          if (i % 2 === 0) {
            tr.setAttribute("class", "par");
          }
          $("#listado_eventos")[0].appendChild(tr);
          var date = new Date(parseInt(data[d]["fecha"]) * 1000);
          createTd(tr, ("" + date.getDate()).padStart(2, 0) + "/" + ("" + parseInt(date.getMonth() + 1)).padStart(2, 0) + "/" + date.getFullYear() + " " + ("" + date.getHours()).padStart(2, 0) + ":" + ("" + date.getMinutes()).padStart(2, 0) + ":" + ("" + date.getSeconds()).padStart(2, 0));
          createTd(tr, data[d]["dispositivo"]);
          createTd(tr, data[d]["evento"]);
          createTd(tr, data[d]["mensaje"]);
          createTd(tr, ((data[d]["terminado"] == "1") ? 'Si' : 'No'));
          createTd(tr, ((data[d]["manual"] == "1") ? 'Si' : 'No'));
          createTd(tr, data[d]["usuario"]);
          i++;
        }
      }
    });
  }
  cargarTablaEventos();
  setInterval(cargarTablaEventos, 10000);
</script>