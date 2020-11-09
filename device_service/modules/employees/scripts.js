function delete_cookie(name) {
  document.cookie = name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}
function get_cookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}
function escanerHuellas() {
  var huellaActual = -1;
  $(".escanearHuella").on("click", function () {
    $(this).hide();
    var contenedor = $(this).parents(".escanerDeHuella");
    contenedor.find(".huellaResult").show();
    delete_cookie("huella_id");
    huellaActual = get_cookie("huella_id");
    contenedor.find(".labelHuella").text("Huella (Activado)");
    setInterval(function () {
      var tmpHuella = get_cookie("huella_id");
      if (tmpHuella != huellaActual) {
        contenedor.find(".Huella").val(tmpHuella);
        contenedor
          .find(".huellaResult")
          .text("Huella escaneada, id: " + tmpHuella);
      }
    }, 100);
  });
}

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
    escanerHuellas();
    inicalizarFiltroSocio($("[name='id_responsable']"), 1);
    initFormFuncionario("#rootwizard2-editar");
  });
}

function modalEditarMultiple() {
  const tempModal = createModal("ModalEditMultiple");
  let seleccionados = [];
  $("#listado_elementos .selected").each(function (index) {
    seleccionados.push(parseInt($(this).data("funcionario")));
  });
  if (seleccionados.length > 0) {
    iddata = JSON.stringify(seleccionados);
    opeajax = $.ajax({
      type: "GET",
      url: "index.php",
      data: {
        option,
        action: "editarMultiple",
        ajaxenable: "true",
        isModal: true,
        iddata,
      },
      cache: false,
    }).done(function (html) {
      $(tempModal).html(html);
      $(tempModal).modal("show");
      escanerHuellas();
      inicalizarFiltroSocio($("[name='id_responsable']"), 1);
      initFormFuncionario("#rootwizard2-editar");
    });
  }
}

function modalreporte(iddata) {
  const tempModal = createModal("ModalReporte");
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option,
      action: "reporteEmail",
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

function modaljerarquia(iddata) {
  window.location.href =
    "index.php?option=funcionarios-jerarquia&funcionario=" + iddata;
}
function modalcalendario(iddata) {
  window.location.href =
    "index.php?option=funcionarios-calendario&funcionario=" + iddata;
}

$(document).ready(function () {
  escanerHuellas();
  var editar = $(".editar"),
    reporteEmail = $(".reporteEmail"),
    calendario = $(".calendario"),
    jerarquia = $(".jerarquia");

  $(editar).tooltip({ title: "Editar" });
  $(reporteEmail).tooltip({ title: "Enviar emails" });
  $(calendario).tooltip({ title: "Calendario" });
  $(jerarquia).tooltip({ title: "Jerarquia de funcionarios" });

  inicalizarFiltroSocio($("[name='id_responsable']"), 1);
  $("select.select").multiselect({ numberDisplayed: 7 });
  initFormFuncionario("#rootwizard2");
  var customConfig = dataTableConfig;
  customConfig["order"] = [
    [3, "desc"],
    [0, "asc"],
  ];
  customConfig["ordering"] = true;
  $("#listado_elementos").DataTable(customConfig);

  $("#listado_elementos tbody").on("click", "tr", function () {
    $(this).toggleClass("selected");
  });
});

function initFormFuncionario(id_container) {
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
