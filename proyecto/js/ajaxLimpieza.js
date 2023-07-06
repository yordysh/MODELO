$(function () {
  $("#task-result").hide();
  fetchTasks();
  let edit = false;

  function fetchTasks() {
    $.ajax({
      url: "./tablaLimpieza.php",
      type: "GET",
      success: function (data) {
        $("#tablalimpieza").html(data);
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

    const accion = edit === false ? "insertarLimpieza" : "actualizarLimpieza";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        selectZona: selectZona,
        textfrecuencia: textfrecuencia,
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

          selectZon.prop("disabled", true); // Deshabilitar el elemento

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
