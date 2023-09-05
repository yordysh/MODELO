$(function () {
  mostrarPendientes();
  mostrarRequerimientoTotal();

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

  function mostrarPendientes() {
    const accion = "buscarpendientesrequeridostotal";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion },
      success: function (response) {
        // console.log(response);
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_REQUERIMIENTO}">
                            <td data-titulo='CODIGO' style="text-align:center;">${task.COD_REQUERIMIENTO}</td>
                            <td data-titulo='CODIGO' style="text-align:center;">${task.FECHA}</td>
                            <td data-titulo='PENDIENTE' style="text-align:center;"><button class="custom-icon" name="mostrarinsumos" id="mostrarInsumosRequerimiento"><i class="icon-circle-with-plus"></i></button></td>
                          </tr>`;
          });
          $("#tablamostartotalpendientes").html(template);
        } else {
          $("#tablamostartotalpendientes").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  $(document).on("click", "#mostrarInsumosRequerimiento", (e) => {
    e.preventDefault();
    let capturaTr = $(e.currentTarget).closest("tr");

    let cod_formulacion = capturaTr.attr("taskId");

    const accionproductorequerimiento = "mostrarproductoporrequerimiento";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accionproductorequerimiento,
        cod_formulacion: cod_formulacion,
      },
      success: function (response) {
        // console.log(JSON.parse(response));
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          // console.log(tasks);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr codigorequerimiento="${task.COD_REQUERIMIENTO}">
                            <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CANTIDAD"  style="text-align:center;">${task.CANTIDAD}</td>
                            </tr>`;
          });
          $("#tablaproductorequerido").html(template);
        } else {
          $("#tablaproductorequerido").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });

    const accionproductoinsumo = "mostrarproductoinsumorequerimiento";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accionproductoinsumo,
        cod_formulacion: cod_formulacion,
      },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          // console.log(tasks);
          let template = ``;

          tasks.forEach((task) => {
            template += `<tr codigorequerimiento="${task.COD_REQUERIMIENTO}">
                            <td data-titulo="INSUMOS"  style="text-align:center;" id_producto='${
                              task.COD_PRODUCTO
                            }'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CANTIDAD"  style="text-align:center;">${parseFloat(
                              task.CANTIDAD
                            ).toFixed(2)}</td>
                            </tr>`;
          });
          $("#tablainsumorequerido").html(template);
        } else {
          $("#tablainsumorequerido").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });

    // $("#taskcodrequerimiento").val(cod_formulacion);
    const accionsihaycompra = "mostrarsihaycompra";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accionsihaycompra,
        cod_formulacion: cod_formulacion,
      },
      success: function (response) {
        console.log(JSON.parse(response));
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          let template = ``;

          tasks.forEach((task) => {
            // let insumo_pedir = task.SUMA_CANTIDADES - task.STOCK_ACTUAL;
            let insumo_pedir = (
              task.SUMA_CANTIDADES - task.STOCK_ACTUAL
            ).toFixed(3);

            if (insumo_pedir > 0) {
              template += `<tr codigorequerimientototal="${task.COD_REQUERIMIENTO}">
                            <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CANTIDAD"  style="text-align:center;">${insumo_pedir}</td>
                            <td data-titulo="CANTIDAD COMPRA"  style="text-align:center;">${insumo_pedir}</td>
                          </tr>`;
            }
          });

          if (template === "") {
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Insumos completos en el almacen",
              showConfirmButton: false,
              timer: 2500,
            });
          } else {
            $("#tablatotalinsumosrequeridoscomprar").html(template);
          }
        } else {
          $("#tablatotalinsumosrequeridoscomprar").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });

    // const accion = "mostrarseguncodformulacion";
    // $.ajax({
    //   url: "./c_almacen.php",
    //   type: "POST",
    //   data: {
    //     accion: accion,
    //     cod_formulacion: cod_formulacion,
    //   },
    //   success: function (response) {
    //     console.log(response);
    //     // if (isJSON(response)) {
    //     //   let tasks = JSON.parse(response);
    //     //   console.log(tasks);

    //     //   let template = ``;
    //     //   tasks.forEach((task) => {
    //     //     const insumo_pedir = task.CANTIDAD_TOTAL - task.STOCK_ACTUAL;
    //     //     if (insumo_pedir > 0) {
    //     //       template += `<tr codigorequerimiento="${task.COD_REQUERIMIENTO}">
    //     //                     <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
    //     //                     <td data-titulo="CANTIDAD"  style="text-align:center;">${insumo_pedir}</td>
    //     //                   </tr>`;
    //     //     }
    //     //   });
    //     //   $("#tablainsumorequerido").html(template);
    //     // } else {
    //     //   $("#tablainsumorequerido").html(template);
    //     // }
    //   },
    //   error: function (xhr, status, error) {
    //     console.error("Error al cargar los datos de la tabla:", error);
    //   },
    // });
  });

  $("#insertarCompraInsumos").click((e) => {
    e.preventDefault();

    let valoresCapturadosVenta = [];
    // let taskcodvalor = $("#taskcodrequerimiento").val().trim();

    let idRequerimiento = $("#tablaproductorequerido tr").attr(
      "codigorequerimiento"
    );
    console.log(idRequerimiento);
    let tablainsumorequerido = $("#tablaproductorequerido");
    let tablainsumos = $("#tablainsumorequerido");
    let tablatotal = $("#tablatotalinsumosrequeridoscomprar");
    // let taskcodrequerimiento = $("#taskcodrequerimiento").val();

    $("#tablatotalinsumosrequeridoscomprar tr").each(function () {
      let id_producto_insumo = $(this).find("td:eq(0)").attr("id_producto");
      let cantidad_producto_insumo = $(this).find("td:eq(1)").text();

      valoresCapturadosVenta.push(id_producto_insumo, cantidad_producto_insumo);
    });

    // if (taskcodvalor === "" && observacioncompra == "") {
    //   Swal.fire({
    //     title: "¡Error!",
    //     text: "Añadir los pendientes para guardar.",
    //     icon: "error",
    //     confirmButtonText: "Aceptar",
    //   });
    //   return;
    // }
    const accion = "insertarordencompraitem";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        union: valoresCapturadosVenta,
        idRequerimiento: idRequerimiento,
      },
      success: function (response) {
        console.log("respuesta" + response);
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#taskcodrequerimiento").val("");
              tablainsumorequerido.empty();
              tablainsumos.empty();
              tablatotal.empty();
              mostrarRequerimientoTotal();
              mostrarPendientes();
            }
          });
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
    });
  });

  function mostrarRequerimientoTotal() {
    const accion = "mostrarRquerimientoTotal";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscartotal: search },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          console.log(tasks);

          let template = ``;
          tasks.forEach((task) => {
            $resultado = Math.ceil(
              task.STOCK_RESULTANTE / task.CANTIDAD_MINIMA
            );
            $resultadototalinsu = task.CANTIDAD_MINIMA * $resultado;
            // console.log("object");
            // console.log($resultadototalinsu);
            template += `<tr taskId="${task.COD_REQUERIMIENTO}">
                  <td data-titulo="INSUMOS">${task.DES_PRODUCTO}</td>
                  <td data-titulo="CANTIDAD">${task.STOCK_RESULTANTE}</td>
                  <td data-titulo="CANTIDAD COMPRA">${resultadototalinsu}</td>                    
               </tr>`;
          });
          $("#tablatotalinsumosrequeridos").html(template);
        } else {
          $("#tablatotalinsumosrequeridos").empty();
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
