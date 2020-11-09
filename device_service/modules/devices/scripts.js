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
    $("input.hora").inputmask("h:s", { placeholder: "hh:mm" });
    $("#ModalidadConsumoEditar").on("change", function () {
      if ($(this).val() == "time") {
        $("#contenedorHoraEditar").show();
        $("#contenedorIntervaloEditar").hide();
      } else if ($(this).val() == "interval") {
        $("#contenedorIntervaloEditar").show();
        $("#contenedorHoraEditar").hide();
      } else {
        $("#contenedorHoraEditar").hide();
        $("#contenedorIntervaloEditar").hide();
      }
    });
    $("#ModalidadActualizacionEditar").on("change", function () {
      if ($(this).val() == "time") {
        $("#contenedorHoraActualizacionEditar").show();
        $("#contenedorIntervaloActualizacionEditar").hide();
      } else if ($(this).val() == "interval") {
        $("#contenedorIntervaloActualizacionEditar").show();
        $("#contenedorHoraActualizacionEditar").hide();
      } else {
        $("#contenedorHoraActualizacionEditar").hide();
        $("#contenedorIntervaloActualizacionEditar").hide();
      }
    });
    $("#ModalidadTiempoEditar").on("change", function () {
      if ($(this).val() == "time") {
        $("#contenedorHoraTiempoEditar").show();
        $("#contenedorIntervaloTiempoEditar").hide();
      } else if ($(this).val() == "interval") {
        $("#contenedorHoraTiempoEditar").hide();
        $("#contenedorIntervaloTiempoEditar").show();
      } else {
        $("#contenedorHoraTiempoEditar").hide();
        $("#contenedorIntervaloTiempoEditar").hide();
      }
    });
    initForm("#rootwizard2-editar");
  });
}

function modalaction(iddata) {
  const tempModal = createModal("ModalAction");
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option,
      action: "action",
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

function modalfuncionarios(lector) {
  window.location.href =
    "index.php?option=devices_employees&nofiltro=&lector=" + lector;
}

$(document).ready(function () {
  var editar = $(".editar"),
    accion = $(".accion"),
    calendario = $(".calendario"),
    funcionarios = $(".funcionarios");

  $(editar).tooltip({ title: "Editar" });
  $(accion).tooltip({ title: "Acción" });
  $(funcionarios).tooltip({ title: "Administrar funcionarios" });
  $(calendario).tooltip({ title: "Calendario" });
  $("input.hora").inputmask("h:s", { placeholder: "hh:mm" });

  $("#ModalidadConsumo").on("change", function () {
    if ($(this).val() == "1") {
      $("#contenedorHora").show();
      $("#contenedorIntervalo").hide();
    } else if ($(this).val() == "2") {
      $("#contenedorIntervalo").show();
      $("#contenedorHora").hide();
    } else {
      $("#contenedorHora").hide();
      $("#contenedorIntervalo").hide();
    }
  });

  $("#ModalidadActualizacion").on("change", function () {
    if ($(this).val() == "1") {
      $("#contenedorHoraActualizacion").show();
      $("#contenedorIntervaloActualizacion").hide();
    } else if ($(this).val() == "2") {
      $("#contenedorIntervaloActualizacion").show();
      $("#contenedorHoraActualizacion").hide();
    } else {
      $("#contenedorHoraActualizacion").hide();
      $("#contenedorIntervaloActualizacion").hide();
    }
  });

  $("#ModalidadTiempo").on("change", function () {
    if ($(this).val() == "1") {
      $("#contenedorHoraTiempo").show();
      $("#contenedorIntervaloTiempo").hide();
    } else if ($(this).val() == "2") {
      $("#contenedorIntervaloTiempo").show();
      $("#contenedorHoraTiempo").hide();
    } else {
      $("#contenedorHoraTiempo").hide();
      $("#contenedorIntervaloTiempo").hide();
    }
  });
  var customConfig = dataTableConfig;
  customConfig["order"] = [
    [5, "desc"],
    [0, "asc"],
  ];
  customConfig["ordering"] = true;
  $("#listado_elementos").DataTable(customConfig);
  initForm("#rootwizard2");
});

function initForm(id_container) {
  (function (namespace, $) {
    "use strict";
    var FormFuncionario = function () {
      // Create reference to this instance
      var o = this;
      // Initialize app when document is ready
      $(document).ready(function () {
        o.initialize();
      });
    };
    var p = FormFuncionario.prototype;

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
      this._initWizard1();
    };

    // =========================================================================
    // WIZARD 1
    // =========================================================================

    p._initWizard1 = function () {
      var o = this;
      $(id_container).bootstrapWizard({
        onTabShow: function (tab, navigation, index) {
          o._handleTabShow(tab, navigation, index, $(id_container));
        },
      });
    };

    p._handleTabShow = function (tab, navigation, index, wizard) {
      var total = navigation.find("li").length;
      var current = index + 0;
      var percent = (current / (total - 1)) * 100;
      var percentWidth = 100 - 100 / total + "%";

      navigation.find("li").removeClass("done");
      navigation.find("li.active").prevAll().addClass("done");

      wizard.find(".progress-bar").css({ width: percent + "%" });
      $(".form-wizard-horizontal")
        .find(".progress")
        .css({ width: percentWidth });
    };

    // =========================================================================
    namespace.FormFuncionario = new FormFuncionario();
  })(this.materialadmin, jQuery); // pass in (namespace, jQuery):
}
