$(function () {
  $("#task-result").hide();
  fetchTasks();
  let edit = false;

  //------------- Busqueda con ajax infraestructura Accesorio----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      let search = $("#search").val();

      $.ajax({
        url: "./buscar-infra.php",
        data: { search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);

            let template = ``;
            tasks.forEach((task) => {
              template += `<li class="task-item">${task.NOMBRE_INFRAESTRUCTURA}</li>`;
            });
            $("#task-result").show();
            $("#container").html(template);
          }
        },
      });
    }
  });

  //------------- Añadiendo con ajax InfraestructuraAccesorios----------------//
  $("#formularioInfra").submit((e) => {
    e.preventDefault();
    // console.log($("#taskId").val());
    var selectInfra = document.getElementById("selectInfra");
    selectInfra.disabled = false;
    const postData = {
      NOMBRE_INFRAESTRUCTURA: $("#NOMBRE_INFRAESTRUCTURA").val(),
      NDIAS: $("#NDIAS").val(),
      COD_INFRAESTRUCTURA: $("#taskId").val(),
      valorSeleccionado: $("#selectInfra").val(),
    };

    const url =
      edit === false ? "./insertar-infra.php" : "./actualizar-infra.php";

    $.ajax({
      url: url,
      data: postData,
      type: "POST",
      success: function (response) {
        // console.log(response);
        if (!response.error) {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#formularioInfra").trigger("reset");
            }
          });
        }
        // console.log(data);
      },
    });
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //
  // Cargar registros ZONA AREA

  function fetchTasks() {
    $.ajax({
      url: "./tablaInfraestructura.php",
      type: "GET",
      success: function (data) {
        $("#tablaInfra").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  //------------------------ Actualiza un dato de mi tabla ----------------- //

  $(document).on("click", ".task-update", () => {
    var element = $(this)[0].activeElement.parentElement.parentElement;
    var selectInfra = document.getElementById("selectInfra");
    selectInfra.disabled = true;

    var COD_INFRAESTRUCTURA = $(element).attr("taskId");
    // console.log(COD_INFRAESTRUCTURA);
    let url = "./editar-infra.php";

    $.ajax({
      url,
      data: { COD_INFRAESTRUCTURA },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          const task = JSON.parse(response);
          // let tasks = response;
          console.log(task);
          // console.log(task);
          $("#NOMBRE_INFRAESTRUCTURA").val(task.NOMBRE_INFRAESTRUCTURA);
          $("#NDIAS").val(task.NDIAS);
          $("#taskId").val(task.COD_INFRAESTRUCTURA);

          edit = true;
        }
      },
    });
  });

  //------------------------ Elimina un dato de mi tabla ----------------- //

  $(document).on("click", ".task-delete", function (e) {
    e.preventDefault();
    // var COD_ZONA = $(this).data("COD_ZONA");
    var COD_INFRAESTRUCTURA = $(this).attr("data-COD_INFRAESTRUCTURA");
    console.log(COD_INFRAESTRUCTURA);

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
          url: "./eliminar-infra.php",
          type: "POST",
          data: { COD_INFRAESTRUCTURA: COD_INFRAESTRUCTURA },
          success: function (response) {
            fetchTasks();
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Registro eliminado correctamente.",
              showConfirmButton: false,
              timer: 1500,
            });
            console.log(response);
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });
      }
    });
  });
});
