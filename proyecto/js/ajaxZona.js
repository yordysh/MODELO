$(function () {
  $("#task-result").hide();
  fetchTasks();
  let edit = false;

  //------------- Busqueda con ajax zonaArea----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      var search = $("#search").val();
      const accion = "buscarzona";
      // console.log(search);
      $.ajax({
        // url: "./buscar-tarea.php",
        url: "./c_almacen.php",
        data: { accion: accion, buscarzona: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);
            let template = ``;
            tasks.forEach((task) => {
              template += `<li class="task-item">${task.NOMBRE_T_ZONA_AREAS}</li>`;
            });
            $("#task-result").show();
            $("#container").html(template);
          }
        },
      });
    }
  });

  //------------- Añadiendo con ajax zonaArea----------------//
  $("#formularioZona").submit((e) => {
    e.preventDefault();

    const accion = edit === false ? "insertar" : "actualizar";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        nombrezonaArea: $("#NOMBRE_T_ZONA_AREAS").val(),
        codzona: $("#taskId").val(),
      },

      type: "POST",
      success: function (response) {
        // alert(response);
        // console.log(response);
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#formularioZona").trigger("reset");
            }
          });
        } else {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#formularioZona").trigger("reset");
            }
          });
        }
      },
    });
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //
  // Cargar registros ZONA AREA

  function fetchTasks() {
    $.ajax({
      url: "./tablaZona.php",
      type: "GET",
      success: function (data) {
        $("#tablaAlmacen").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  //------------------------ Actualiza un dato de mi tabla ----------------- //

  $(document).on("click", ".task-update", () => {
    var element = $(this)[0].activeElement.parentElement.parentElement;

    var COD_ZONA = $(element).attr("taskId");

    const accion = "editar";

    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, codzona: COD_ZONA },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          console.log(response);
          const task = JSON.parse(response);
          console.log(task);
          $("#NOMBRE_T_ZONA_AREAS").val(task.NOMBRE_T_ZONA_AREAS);
          $("#taskId").val(task.COD_ZONA);
          edit = true;
        }
      },
    });
  });

  //------------------------ Elimina un dato de mi tabla ----------------- //

  $(document).on("click", ".task-delete", function (e) {
    e.preventDefault();
    // var COD_ZONA = $(this).data("COD_ZONA");

    var COD_ZONA = $(this).attr("data-COD_ZONA");
    const accion = "eliminarzona";
    console.log(COD_ZONA);

    Swal.fire({
      title: "¿Está seguro de eliminar este registro?",
      text: "Esta acción no se puede deshacer.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          // url: "./eliminar-zona.php",
          // accion: "eliminarzona",
          url: "./c_almacen.php",
          data: { accion: accion, codzona: COD_ZONA },
          type: "POST",
          success: function (response) {
            fetchTasks();
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Registro eliminado correctamente.",
              showConfirmButton: false,
              timer: 1500,
            });
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });
      }
    });
  });
});
