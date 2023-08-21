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
      data: {
        accion: accion,
        selectInsumoEnvase: selectInsumoEnvase,
      },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          var insumos = JSON.parse(response);
          // console.log(insumos);

          let template = $("#tablaInsumosDatos").html();

          insumos.forEach((insumo) => {
            const existingRow = $(`tr[taskId="${insumo.COD_FORMULACION}"]`);
            const total =
              (insumo.CAN_FORMULACION_INSUMOS * cantidadInsumoEnvase) /
              insumo.CAN_FORMULACION;

            if (existingRow.length > 0) {
              const capturaValoresTabla = existingRow.find("td:eq(2)");

              capturaValoresTabla.each(function () {
                const valorCelda = parseFloat($(this).text());
                console.log("captura " + valorCelda);
              });
              console.log("total  " + total);
            } else {
              const total =
                (insumo.CAN_FORMULACION_INSUMOS * cantidadInsumoEnvase) /
                insumo.CAN_FORMULACION;

              template += `<tr taskId="${insumo.COD_FORMULACION}">
                              <td data-titulo="NOMBRE PRODUCTO">${insumo.DES_PRODUCTO_FORMULACION}</td>
                              <td data-titulo="CODIGO PRODUCTO">${insumo.DES_PRODUCTO}</td>
                              <td data-titulo="CANTIDAD">${total}</td>
                           </tr>`;
            }
          });
          $("#tablaInsumosDatos").html(template);

          $("#cantidadInsumoEnvase").val("");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  });
  //-------------------------------------------------------------------------//

  //--------------------- Insertar cantidades ------------//
  $("#botonInsertValor").click((e) => {
    e.preventDefault();
    let cantidadInsert = $("#cantidadInsumoEnvase").val();

    let valoresCapturados = [];

    $("#tablaInsumosDatos tr").each(function () {
      let valorCelda = $(this).find("td:eq(2)").text();
      valoresCapturados.push(valorCelda);
    });

    console.log("Valores capturados:", valoresCapturados);
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
