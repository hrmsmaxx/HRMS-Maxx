function modaldocumento() {
  const tempModal = createModal("ModalDocumento");
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option: "funcionarios-documentos",
      action: "add",
      ajaxenable: "true",
      isModal: true,
      iddata: "",
    },
    cache: false,
  }).done(function (html) {
    $("#ModalDocumento").html(html);
    $("#ModalDocumento").modal("show");
    const submitFormulario = $("#ModalDocumento").find(
      "button[type='submit'][name='agregar']"
    )[0];

    const selectFuncionario = $("#ModalEdit").find("#FiltroFuncionarioEditar");
    const nuevaOpcion = document.createElement("option");
    nuevaOpcion.value = selectFuncionario.val();
    nuevaOpcion.textContent = selectFuncionario
      .find("option[value='" + nuevaOpcion.value + "']")
      .text();
    $("#ModalDocumento").find("#FiltroFuncionario")[0].appendChild(nuevaOpcion);
    $("#ModalDocumento").find("#FiltroFuncionario")[0].selectedIndex =
      selectFuncionario[0].getElementsByTagName("option").length - 1;
    $("#ModalDocumento")
      .find("#FiltroFuncionario")[0]
      .setAttribute("disabled", "disabled");

    submitFormulario.setAttribute("type", "button");
    submitFormulario.onclick = function (e) {
      e.preventDefault();

      const file_data = tempModal.querySelector("#filename").files[0];
      const form_data = new FormData();
      form_data.append("option", "funcionarios-documentos");
      form_data.append("action", "crearDocumento");
      form_data.append("ajaxenable", "true");
      form_data.append(
        "funcionario",
        tempModal.querySelector("select[name='funcionario']").value
      );
      form_data.append(
        "documento",
        tempModal.querySelector("select[name='documento']").value
      );
      form_data.append(
        "vencimiento",
        tempModal.querySelector("input[name='vencimiento']").value
      );
      form_data.append("iddata", "");
      form_data.append("fotoDocumento", file_data);

      $.ajax({
        type: "POST",
        url: "index.php",
        dataType: "text", // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        enctype: "multipart/form-data",
        data: form_data,
      }).done(function (html) {
        console.log(html);
        const respuesta = JSON.parse(html);
        $("#mensajeErrorAgregarDocumento").text(respuesta.message);
        if (respuesta.error == 0 && respuesta.object != null) {
          const selectorDocumento = $("#ModalEdit").find(
            "#DocumentosFuncionario"
          )[0];
          const nuevaOpcion = document.createElement("option");
          nuevaOpcion.value = respuesta.object.id_funcionario_documento;
          nuevaOpcion.textContent =
            respuesta.object.id_funcionario_documento +
            " - " +
            respuesta.object.documento_nombre;
          selectorDocumento.appendChild(nuevaOpcion);
          selectorDocumento.selectedIndex =
            selectorDocumento.getElementsByTagName("option").length - 1;

          $("#ModalEdit").find("#DocumentosFuncionario").val(nuevaOpcion.value);
          $("#ModalEdit").find("#DocumentosFuncionario").multiselect("refresh");
        }
        $("#ModalDocumento").html("");
        document.body.removeChild(document.querySelector("#ModalDocumento"));
      });
    };
    $(tempModal).find("input.fecha_hora").datetimepicker({
      minView: 2,
      format: "dd/mm/yyyy hh:mm:ss A",
      language: "es",
      autoclose: 1,
    });
    inicalizarFiltroSocio($(tempModal).find("#FiltroFuncionario"));
    inicalizarFiltroSocio($(tempModal).find("#FiltroFuncionario1"));
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
    inicalizarFiltroSocio($("#FiltroFuncionarioEditar"), 1);
  });
}

function modalAgregarParcial() {
  const tempModal = createModal("ModalAgregar");
  opeajax = $.ajax({
    type: "GET",
    url: "index.php",
    data: {
      option,
      action: "modalAgregarParcial",
      ajaxenable: "true",
      isModal: true,
    },
    cache: false,
  }).done(function (html) {
    $(tempModal).html(html);
    $(tempModal).modal("show");
    inicalizarFiltroSocio($("#FiltroFuncionarioAgregarMarcaParcial"), 1);
  });
}

$(document).ready(function () {
  var editar = $(".editar");
  $(editar).tooltip({ title: "Editar" });
  inicalizarFiltroSocio($("#FiltroFuncionario"), 1);
  inicalizarFiltroSocio($("#FiltroFuncionarioCorregirMarcas"), 1);
  inicalizarFiltroSocio($("#FiltroFuncionarioResponsableCorregirMarcas"), 1);
  inicalizarFiltroSocio($("#FiltroFuncionarioAgregarMarca"), 1);
  $("#listado_elementos").DataTable(dataTableConfig);
});
