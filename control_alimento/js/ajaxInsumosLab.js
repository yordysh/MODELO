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
      const accion = "buscarInsumosLab";
      $.ajax({
        url: "./c_almacen.php",
        type: "POST",
        data: { accion: accion, buscarInsumos: search },
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);
            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.COD_PRODUCTO_INSUMOS}">
                  <td data-titulo="CODIGO" style="text-align:rigth;">${task.COD_PRODUCTO_INSUMOS}</td>
                  <td data-titulo="NOMBRE" class="DES_PRODUCTO" style="text-align:rigth;">${task.DES_PRODUCTO}</td>
                  <td data-titulo="ABREVIATURA" class="ABR_PRODUCTO" style="text-align:rigth;">${task.ABR_PRODUCTO}</td>
                  <td data-titulo="FECHA" style="text-align:rigth;">${task.FECHA_CREACION}</td>
                  <td data-titulo="VERSION" style="text-align:rigth;">${task.VERSION}</td>
                  <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_PRODUCTO_INSUMOS="${task.COD_PRODUCTO_INSUMOS}"><i class="icon-trash"></i></button></td>
                  <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_PRODUCTO_INSUMOS="${task.COD_PRODUCTO_INSUMOS}"><i class="icon-edit"></i></button></td>
              </tr>`;
            });
            $("#tablaInsumosLab").html(template);
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

  $("#selectPrevilife").select2();
  //------------- Busqueda con COMBO PRODUCTO----------------//
  // $(document).ready(function () {
  //   $("#nombre_insumos_lab").autocomplete({
  //     source: function (request, response) {
  //       const accion = "buscarProductoComboInsumos";

  //       $.ajax({
  //         url: "./c_almacen.php",
  //         method: "POST",
  //         dataType: "json",
  //         data: {
  //           accion: accion,
  //           term: request.term,
  //         },
  //         success: function (data) {
  //           if (!data) {
  //             $("#task_insumos_lab").val("");
  //           }
  //           response(data);
  //         },
  //       });
  //     },
  //     select: function (event, ui) {
  //       console.log(ui.item.id);
  //       $("#task_insumos_lab").val(ui.item.id);
  //     },
  //     close: function () {
  //       const searchTerm = $("#nombre_insumos_lab").val().trim();

  //       if (searchTerm === "") {
  //         $("#task_insumos_lab").val("");
  //       }
  //     },
  //   });
  // });
  //------------- Añadiendo INSUMOS LABSABELL----------------//
  $("#formularioInsumosLab").submit((e) => {
    e.preventDefault();

    const accion =
      edit === false ? "insertarinsumoslab" : "actualizarinsumoslab";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        codigoInsumosLab: $("#codigo_insumos_lab").val(),
        // valorSeleccionado: $("#task_insumos_lab").val(),
        valorSeleccionado: $("#selectPrevilife").val(),
        codigoInsumo: $("#codigo_insumos_lab").val(),
        codInsu: $("#taskId").val(),
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
              $("#formularioInsumosLab").trigger("reset");
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
              $("#formularioInsumosLab").trigger("reset");
            }
          });
        }
      },
    });
  });

  //---------------------- Cargar registros INSUMOS LABSABELL-----------//

  function fetchTasks() {
    const accion = "buscarInsumosLab";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscarInsumos: search },
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_PORDUCTO_INSUMOS}">
                <td data-titulo="CODIGO" style="text-align:rigth;">${task.COD_PORDUCTO_INSUMOS}</td>
                <td data-titulo="NOMBRE" class="DES_PRODUCTO" style="text-align:rigth;">${task.DES_PRODUCTO}</td>
                <td data-titulo="ABREVIATURA" class="ABR_PRODUCTO" style="text-align:rigth;">${task.ABR_PRODUCTO}</td>
                <td data-titulo="FECHA" style="text-align:rigth;">${task.FECHA_CREACION}</td>
                <td data-titulo="VERSION" style="text-align:rigth;">${task.VERSION}</td>
                <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_PRODUCTO_INSUMOS="${task.COD_PRODUCTO_INSUMOS}"><i class="icon-trash"></i></button></td>
                <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_PRODUCTO_INSUMOS="${task.COD_PRODUCTO_INSUMOS}"><i class="icon-edit"></i></button></td>
            </tr>`;
          });
          $("#tablaInsumosLab").html(template);
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
    var cod_insumos_lab = $(element).attr("taskId");

    const accion = "editarInsumosLab";

    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, cod_insumos_lab: cod_insumos_lab },
      type: "POST",
      success: function (response) {
        console.log(response);
        if (!response.error) {
          const task = JSON.parse(response);
          $("#codigo_insumos_lab").val(task.COD_PRODUCTO_INSUMOS);
          $("#nombre_insumos_lab").val(task.DES_PRODUCTO);
          $("#taskId").val(task.COD_PRODUCTO_INSUMOS);
          edit = true;
        }
      },
    });
  });

  //------------------------ Elimina un dato de mi tabla ----------------- //

  $(document).on("click", ".task-delete", function (e) {
    e.preventDefault();

    var cod_insumos_lab = $(this).attr("data-COD_PRODUCTO_INSUMOS");
    const accion = "eliminarinsumolab";

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
          data: { accion: accion, codinsumoslab: cod_insumos_lab },
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
