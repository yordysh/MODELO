$(function () {
  fetchTasks();
  cargarSelect();

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

                <td>${task.NOMBRE_INSUMOS}</td>
                <td>${task.NOMBRE_PREPARACION}</td>
                <td>${task.CANTIDAD_PORCENTAJE}</td>
                <td>${task.CANTIDAD_MILILITROS}</td>
                <td>${task.CANTIDAD_LITROS}</td>
                <td>${task.FECHA}</td>

              </tr>`;
            });

            $("#tbPreparacion").html(template);
          }
        },
      });
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

              <td>${task.NOMBRE_INSUMOS}</td>
              <td>${task.NOMBRE_PREPARACION}</td>
              <td>${task.CANTIDAD_PORCENTAJE}</td>
              <td>${task.CANTIDAD_MILILITROS}</td>
              <td>${task.CANTIDAD_LITROS}</td>
              <td>${task.FECHA}</td>

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

  $("#formularioSoluciones").submit(function (e) {
    e.preventDefault();
    var selectSolucion = $("#selectInsumos option:selected").text();
    var selectPreparacion = $("#selectPreparaciones option:selected").text();
    var selectCantidad = $("#selectCantidad option:selected").text();
    var selectML = $("#selectML option:selected").text();
    var selectL = $("#selectL option:selected").text();
    var textAreaObservacion = $("#textAreaObservacion").val();
    var textAreaAccion = $("#textAreaAccion").val();
    var selectVerificacion = $("#selectVerificacion option:selected").text();

    enviarCombos(
      selectSolucion,
      selectPreparacion,
      selectCantidad,
      selectML,
      selectL,
      textAreaObservacion,
      textAreaAccion,
      selectVerificacion
    );
    $("#formularioSoluciones").trigger("reset");
  });

  function enviarCombos(
    selectSolucion,
    selectPreparacion,
    selectCantidad,
    selectML,
    selectL,
    textAreaObservacion,
    textAreaAccion,
    selectVerificacion
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
        accion: accion,
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
              $("#formularioSoluciones").trigger("reset");
            }
          });
        } else {
          Swal.fire(
            "Error",
            "Solo se puede añadir una preparación por día",
            "error"
          );
          $("#formularioSoluciones").trigger("reset");
        }
      },
    });
  }
});
