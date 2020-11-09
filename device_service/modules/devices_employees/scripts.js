function modaledit(lector, funcionario) {
  const tempModal = createModal("ModalEdit");
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option,
      action: "editar",
      ajaxenable: "true",
      isModal: true,
      lector,
      funcionario,
    },
    cache: false,
  }).done(function (html) {
    $(tempModal).html(html);
    $(tempModal).modal("show");
  });
}

$(document).ready(function () {
  var editar = $(".editar");
  $(editar).tooltip({ title: "Editar" });
  $("#modalidad").on("change", function () {
    if (this.value == 3) {
      $("#intervaloDias").show();
    } else {
      $("#intervaloDias").hide();
    }
  });
  inicalizarFiltroSocio($("#FiltroFuncionario1"), 1);
  inicalizarFiltroSocio($("#funcionario"));
  inicalizarFiltroSocio($("#responsable"), 1);
  inicalizarFiltroSocio($("#FiltroFuncionarioResponsable"), 1);
  var customConfig = dataTableConfig;
  customConfig["order"] = [
    [5, "desc"],
    [0, "asc"],
  ];
  customConfig["ordering"] = true;
  $("#listado_elementos").DataTable(customConfig);
});
