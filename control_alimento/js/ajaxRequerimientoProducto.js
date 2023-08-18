$(function () {
  // mostarRequerimientoProducto();
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

  $("#selectInsumoEnvase").select2();
  //------------- Busqueda con ajax infraestructura Accesorio----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      let search = $("#search").val();
      const accion = "buscarrequerimientoproducto";

      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarrequerimiento: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);

            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.COD_REQUERIMIENTO}">
      
                              <td data-titulo="CODIGO PRODUCTO" >${task.DES_PRODUCTO}</td>      
                              <td data-titulo="CANTIDAD" >${task.CANTIDAD}</td>
  
                          </tr>`;
            });

            $("#tablaRequerimientoProducto").html(template);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos de la tabla:", error);
        },
      });
    } else {
      mostarRequerimientoProducto();
    }
  });
  //-------------------------------------------------------------------------//

  //--------------------- Insertar los valores insumos y envases ------------//
  $("#botonCalcularInsumoEnvase").click((e) => {
    e.preventDefault();
    let selectInsumoEnvase = $("#selectInsumoEnvase").val();

    let cantidadInsumoEnvase = $("#cantidadInsumoEnvase").val();

    // console.log(selectInsumoEnvase);
    const accion = "mostrardatosinsumos";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, selectInsumoEnvase: selectInsumoEnvase },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          var insumos = JSON.parse(response);

          let template = ``;
          insumos.forEach((insumo) => {
            const cantidadNumerica = parseFloat(insumo.CAN_FORMULACION);
            const cantidadFormateada = cantidadNumerica.toFixed(3);
            template += `<tr taskId="${insumo.COD_FORMULACION}">
                            <td data-titulo="CODIGO PRODUCTO" >${insumo.DES_PRODUCTO}</td>
                            <td data-titulo="CANTIDAD" >${cantidadFormateada}</td>
                        </tr>`;
          });
          $("#tablaInsumosDatos").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  });
  //-------------------------------------------------------------------------//

  //------------- Añadiendo datos--------------------------------------------//
  // $("#formularioRequerimientoProducto").submit((e) => {
  //   e.preventDefault();
  //   const accion = "insertarrequerimientoproducto";

  //   $.ajax({
  //     url: "./c_almacen.php",
  //     data: {
  //       accion: accion,
  //       selectProductoCombo: $("#selectProductoCombo").val(),
  //       cantidadProducto: $("#cantidadProducto").val(),
  //     },
  //     type: "POST",
  //     success: function (response) {
  //       console.log(response);
  //       if (response == "ok") {
  //         Swal.fire({
  //           title: "¡Guardado exitoso!",
  //           text: "Los datos se han guardado correctamente.",
  //           icon: "success",
  //           confirmButtonText: "Aceptar",
  //         }).then((result) => {
  //           if (result.isConfirmed) {
  //             $("#selectProductoCombo").val("none").trigger("change");
  //             $("#formularioRequerimientoProducto").trigger("reset");

  //             mostarRequerimientoProducto();
  //           }
  //         });
  //       }
  //       // } else {
  //       //   Swal.fire({
  //       //     icon: "error",
  //       //     title: "Oops...",
  //       //     text: "Duplicado!",
  //       //     confirmButtonText: "Aceptar",
  //       //   }).then((result) => {
  //       //     if (result.isConfirmed) {
  //       //       fetchTasks();
  //       //       $("#formularioControl").trigger("reset");
  //       //     }
  //       //   });
  //       // }
  //     },
  //   });
  // });
  //----------------------------------------------------------------------- //
  //--Cargar registros requerimiento producto-------------------------------//

  // function mostarRequerimientoProducto() {
  //   const accion = "buscarrequerimientoproducto";
  //   const search = "";
  //   $.ajax({
  //     url: "./c_almacen.php",
  //     data: { accion: accion, buscarrequerimiento: search },
  //     type: "POST",
  //     success: function (response) {
  //       if (!response.error) {
  //         let tasks = JSON.parse(response);

  //         let template = ``;
  //         tasks.forEach((task) => {
  //           template += `<tr taskId="${task.COD_REQUERIMIENTO}">

  //                           <td data-titulo="CODIGO PRODUCTO" >${task.DES_PRODUCTO}</td>
  //                           <td data-titulo="CANTIDAD" >${task.CANTIDAD}</td>

  //                       </tr>`;
  //         });

  //         $("#tablaRequerimientoProducto").html(template);
  //       }
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error al cargar los datos de la tabla:", error);
  //     },
  //   });
  // }
  //-----------------------------------------------------------------------//
});
