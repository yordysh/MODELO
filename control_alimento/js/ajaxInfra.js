$(function () {
  fetchTasks();
  // select();

  let edit = false;

  //------------- MENU BAR JS ---------------//
  let nav = document.querySelector(".nav"),
    searchIcon = document.querySelector("#searchIcon"),
    navOpenBtn = document.querySelector(".navOpenBtn"),
    navCloseBtn = document.querySelector(".navCloseBtn");

  searchIcon.addEventListener("click", () => {
    nav.classList.toggle("openSearch");
    nav.classList.remove("openNav");
    if (nav.classList.contains("openSearch")) {
      return searchIcon.classList.replace(
        "icon-magnifying-glass",
        "icon-cross"
      );
    }

    searchIcon.classList.replace("icon-cross", "icon-magnifying-glass");
  });

  navOpenBtn.addEventListener("click", () => {
    nav.classList.add("openNav");
    nav.classList.remove("openSearch");
  });

  navCloseBtn.addEventListener("click", () => {
    nav.classList.remove("openNav");
  });
  //----------------------------------------------------------------//

  // $("#selectInfra").select2();
  // var aData = [];

  // $("#selectInfra").autocomplete({
  // source: function (request, response) {
  $(document).ready(function () {
    // const accion = "buscarZonaCombo";
    // $.ajax({
    //   url: "./c_almacen.php",
    //   data: { accion: accion },
    //   type: "POST",
    //   // dataType: "json",
    //   success: function (data) {
    //     var res = JSON.parse(data);
    //     $("#selectInfra").autocomplete({
    //       source: res,
    //       select: function (request, ui) {
    //         //const search = $("#selectInfra").val();
    //         var nombre = ui.item.COD_ZONA1;
    //         console.log(nombre);
    //       },
    //     });
    //   },
    // });

    $("#selectInfra").autocomplete({
      source: function (request, response) {
        const accion = "buscarZonaCombo";

        $.ajax({
          url: "./c_almacen.php",
          method: "POST",
          dataType: "json",
          data: {
            accion: accion,
            term: request.term,
          },
          success: function (data) {
            if (!data) {
              $("#task_zona").val("");
            }
            response(data);
          },
        });
      },
      select: function (event, ui) {
        console.log(ui.item.id);
        $("#task_zona").val(ui.item.id);
      },
      close: function () {
        const searchTerm = $("#selectInfra").val().trim();

        // Si el término de búsqueda está vacío, borrar el valor del input "task_zona"
        if (searchTerm === "") {
          $("#task_zona").val("");
        }
      },
    });
  });

  //------------- Busqueda con ajax infraestructura Accesorio----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      let search = $("#search").val();
      const accion = "buscarinfra";

      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarinfra: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);
            // console.log(tasks);
            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.COD_INFRAESTRUCTURA}">

              <td data-titulo="CODIGO" >${task.COD_INFRAESTRUCTURA}</td>
              <td data-titulo="ZONA" >${task.NOMBRE_T_ZONA_AREAS}</td>
              <td data-titulo="INFRAESTRUCTURA" class='NOMBRE_INFRAESTRUCTURA' >${task.NOMBRE_INFRAESTRUCTURA}</td>
              <td data-titulo="N°DIAS">${task.NDIAS}</td>
              <td data-titulo="FECHA" >${task.FECHA}</td>

              <td style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_INFRAESTRUCTURA="${task.COD_INFRAESTRUCTURA}"><i class="icon-edit"></i></button></td>

            </tr>`;
            });

            $("#tablaInfraestructura").html(template);
          }
        },
      });
    } else {
      fetchTasks();
    }
  });

  //------------- Añadiendo con ajax InfraestructuraAccesorios----------------//
  $("#formularioInfra").submit((e) => {
    e.preventDefault();

    var selectInfra = document.getElementById("selectInfra");

    selectInfra.disabled = false;

    const accion = edit === false ? "insertarinfra" : "actualizarinfra";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        nombreinfraestructura: $("#NOMBRE_INFRAESTRUCTURA").val(),
        ndias: $("#NDIAS").val(),
        codinfra: $("#taskId").val(),
        valorSeleccionado: $("#selectInfra").val(),
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
              $("#formularioInfra").trigger("reset");
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
    const accion = "buscarinfra";
    const search = "";
    $.ajax({
      // url: "./tablaInfraestructura.php",
      url: "./c_almacen.php",
      data: { accion: accion, buscarinfra: search },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_INFRAESTRUCTURA}">

            <td data-titulo="CODIGO" >${task.COD_INFRAESTRUCTURA}</td>
            <td data-titulo="ZONA" >${task.NOMBRE_T_ZONA_AREAS}</td>
            <td data-titulo="INFRAESTRUCTURA" class='NOMBRE_INFRAESTRUCTURA' >${task.NOMBRE_INFRAESTRUCTURA}</td>
            <td data-titulo="N°DIAS">${task.NDIAS}</td>
            <td data-titulo="FECHA" >${task.FECHA}</td>


            <td style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_INFRAESTRUCTURA="${task.COD_INFRAESTRUCTURA}"><i class="icon-edit"></i></button></td>

          </tr>`;
          });

          $("#tablaInfraestructura").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  //------------------------ Actualiza un dato de mi tabla ----------------- //

  $(document).on("click", ".task-update", () => {
    var element = $(this)[0].activeElement.parentElement.parentElement;

    // var selectInfra = document.getElementById("selectInfra");
    // selectInfra.disabled = true;

    var COD_INFRAESTRUCTURA = $(element).attr("taskId");
    const accion = "editarinfra";

    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, codinfra: COD_INFRAESTRUCTURA },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          const task = JSON.parse(response);

          var selectInfra = $("#selectInfra");

          selectInfra.prop("disabled", true);

          if (task.NOMBRE_T_ZONA_AREAS) {
            selectInfra.val(
              selectInfra
                .find("option:contains('" + task.NOMBRE_T_ZONA_AREAS + "')")
                .val()
            );
          }

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
    var COD_INFRAESTRUCTURA = $(this).attr("data-COD_INFRAESTRUCTURA");
    const accion = "eliminarinfra";

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
          url: "./c_almacen.php",
          type: "POST",
          data: { accion: accion, codinfra: COD_INFRAESTRUCTURA },
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
