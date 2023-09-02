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
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscarpendiente: search },
      success: function (response) {
        // console.log(response);
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_REQUERIMIENTO}">
                            <td data-titulo="CODIGO" >${task.COD_REQUERIMIENTO}</td>
                            <td data-titulo="PRODUCTO" >${task.DES_PRODUCTO}</td>
                            <td style="text-align:center;"><button class="custom-icon" name="mostrarinsumos" id="mostrarInsumosRequerimiento"><i class="icon-circle-with-plus"></i></button></td>
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
    console.log(cod_formulacion);

    var tabla = document.getElementById("tinsumorequerido");
    if (tabla.style.display === "none") {
      tabla.style.display = "table";
    } else {
      tabla.style.display = "none";
    }

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
        // if (isJSON(response)) {
        //   let tasks = JSON.parse(response);
        //   console.log(tasks);
        //   let template = ``;
        //   tasks.forEach((task) => {
        //     const insumo_pedir = task.CANTIDAD_TOTAL - task.STOCK_ACTUAL;
        //     if (insumo_pedir > 0) {
        //       template += `<tr codigorequerimiento="${task.COD_REQUERIMIENTO}">
        //                     <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
        //                     <td data-titulo="CANTIDAD"  style="text-align:center;">${insumo_pedir}</td>
        //                   </tr>`;
        //     }
        //   });
        //   $("#tablainsumorequerido").html(template);
        // } else {
        //   $("#tablainsumorequerido").html(template);
        // }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });

    const accion = "mostrarseguncodformulacion";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        cod_formulacion: cod_formulacion,
      },
      success: function (response) {
        console.log(response);
        // if (isJSON(response)) {
        //   let tasks = JSON.parse(response);
        //   console.log(tasks);

        //   let template = ``;
        //   tasks.forEach((task) => {
        //     const insumo_pedir = task.CANTIDAD_TOTAL - task.STOCK_ACTUAL;
        //     if (insumo_pedir > 0) {
        //       template += `<tr codigorequerimiento="${task.COD_REQUERIMIENTO}">
        //                     <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
        //                     <td data-titulo="CANTIDAD"  style="text-align:center;">${insumo_pedir}</td>
        //                   </tr>`;
        //     }
        //   });
        //   $("#tablainsumorequerido").html(template);
        // } else {
        //   $("#tablainsumorequerido").html(template);
        // }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  });

  $("#insertarCompraInsumos").click((e) => {
    e.preventDefault();
    let observacioncompra = $("#observacionCompra").val();
    let valoresCapturadosVenta = [];
    let taskcodvalor = $("#taskcodrequerimiento").val().trim();

    let idRequerimiento = $("#tablainsumorequerido tr").attr(
      "codigorequerimiento"
    );
    let tablainsumorequerido = $("#tablainsumorequerido");
    let taskcodrequerimiento = $("#taskcodrequerimiento").val();

    $("#tablainsumorequerido tr").each(function () {
      let id_producto_insumo = $(this).find("td:eq(0)").attr("id_producto");
      let cantidad_producto_insumo = $(this).find("td:eq(1)").text();

      valoresCapturadosVenta.push(id_producto_insumo, cantidad_producto_insumo);
    });

    if (taskcodvalor === "" && observacioncompra == "") {
      Swal.fire({
        title: "¡Error!",
        text: "Añadir los pendientes para guardar.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return;
    }
    const accion = "insertarordencompraitem";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        union: valoresCapturadosVenta,
        idRequerimiento: idRequerimiento,
        observacioncompra: observacioncompra,
        taskcodrequerimiento: taskcodrequerimiento,
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
              $("#observacionCompra").val("");
              $("#taskcodrequerimiento").val("");
              tablainsumorequerido.empty();
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
            template += `<tr taskId="${task.COD_REQUERIMIENTO}">
                  <td data-titulo="INSUMOS">${task.DES_PRODUCTO}</td>
                  <td data-titulo="CANTIDAD">${task.STOCK_RESULTANTE}</td>
                  <td data-titulo="CANTIDAD COMPRA">${$resultadototalinsu}</td>                    
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
