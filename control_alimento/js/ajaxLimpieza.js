$(function () {
  fetchTasks();
  let edit = false;

  $("#search").keyup(() => {
    if ($("#search").val()) {
      var search = $("#search").val();
      const accion = "buscarlimpieza";
      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarLimpieza: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);
            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.COD_FRECUENCIA}">
              <td>${task.COD_FRECUENCIA}</td>
              <td>${task.NOMBRE_T_ZONA_AREAS}</td>
              <td>${task.NOMBRE_FRECUENCIA}</td>
              <td>${task.FECHA}</td>
              <td>${task.VERSION}</td>
              
              <td><button class="btn btn-success task-update" name="editar" id="edit" data-COD_FRECUENCIA="${task.COD_FRECUENCIA}"><i class="icon-edit"></i></button></td>
          </tr>`;
            });
            $("#tdLimpiezadesinfeccion").html(template);
          }
        },
      });
    }
  });

  function fetchTasks() {
    var search = "";
    const accion = "buscarlimpieza";
    $.ajax({
      // url: "./tablaLimpieza.php",
      url: "./c_almacen.php",
      data: { accion: accion, buscarLimpieza: search },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_FRECUENCIA}">
            <td>${task.COD_FRECUENCIA}</td>
            <td>${task.NOMBRE_T_ZONA_AREAS}</td>
            <td>${task.NOMBRE_FRECUENCIA}</td>
            <td>${task.FECHA}</td>
            <td>${task.VERSION}</td>
            
            <td><button class="btn btn-success task-update" name="editar" id="edit" data-COD_FRECUENCIA="${task.COD_FRECUENCIA}"><i class="icon-edit"></i></button></td>
        </tr>`;
          });
          $("#tdLimpiezadesinfeccion").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  //------------------------ Añadiendo un dato de mi tabla ----------------- //
  $("#formularioLimpieza").submit(function (e) {
    e.preventDefault();
    var selectZona = $("#selectZona").val();
    var textfrecuencia = $("#nombreFrecuencia").val();

    var textAreaObservacion = $("#textAreaObservacion").val();
    var textAreaAccion = $("#textAreaAccion").val();
    var selectVerificacion = $("#selectVerificacion option:selected").text();

    const accion = edit === false ? "insertarLimpieza" : "actualizarLimpieza";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        selectZona: selectZona,
        textfrecuencia: textfrecuencia,
        textAreaObservacion: textAreaObservacion,
        textAreaAccion: textAreaAccion,
        selectVerificacion: selectVerificacion,
        codfre: $("#taskId").val(),
      },
      type: "POST",
      success: function (response) {
        console.log(response);

        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#formularioLimpieza").trigger("reset");
            }
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Duplicado!",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#formularioLimpieza").trigger("reset");
            }
          });
        }
      },
    });
  });

  //------------------------ Actualiza un dato de mi tabla ----------------- //

  $(document).on("click", ".task-update", () => {
    var element = $(this)[0].activeElement.parentElement.parentElement;
    var selectZona = $("#selectZona");
    selectZona.prop("disabled", true);

    var cod_frecuencia = $(element).attr("taskId");
    const accion = "editarLimpieza";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        cod_frecuencia: cod_frecuencia,
      },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          const task = JSON.parse(response);

          var selectZon = $("#selectZona");

          selectZon.prop("disabled", true);

          if (task.NOMBRE_T_ZONA_AREAS) {
            selectZon.val(
              selectZon
                .find("option:contains('" + task.NOMBRE_T_ZONA_AREAS + "')")
                .val()
            );
          }

          $("#nombreFrecuencia").val(task.NOMBRE_FRECUENCIA);
          $("#taskId").val(task.COD_FRECUENCIA);

          edit = true;
        }
      },
    });
  });
});
