const traduccionLenguajeTablas = {
  sSearch: "Búsqueda rápida:",
  sEmptyTable: "No hay datos disponibles",
  sInfo: "Mostrando _TOTAL_ datos, actualmente de _START_ a _END_",
  oPaginate: {
    sNext: "Siguiente",
    sLast: "Última",
    sFirst: "Primera",
    sPrevious: "Anterior",
  },
};

$(function () {
  $.fn.datepicker.dates["es"] = {
    days: [
      "Domingo",
      "Lunes",
      "Martes",
      "Miércoles",
      "Jueves",
      "Viernes",
      "Sábado",
      "Domingo",
    ],
    daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
    daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
    months: [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Septiembre",
      "Octubre",
      "Noviembre",
      "Diciembre",
    ],
    monthsShort: [
      "Ene",
      "Feb",
      "Mar",
      "Abr",
      "May",
      "Jun",
      "Jul",
      "Ago",
      "Sep",
      "Oct",
      "Nov",
      "Dic",
    ],
  };

  $.fn.datepicker.defaults.format = "dd/mm/yyyy";
  $.fn.datepicker.defaults.autoclose = true;
  $.fn.datepicker.defaults.language = "es";

  $.extend($.fn.dataTable.defaults, {
    dom: "lCfrtip",
    order: [],
    aLengthMenu: [
      [25, 50, 100, 300, -1],
      [25, 50, 100, 300, "Todos"],
    ],
    iDisplayLength: -1,
    language: {
      lengthMenu: "_MENU_ filas por p&aacute;gina",
      zeroRecords: "No se han encontrado resultados",
      info: "Mostrando página _PAGE_ de _PAGES_",
      infoEmpty: "Sin resultados encontrados",
      infoFiltered: "(resultados de un total de _MAX_ registros)",
      search: '<i class="fa fa-search"></i>',
      paginate: {
        previous: '<i class="fa fa-angle-left"></i>',
        next: '<i class="fa fa-angle-right"></i>',
      },
    },
    aoColumnDefs: [
      {
        bSortable: false,
        aTargets: ["no-ordenar"],
      },
      {
        type: "fecha-hora",
        aTargets: ["fecha-hora"],
      },
      {
        type: "numero",
        aTargets: ["numero"],
      },
      {
        type: "fecha",
        width: "100px",
        targets: ["fecha"],
      },
      {
        type: "num-documento",
        targets: ["num-documento"],
      },
      {
        width: "40px",
        targets: ["no-ordenar"],
      },
    ],
  });

  $(".modal-content").resize(function () {
    var altura = $(".modal-content").height() + 62;
    $(".modal-backdrop").css("height", altura + "px");
  });

  $(".card-slideToggle header").click(function () {
    if ($(this).parent().parent().find(".card-body").is(":visible")) {
      $(this)
        .parent()
        .parent()
        .find("a.btn-icon-toggle")
        .attr("style", "transform: rotate(0deg);");
    } else {
      $(this)
        .parent()
        .parent()
        .find("a.btn-icon-toggle")
        .attr("style", "transform: rotate(90deg);");
    }
    $(this).parent().parent().find(".card-body").slideToggle(200);
  });

  $(".modal-footer > :submit").click(function () {
    if ($(this).closest("form").prop("target") != "_blank") {
      $(this).parent().find("button").hide();
      $(this)
        .parent()
        .append(
          '<img src="images/loader.gif" style="margin: 30px auto 20px;display: block;" />'
        );
      $("#preLoader").show();
    }
  });

  $("#MenuOpcionesRow").mouseleave(function () {
    $("#MenuOpcionesRow").removeClass("open");
  });

  $("#MenuOpcionesRow").click(function () {
    $("#MenuOpcionesRow").removeClass("open");
  });
});

jQuery.fn.dataTableExt.oSort["num-documento-pre"] = function (a) {
  var doc = a.split(" ");
  var prefijo = doc[0].toUpperCase();
  var numero = doc[1];

  var largoprefijo = prefijo.length;
  for (var i = largoprefijo; i < 12; i++) {
    prefijo = prefijo + "A";
  }

  var largonumero = numero.length;
  for (var i = largonumero; i < 11; i++) {
    numero = "0" + numero;
  }

  return prefijo + numero;
};

jQuery.fn.dataTableExt.oSort["num-documento-asc"] = function (a, b) {
  return a - b;
};

jQuery.fn.dataTableExt.oSort["num-documento-desc"] = function (a, b) {
  return b - a;
};

jQuery.fn.dataTableExt.oSort["fecha-pre"] = function (a) {
  if (a == null || a == "") {
    return 0;
  }
  var date = a.split("/");
  return (date[2] + date[1] + date[0]) * 1;
};

jQuery.fn.dataTableExt.oSort["fecha-asc"] = function (a, b) {
  return a - b;
};

jQuery.fn.dataTableExt.oSort["fecha-desc"] = function (a, b) {
  return b - a;
};

jQuery.fn.dataTableExt.oSort["fecha-hora-pre"] = function (a) {
  var x;

  if ($.trim(a) !== "") {
    var frDatea = $.trim(a).split(" ");
    var frTimea = frDatea[1].split(":");
    var frDatea2 = frDatea[0].split("/");
    x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1]) * 1;
  } else {
    x = Infinity;
  }
  return x;
};

jQuery.fn.dataTableExt.oSort["fecha-hora-asc"] = function (a, b) {
  return a - b;
};

jQuery.fn.dataTableExt.oSort["fecha-hora-desc"] = function (a, b) {
  return b - a;
};

jQuery.fn.dataTableExt.oSort["numero-pre"] = function (a) {
  aux = parseFloat(a.replace(".", "").replace(",", "."));
  return aux;
};

jQuery.fn.dataTableExt.oSort["numero-asc"] = function (a, b) {
  return a - b;
};

jQuery.fn.dataTableExt.oSort["numero-desc"] = function (a, b) {
  return b - a;
};

$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = "static";

toastr.options = {
  debug: false,
  closeButton: true,
  positionClass: "toast-top-center",
  onclick: null,
  fadeIn: 300,
  fadeOut: 1000,
  timeOut: 5000,
  extendedTimeOut: 1000,
};

$.number.options = {
  debug: false,
  closeButton: true,
  positionClass: "toast-top-center",
  onclick: null,
  fadeIn: 300,
  fadeOut: 1000,
  timeOut: 5000,
  extendedTimeOut: 1000,
};

function prevenirEnvioForm() {
  $(window).keydown(function (event) {
    var tag = event.target.tagName.toLowerCase();
    if (event.keyCode == 13 && (tag != "input" || tag != "textarea")) {
      event.preventDefault();
      return false;
    }
  });
}

prevenirEnvioForm();

function cambiarSucursal() {
  const tempModal = createModal("ModalSucursal");
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option: "inicio",
      action: "cambiarSucursal",
      ajaxenable: "true",
    },
    cache: false,
  }).done(function (html) {
    $(tempModal).html(html);
    $("#localCambiar").multiselect();
    $(tempModal).modal("show");
  });
}

function confirmarCambiarSucursal() {
  var local = $("#localCambiar").val();
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option: "inicio",
      action: "cambiarSucursalConfirmar",
      ajaxenable: "true",
      local: local,
    },
    cache: false,
  }).done(function (respuesta) {
    $("#Modal").modal("hide");
    $("#nombreSucursal").html(respuesta);
  });
}

function buscarCliente(node, activo = -1) {
  var nombre = node.parent().find(".multiselect-search").val();
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option: "employees",
      action: "cargarFuncionarios",
      ajaxenable: "true",
      nombre: nombre,
      activo: activo,
    },
    cache: false,
  }).done(function (repuesta) {
    var jsonRepuesta = JSON.parse(repuesta);
    if (jsonRepuesta != null) {
      node.multiselect("dataprovider", jsonRepuesta);
      node.parent().find(".multiselect-search").val(nombre);
      node.parent().find(".multiselect-search").focus();
      if (jsonRepuesta.length == 1) {
        $(document).click();
      }
      node
        .parent()
        .find("a")
        .on("click", function () {
          setTimeout(function () {
            $(document).click();
          }, 100);
        });
    }
    inicalizarFiltroSocio(node, activo);
  });
}

// Filtro socios
function inicalizarFiltroSocio(node, activo = -1) {
  if (node && node.length) {
    var typingTimer;
    var doneTypingInterval = 800;
    var input = node.parent().find(".multiselect-search");
    //on keyup, start the countdown
    input.on("keyup", function () {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(() => {
        buscarCliente(node, activo);
      }, doneTypingInterval);
    });

    //on keydown, clear the countdown
    input.on("keydown", function () {
      clearTimeout(typingTimer);
    });
  }
}

function Comunicacion_getResponse(container, iddata, timeout = 12, i = 1) {
  const request = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option: "devices",
      action: "getResponse",
      ajaxenable: "true",
      iddata: iddata,
    },
    cache: false,
  }).done(function (json) {
    if (json !== null && json.hasOwnProperty("message")) {
      if (json.hasOwnProperty("status")) {
        $(container)[0].innerText = json.status.replace(/<br>/g, "\n");
      } else {
        $(container)[0].innerText = json.message.replace(/<br>/g, "\n");
      }
      Comunicacion_cambiarEstado(false);
    } else {
      $(container).text("Esperando respuesta... (" + i + ")");
      setTimeout(function () {
        if (timeout !== null && i == timeout) {
          let request = $.ajax({
            type: "GET",
            url: "index.php",
            data: {
              option: "devices",
              action: "sendAction",
              ajaxenable: "true",
              iddata: iddata,
              execute: "",
            },
            cache: false,
          }).done(function (html) {
            $(container)[0].innerText = "Tiempo de espera agotado.";
            Comunicacion_cambiarEstado(false);
          });
        } else {
          Comunicacion_getResponse(container, iddata, timeout, i + 1);
        }
      }, 2500);
    }
  });
}

function Comunicacion_createResponseBox(responseContainer, text) {
  const newBlock = document.createElement("div");
  newBlock.setAttribute("class", "form-group");
  document.querySelector(responseContainer).appendChild(newBlock);

  const labelDiv = document.createElement("div");
  labelDiv.setAttribute("class", "col-sm-3");
  newBlock.appendChild(labelDiv);

  const label = document.createElement("div");
  label.setAttribute("class", "control-label");
  label.textContent = text;
  labelDiv.appendChild(label);

  const responseDiv = document.createElement("div");
  responseDiv.setAttribute("class", "col-xs-9 col-sm-9 col-lg-6");
  newBlock.appendChild(responseDiv);

  return responseDiv;
}

function Comunicacion_sendAjaxAction(id_lector, accion, responseContainer) {
  const request = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option: "devices",
      action: "sendAction",
      ajaxenable: "true",
      iddata: id_lector,
      execute: accion.toLowerCase(),
    },
    cache: false,
  }).done(function (html) {
    let timeout = 60;
    if (accion.toLowerCase() !== "getstatus") {
      timeout = null;
    }
    if (responseContainer) {
      Comunicacion_getResponse(responseContainer, id_lector, timeout);
    }
  });
}

function Comunicacion_sendAction(
  accion,
  valueContainer = "#lectorInput",
  responseContainer = "#response"
) {
  if ($(valueContainer).val().length) {
    Comunicacion_cambiarEstado(true);
    let valuesDict = {};
    $(valueContainer + " option:selected").each(function () {
      var $this = $(this);
      if ($this.length) {
        valuesDict[$this.val()] = $this.text();
      }
    });
    $(responseContainer).empty();
    if (accion && accion.length > 0 && valueContainer) {
      if (Array.isArray($(valueContainer).val())) {
        for (let a in valuesDict) {
          const boxResponse = Comunicacion_createResponseBox(
            responseContainer,
            valuesDict[a]
          );
          Comunicacion_sendAjaxAction(a, accion.toLowerCase(), boxResponse);
        }
      } else {
        const boxResponse = Comunicacion_createResponseBox(
          responseContainer,
          $(valueContainer).data("nombre")
        );
        Comunicacion_sendAjaxAction(
          $(valueContainer).val(),
          accion.toLowerCase(),
          boxResponse
        );
      }
    } else {
      if (Array.isArray($(valueContainer).val())) {
        for (let a in valuesDict) {
          Comunicacion_sendAjaxAction(a, "", null);
        }
      } else {
        Comunicacion_sendAjaxAction($(valueContainer).val(), "", null);
      }
      Comunicacion_cambiarEstado(false);
      $("#response").text("Accion limpiada correctamente");
    }
  }
}

function Conf_Forzar_Actualizar_Func() {
  if (confirm("Estas seguro que quieres hacer esto?")) {
    Comunicacion_sendAction("forzarActualizarFuncionarios");
  }
}
function Comunicacion_cambiarEstado(com) {
  const botones = document.querySelectorAll(".comButton");
  for (let c in botones) {
    botones[c].disabled = com;
  }
}

const activeModals = [];

function createModal(id) {
  if (document.querySelector("#" + id)) {
    $("#" + id).remove();
  }
  const tempModal = document.createElement("div");
  tempModal.setAttribute("class", "modal fade");
  tempModal.id = id;
  tempModal.setAttribute("tabindex", "-1");
  tempModal.setAttribute("role", "dialog");
  tempModal.setAttribute("aria-labelledby", "formModalLabel");
  tempModal.setAttribute("aria-hidden", "true");
  document.body.appendChild(tempModal);
  activeModals.push(tempModal);

  return tempModal;
}

function buscarCliente2(node, activo = -1) {
  var listaValores = [];
  var valoresSeleccionados = node.val();
  if (valoresSeleccionados) {
    node.find("option").each(function () {
      if (valoresSeleccionados.indexOf($(this).val()) != -1) {
        listaValores.push({
          value: $(this).val(),
          label: $(this).attr("label"),
          selected: true,
        });
      }
    });
  }
  var nombre = node.parent().find(".multiselect-search").val();
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option: "funcionarios",
      action: "cargarFuncionarios",
      ajaxenable: "true",
      nombre: nombre,
      activo: activo,
    },
    cache: false,
  }).done(function (respuesta) {
    var jsonRespuesta = JSON.parse(respuesta);
    if (jsonRespuesta != null) {
      for (var i in listaValores) {
        listaValores[i].selected = true;
        var add = true;
        for (var a in jsonRespuesta) {
          if (jsonRespuesta[a].value == listaValores[i].value) {
            jsonRespuesta[a].selected = true;
            add = false;
            break;
          }
        }
        if (add) {
          jsonRespuesta.push(listaValores[i]);
        }
      }
    } else {
      jsonRespuesta = listaValores;
    }
    if (jsonRespuesta.length > 0) {
      node.multiselect("dataprovider", jsonRespuesta);
      node.parent().find(".multiselect-search").val(nombre);
      node.parent().find(".multiselect-search").focus();
    }
    inicalizarFiltroFuncionarioMultiple(node, activo);
  });
}

// Filtro socios
function inicalizarFiltroFuncionarioMultiple(node, activo = -1) {
  if (node && node.length) {
    var typingTimer;
    var doneTypingInterval = 800;
    var input = node.parent().find(".multiselect-search");
    //on keyup, start the countdown
    input.on("keyup", function () {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(() => {
        buscarCliente2(node, activo);
      }, doneTypingInterval);
    });

    //on keydown, clear the countdown
    input.on("keydown", function () {
      clearTimeout(typingTimer);
    });
  }
}

function lanzarImpresion(tipoDeImpresion) {
  let query = "";
  const formElements = document.querySelectorAll(".filtros [name]");
  for (let i = 0; i < formElements.length; i++) {
    let value = "";
    if (formElements[i].getAttribute("type") == "checkbox") {
      value = formElements[i].checked ? "on" : "off";
    } else {
      value = formElements[i].value;
    }
    query += "&" + formElements[i].getAttribute("name") + "=" + value;
  }
  document
    .querySelector("#exportarReporte")
    .setAttribute(
      "href",
      "index.php?option=reportes&ajaxenable=true&action=" +
        tipoDeImpresion +
        query +
        "&filtrar="
    );
  document.querySelector("#exportarReporte").click();
}

var tiempoUltimaBusqueda = 100;
$(document).ready(function () {
  try {
    $("#filtrar_listado input").keyup(function () {
      buscarEnTabla("listado_elementos");
    });
  } catch (e) {}
  try {
    $("input.mes").datetimepicker({
      minView: 5,
      startView: 3,
      format: "mm",
      language: "es",
      autoclose: 1,
    });
  } catch (e) {}
  try {
    $("input.año").datetimepicker({
      minView: 5,
      startView: 4,
      format: "yyyy",
      language: "es",
      autoclose: 1,
    });
  } catch (e) {}
  try {
    $("input.fecha").datetimepicker({
      minView: 2,
      format: "dd/mm/yyyy",
      language: "es",
      autoclose: 1,
    });
  } catch (e) {}
  try {
    $(".fecha_dia").datepicker({
      autoclose: true,
      todayHighlight: true,
      startView: 2,
      format: "dd/mm/yyyy",
    });
  } catch (e) {}
  try {
    $("input.fecha_hora").datetimepicker({
      format: "dd/mm/yyyy hh:ii",
      language: "es",
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
    });
  } catch (e) {}
  try {
    $("input.hora").datetimepicker({
      format: "hh:ii",
      language: "es",
      autoclose: 1,
      startView: 0,
      forceParse: 0,
    });
  } catch (e) {}
  try {
    $("select.multiselect").multiselect({ maxHeight: 350 });
  } catch (e) {}
  try {
    $("input.tiempo").inputmask("h:s", { placeholder: "hh:mm" });
  } catch (e) {}
  try {
    $(".colorpicker").colorpicker();
  } catch (e) {}
  try {
    $("#buttonExportar").on("click", function () {
      lanzarImpresion("imprimirPDF");
    });
  } catch (e) {}
  try {
    $("#buttonExportarCSV").on("click", function () {
      lanzarImpresion("imprimirCSV");
    });
  } catch (e) {}
  try {
    $("#buttonExportarEXCEL").on("click", function () {
      lanzarImpresion("imprimirEXCEL");
    });
  } catch (e) {}
  try {
    $.each(["show", "hide"], function (i, ev) {
      var el = $.fn[ev];
      $.fn[ev] = function () {
        this.trigger(ev);
        return el.apply(this, arguments);
      };
    });
  } catch (e) {}
});
