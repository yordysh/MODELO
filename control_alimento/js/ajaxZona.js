$(function () {
  fetchTasks();
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

  //------------- Busqueda con ajax zonaArea----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      var search = $("#search").val();
      const accion = "buscarzona";
      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarzona: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);

            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.COD_ZONA}">

              <td data-titulo="CODIGO">${task.COD_ZONA}</td>
              <td data-titulo="NOMBRE" class="NOMBRE_T_ZONA_AREAS" >${task.NOMBRE_T_ZONA_AREAS}</td>
              <td data-titulo="FECHA" >${task.FECHA}</td>
              <td data-titulo="VERSION">${task.VERSION}</td>
  
              <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_ZONA="${task.COD_ZONA}"><i class="icon-trash"></i></button></td>
              <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_ZONA="${task.COD_ZONA}"><i class="icon-edit"></i></button></td>
  
          </tr>`;
            });

            $("#tablita").html(template);
          }
        },
      });
    } else {
      fetchTasks();
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
        if (response.toLowerCase() === "ok") {
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
            icon: "error",
            title: "Oops...",
            text: "Duplicado!",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#formularioZona").trigger("reset");
            }
          });
        }
        // console.log("RESPONSE" + response);
      },
    });
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //
  // Cargar registros ZONA AREA

  function fetchTasks() {
    const accion = "buscarzona";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscarzona: search },
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_ZONA}">

            <td data-titulo="CODIGO" style="text-align:rigth;">${task.COD_ZONA}</td>
            <td data-titulo="NOMBRE" class="NOMBRE_T_ZONA_AREAS" style="text-align:rigth;">${task.NOMBRE_T_ZONA_AREAS}</td>
            <td data-titulo="FECHA" style="text-align:rigth;">${task.FECHA}</td>
            <td data-titulo="VERSION" style="text-align:rigth;">${task.VERSION}</td>

            <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_ZONA="${task.COD_ZONA}"><i class="icon-trash"></i></button></td>
            <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_ZONA="${task.COD_ZONA}"><i class="icon-edit"></i></button></td>

        </tr>`;
          });

          $("#tablita").html(template);
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

    var COD_ZONA = $(element).attr("taskId");

    const accion = "editar";

    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, cod_zona: COD_ZONA },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          const task = JSON.parse(response);

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
    // console.log(COD_ZONA);

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
