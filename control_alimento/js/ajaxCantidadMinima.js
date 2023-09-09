$(function () {
  let edit = false;
  fetchTasks();
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

  $("#selectCantidadminima").select2();

  /*-----------------------Añadiendo valores ---------------------*/
  $(document).on("click", "#botonminimo", (e) => {
    e.preventDefault();
    let selectCantidadminima = $("#selectCantidadminima").val();
    let cantidadMinima = $("#cantidadMinima").val();

    const accion =
      edit === false ? "insertarcantidadminima" : "actualizarcantidadminima";
    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        selectCantidadminima: selectCantidadminima,
        cantidadMinima: cantidadMinima,
        codminimo: $("#taskId").val(),
      },

      type: "POST",
      success: function (response) {
        console.log(response);
        if (response.toLowerCase() === "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#selectCantidadminima").val("none").trigger("change");
              $("#selectCantidadminima").prop("disabled", false);
              $("#formulariocantidadminima").trigger("reset");
            }
          });
        } else {
          Swal.fire({
            title: "Duplicado",
            text: "Los datos del producto son duplicados.",
            icon: "error",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#selectCantidadminima").val("none").trigger("change");
              $("#selectCantidadminima").prop("disabled", false);
              $("#formulariocantidadminima").trigger("reset");
            }
          });
        }
      },
    });
  });
  //----------------------------------------------------------------//
  //------------------------ Actualiza un dato de mi tabla ----------------- //

  $(document).on("click", ".task-update", () => {
    var element = $(this)[0].activeElement.parentElement.parentElement;

    var cod_mini = $(element).attr("taskId");

    const accion = "editarcantidadminima";

    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, cod_mini: cod_mini },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          const task = JSON.parse(response);

          $("#selectCantidadminima").prop("disabled", true);
          $("#selectCantidadminima").append(
            new Option(task.DES_PRODUCTO, task.DES_PRODUCTO, true, true)
          );
          $("#cantidadMinima").val(task.CANTIDAD_MINIMA);
          $("#taskId").val(task.COD_CANTIDAD_MINIMA);
          edit = true;
        }
      },
    });
  });

  //------------------------ Elimina un dato de mi tabla ----------------- //

  $(document).on("click", ".task-delete", function (e) {
    e.preventDefault();
    // var COD_ZONA = $(this).data("COD_ZONA");

    var cod_cantidad_min = $(this).attr("data-COD_CANTIDAD_MINIMA");
    const accion = "eliminarcantidadminima";

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
          data: { accion: accion, cod_cantidad_min: cod_cantidad_min },
          type: "POST",
          success: function (response) {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Registro eliminado correctamente.",
              showConfirmButton: false,
              timer: 1500,
            });
            fetchTasks();
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });
      }
    });
  });
  /*-----------------------Cargar datos en cantidad minima ---------------------*/
  function fetchTasks() {
    const accion = "buscarCantidadminima";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscarcantidadminimasearch: search },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_CANTIDAD_MINIMA}">

            <td data-titulo="INSUMOS">${task.DES_PRODUCTO}</td>
            <td data-titulo="CANTIDAD">${task.CANTIDAD_MINIMA}</td>

            <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_CANTIDAD_MINIMA="${task.COD_CANTIDAD_MINIMA}"><i class="icon-trash"></i></button></td>
            <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_CANTIDAD_MINIMA="${task.COD_CANTIDAD_MINIMA}"><i class="icon-edit"></i></button></td>

        </tr>`;
          });

          $("#tablacantidadminima").html(template);
        } else {
          $("#tablacantidadminima").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
