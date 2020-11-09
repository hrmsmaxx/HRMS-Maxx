function modaledit(iddata) {
  const tempModal = createModal("ModalEdit");
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: { option, action: "edit", ajaxenable: "true", isModal: true, iddata },
    cache: false,
  }).done(function (html) {
    $(tempModal).html(html);
    inicalizarFiltroSocio($("#FiltroFuncionarioEditar"));
    $(tempModal).modal("show");
  });
}

function modalview(iddata) {
  const tempModal = createModal("ModalView");
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: { option, action: "view", ajaxenable: "true", iddata },
    cache: false,
  }).done(function (html) {
    $(tempModal).html(html);
    $(tempModal).modal("show");
  });
}

$(document).ready(function () {
  var editar = $(".editar");
  $(editar).tooltip({ title: "Editar" });
  inicalizarFiltroSocio($("#FiltroFuncionario"));
  var customConfig = dataTableConfig;
  //customConfig["order"]=[[ 3, "desc" ],[ 0, "asc" ]];
  //customConfig["ordering"]=true;
  $("#listado_elementos").DataTable(customConfig);
});

$(function () {
  var input = $("#filtrar_listado input");
  var typingTimer;
  var doneTypingInterval = 400;

  //on keyup, start the countdown
  input.on("keyup", function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(buscarEnTabla, doneTypingInterval);
  });
});
