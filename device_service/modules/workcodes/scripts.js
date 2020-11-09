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

  $("#habilitarAgregarCodigo").on("change", function () {
    let check = this.checked;
    if (check) {
      $("#inputAgregarCodigo").show();
    } else {
      $("#inputAgregarCodigo").hide();
      $("#inputAgregarCodigo input").val(0);
    }
  });

  $("#habilitarAgregarVeces").on("change", function () {
    let check = this.checked;
    if (check) {
      $("#inputAgregarVeces").show();
    } else {
      $("#inputAgregarVeces").hide();
      $("#inputAgregarVeces input").val(0);
    }
  });
  var customConfig = dataTableConfig;
  customConfig["order"] = [
    [2, "desc"],
    [0, "asc"],
  ];
  customConfig["ordering"] = true;
  $("#listado_elementos").DataTable(customConfig);
});
