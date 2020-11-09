function modaledit(iddata) {
  const tempModal = createModal("ModalEdit");
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option,
      action: "editar",
      ajaxenable: "true",
      isModal: true,
      iddata,
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
  var customConfig = dataTableConfig;
  customConfig["order"] = [
    [3, "desc"],
    [0, "asc"],
  ];
  customConfig["ordering"] = true;
  $("#listado_elementos").DataTable(customConfig);
});
