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
  $("#selectPrevilife").select2();
  //------------- Busqueda con ajax zonaArea----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      var search = $("#search").val();
      const accion = "bbuscarprevilif";
      $.ajax({
        url: "./c_almacen.php",
        type: "POST",
        data: { accion: accion, buscarlab: search },
        success: function (response) {
          // console.log(response);
          if (!response.error) {
            let tasks = JSON.parse(response);
            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.COD_PRODUCTO_PREVILIFE}">
                  <td data-titulo="CODIGO" style="text-align:rigth;">${task.COD_PRODUCTO_PREVILIFE}</td>
                  <td data-titulo="NOMBRE" class="DES_PRODUCTO" style="text-align:rigth;">${task.DES_PRODUCTO}</td>
                  <td data-titulo="ABREVIATURA" class="ABR_PRODUCTO_PREVILIFE" style="text-align:rigth;">${task.ABR_PRODUCTO_PREVILIFE}</td>
                  <td data-titulo="FECHA" style="text-align:rigth;">${task.FECHA_CREACION}</td>
                  <td data-titulo="VERSION" style="text-align:rigth;">${task.VERSION}</td>
                  <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_PRODUCTO_PREVILIFE="${task.COD_PRODUCTO_PREVILIFE}"><i class="icon-trash"></i></button></td>
                  <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_PRODUCTO_PREVILIFE="${task.COD_PRODUCTO_PREVILIFE}"><i class="icon-edit"></i></button></td>
              </tr>`;
            });
            $("#tablaPrevilife").html(template);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos de la tabla:", error);
        },
      });
    } else {
      fetchTasks();
    }
  });

  //------------- Añadiendo Previlife----------------//
  $("#formularioPrevilife").submit((e) => {
    e.preventDefault();

    const accion = edit === false ? "insertarprevilife" : "actualizarprevilife";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        valorSeleccionado: $("#selectPrevilife").val(),
        codigoPrev: $("#codigo_previlife").val(),
        codprev: $("#taskId").val(),
      },

      type: "POST",
      success: function (response) {
        if (response === "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#formularioPrevilife").trigger("reset");
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
              $("#formularioPrevilife").trigger("reset");
            }
          });
        }
        // console.log("RESPONSE" + response);
      },
    });
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //

  function fetchTasks() {
    const accion = "buscarprevilife";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscarPrevilife: search },
      success: function (response) {
        // console.log(response);
        if (!response.error) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_PRODUCTO_PREVILIFE}">
                <td data-titulo="CODIGO" style="text-align:rigth;">${task.COD_PRODUCTO_PREVILIFE}</td>
                <td data-titulo="NOMBRE" class="DES_PRODUCTO" style="text-align:rigth;">${task.DES_PRODUCTO}</td>
                <td data-titulo="ABREVIATURA" class="ABR_PRODUCTO_PREVILIFE" style="text-align:rigth;">${task.ABR_PRODUCTO_PREVILIFE}</td>
                <td data-titulo="FECHA" style="text-align:rigth;">${task.FECHA_CREACION}</td>
                <td data-titulo="VERSION" style="text-align:rigth;">${task.VERSION}</td>
                <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_PRODUCTO_PREVILIFE="${task.COD_PRODUCTO_PREVILIFE}"><i class="icon-trash"></i></button></td>
                <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_PRODUCTO_PREVILIFE="${task.COD_PRODUCTO_PREVILIFE}"><i class="icon-edit"></i></button></td>
            </tr>`;
          });
          $("#tablaPrevilife").html(template);
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
    var cod_producto_envase = $(element).attr("taskId");
    // console.log(cod_producto_envase);

    const accion = "editarLabsabell";

    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, cod_producto_envase: cod_producto_envase },
      type: "POST",
      success: function (response) {
        console.log(response);
        if (!response.error) {
          const task = JSON.parse(response);
          $("#codigo_labsabell").val(task.COD_PRODUCTO_ENVASE);
          $("#selectLabsabell").val(task.DES_PRODUCTO);
          $("#taskId").val(task.COD_PRODUCTO_ENVASE);
          edit = true;
        }
      },
    });
  });

  //------------------------ Elimina un dato de mi tabla ----------------- //

  $(document).on("click", ".task-delete", function (e) {
    e.preventDefault();
    // var COD_ZONA = $(this).data("COD_ZONA");

    var cod_producto_envase = $(this).attr("data-COD_PRODUCTO_ENVASE");
    const accion = "eliminarproductoenvase";
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
          url: "./c_almacen.php",
          data: { accion: accion, codenvaselabsabell: cod_producto_envase },
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
