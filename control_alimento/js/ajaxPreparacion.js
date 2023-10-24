$(function () {
  fetchTasks();
  cargarSelect();

  //===== Prealoder

  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //-------------------------------------------//

  //----------------------------------------------------------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      var search = $("#search").val();
      const accion = "buscarprepararacion";
      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarPrepa: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);

            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.ID_UNION}">

                <td data-titulo="PRODUCTO SANEAMIENTO">${task.NOMBRE_INSUMOS}</td>
                <td data-titulo="PRODUCTOS">${task.NOMBRE_PREPARACION}</td>
                <td data-titulo="CANTIDAD">${task.CANTIDAD_PORCENTAJE}</td>
                <td data-titulo="ML">${task.CANTIDAD_MILILITROS}</td>
                <td data-titulo="L">${task.CANTIDAD_LITROS}</td>
                <td data-titulo="FECHA">${task.FECHA}</td>

              </tr>`;
            });

            $("#tbPreparacion").html(template);
          }
        },
      });
    } else {
      fetchTasks();
    }
  });

  function fetchTasks() {
    var search = "";
    const accion = "buscarprepararacion";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, buscarPrepa: search },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.ID_UNION}">

            <td data-titulo="PRODUCTO SANEAMIENTO">${task.NOMBRE_INSUMOS}</td>
            <td data-titulo="PRODUCTOS">${task.NOMBRE_PREPARACION}</td>
            <td data-titulo="CANTIDAD">${task.CANTIDAD_PORCENTAJE}</td>
            <td data-titulo="ML">${task.CANTIDAD_MILILITROS}</td>
            <td data-titulo="L">${task.CANTIDAD_LITROS}</td>
            <td data-titulo="FECHA">${task.FECHA}</td>

            </tr>`;
          });

          $("#tbPreparacion").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  function cargarSelect() {
    const preparacion = $("#selectPreparaciones");
    const cantidad = $("#selectCantidad");
    const mililitros = $("#selectML");
    const litros = $("#selectL");
    const accion = "seleccionarPreparacion";
    const accionPreparacion = "seleccionarCantidad";
    const accionCantidad = "seleccionarML";
    const accionMililitros = "seleccionarL";

    $("#selectInsumos").change(function () {
      var idSolucion = $(this).val();
      $.ajax({
        data: {
          idSolucion: idSolucion,
          accion: accion,
        },
        dataType: "html",
        type: "POST",
        url: "./c_almacen.php",
      }).done(function (data) {
        preparacion.html(data);
        cantidad
          .empty()
          .append(
            '<option value="0" selected disabled>Seleccione cantidad</option>'
          );

        mililitros
          .empty()
          .append(
            '<option value="0" selected disabled>Seleccione cantidad ML</option>'
          );
        litros
          .empty()
          .append(
            '<option value="0" selected disabled>Seleccione cantidad L</option>'
          );
      });
    });

    $("#selectPreparaciones").change(function () {
      var idPreparacion = $(this).val();
      $.ajax({
        data: {
          idPreparacion: idPreparacion,
          accion: accionPreparacion,
        },
        dataType: "html",
        type: "POST",
        url: "./c_almacen.php",
      }).done(function (data) {
        cantidad.html(data);
        mililitros
          .empty()
          .append(
            '<option value="0" selected disabled>Seleccione cantidad ML</option>'
          );
        litros
          .empty()
          .append(
            '<option value="0" selected disabled>Seleccione cantidad L</option>'
          );
      });
    });

    $("#selectCantidad").change(function () {
      var idCantidad = $(this).val();
      $.ajax({
        data: {
          idCantidad: idCantidad,
          accion: accionCantidad,
        },
        dataType: "html",
        type: "POST",
        url: "./c_almacen.php",
      }).done(function (data) {
        mililitros.html(data);
        litros
          .empty()
          .append(
            '<option value="0" selected disabled>Seleccione cantidad L</option>'
          );
      });
    });

    $("#selectML").change(function () {
      var idMililitros = $(this).val();

      $.ajax({
        data: {
          idMililitros: idMililitros,
          accion: accionMililitros,
        },
        dataType: "html",
        type: "POST",
        url: "./c_almacen.php",
      }).done(function (data) {
        litros.html(data);
      });
    });
  }

  // $("#formularioSoluciones").submit(function (e) {
  $("#boton").click((e) => {
    e.preventDefault();
    var selectSolucion = $("#selectInsumos option:selected").text();
    var selectPreparacion = $("#selectPreparaciones option:selected").text();
    var selectCantidad = $("#selectCantidad option:selected").text();
    var selectML = $("#selectML option:selected").text();
    var selectL = $("#selectL option:selected").text();
    var textAreaObservacion = $("#textAreaObservacion").val();
    var textAreaAccion = $("#textAreaAccion").val();
    var selectVerificacion = $("#selectVerificacion option:selected").text();
    var valorextra = $("#valorextra").val();

    if ($("#selectInsumos").val() == null) {
      Swal.fire({
        title: "Llenar campo",
        text: "Elegir un producto de saneamiento",
        icon: "question",
        confirmButtonText: "Ok",
      });
      return;
    }
    if ($("#selectPreparaciones").val() == null) {
      Swal.fire({
        title: "Llenar campo",
        text: "Elegir una preparación.",
        icon: "question",
        confirmButtonText: "Ok",
      });
      return;
    }
    if ($("#selectCantidad").val() == null) {
      Swal.fire({
        title: "Llenar campo",
        text: "Elegir una cantidad.",
        icon: "question",
        confirmButtonText: "Ok",
      });
      return;
    }

    enviarCombos(
      selectSolucion,
      selectPreparacion,
      selectCantidad,
      selectML,
      selectL,
      textAreaObservacion,
      textAreaAccion,
      selectVerificacion,
      valorextra
    );
    // $("#formularioSoluciones").trigger("reset");
  });

  function enviarCombos(
    selectSolucion,
    selectPreparacion,
    selectCantidad,
    selectML,
    selectL,
    textAreaObservacion,
    textAreaAccion,
    selectVerificacion,
    valorextra
  ) {
    var accion = "enviarSelectCombo";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        selectSolucion: selectSolucion,
        selectPreparacion: selectPreparacion,
        selectCantidad: selectCantidad,
        selectML: selectML,
        selectL: selectL,
        textAreaObservacion: textAreaObservacion,
        textAreaAccion: textAreaAccion,
        selectVerificacion: selectVerificacion,
        valorextra: valorextra,
        accion: accion,
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: function (response) {
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              // $("#formularioSoluciones").trigger("reset");
              $("#selectInsumos").val("0").trigger("change");
              $("#selectPreparaciones").val("0").trigger("change");
              $("#selectCantidad").val("0").trigger("change");
              $("#selectML").val("0").trigger("change");
              $("#selectL").val("0").trigger("change");
              $("#textAreaObservacion").val("");
              $("#textAreaAccion").val("");
              $("#selectVerificacion").val("0").trigger("change");
              $("#valorextra").val("");
            }
          });
        } else {
          Swal.fire("Error", "Error al insertar", "error");
          $("#formularioSoluciones").trigger("reset");
        }
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  }
});
