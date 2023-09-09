$(function () {
  mostrarProduccionRequerimiento();

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

  function mostrarProduccionRequerimiento() {
    const accion = "mostrarproduccionrequerimiento";

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
            template += `<tr taskproduccionrequerimiento="${task.COD_REQUERIMIENTO}">
                              <td data-titulo='CODIGO' style="text-align:center;">${task.COD_REQUERIMIENTO}</td>
                              <td data-titulo='PRODUCTO' style="text-align:center;" codigoproducto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                              <td data-titulo='CANTIDAD' style="text-align:center;">${task.CANTIDAD}</td>
                              <td  style="text-align:center;"><button class="custom-icon" name="mostrarproduccionrequerimiento" id="mostrarproduccionrequerimiento"><i class="icon-circle-with-plus"></i></button></td>
                            </tr>`;
          });
          $("#tablaproduccionrequerimiento").html(template);
        } else {
          $("#tablaproduccionrequerimiento").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  $(document).on("click", "#mostrarproduccionrequerimiento", (e) => {
    e.preventDefault();
    let capturaTr = $(e.currentTarget).closest("tr");
    let codigoproducto = capturaTr.find("td:eq(1)").attr("codigoproducto");
    let nombreproducto = capturaTr.find("td:eq(1)").text();
    let cantidadrequerimientototal = capturaTr.find("td:eq(2)").text();

    let cod_produccion_requerimiento = capturaTr.attr(
      "taskproduccionrequerimiento"
    );

    $("#idhiddencodrequerimiento").val(cod_produccion_requerimiento);
    $("#idhiddenproducto").val(codigoproducto);
    $("#productorequerimientoitem").val(nombreproducto);
    $("#cantidadhiddentotalrequerimiento").val(cantidadrequerimientototal);
  });
  /* -------------------- Cuando escribe en cantidad de caja con decimal lanza alerta --------------- */
  $("#cantidadcaja").keyup((e) => {
    e.preventDefault();
    let cantidadescrita = $("#cantidadcaja").val();
    const regex = /\d+\./;

    if (regex.test(cantidadescrita)) {
      Swal.fire({
        icon: "error",
        title: "Valor decimal",
        text: "Por favor, ingresa valores enteros en cantidad",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadcaja").val("");
        }
      });
      return;
    }
  });
  /* ------------------------------  Inserta los datos de produccion---------------------------- */
  $("#insertarProduccionRequerimiento").click((e) => {
    e.preventDefault();
    let codrequerimientoproduccion = $("#idhiddencodrequerimiento").val();
    let codproductoproduccion = $("#idhiddenproducto").val();
    let productorequerimientoitem = $("#productorequerimientoitem").val();
    let numeroproduccion = $("#numeroproduccion").val();
    let cantidadtotalproduccion = $("#cantidadhiddentotalrequerimiento").val();
    let fechainicio = $("#fechainicio").val();
    let fechavencimiento = $("#fechavencimiento").val();
    let textAreaObservacion = $("#textAreaObservacion").val();
    let cantidadcaja = $("#cantidadcaja").val();
    // console.log(codproductoproduccion);
    if (productorequerimientoitem === "") {
      Swal.fire({
        title: "¡Error!",
        text: "Selecciona un producto.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return;
    }

    if (numeroproduccion === "") {
      Swal.fire({
        title: "¡Error!",
        text: "Añadir numero de produccion.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return;
    }
    if (fechainicio === "") {
      Swal.fire({
        title: "¡Error!",
        text: "Añadir fecha de inicio.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return;
    }

    if (fechavencimiento === "") {
      Swal.fire({
        title: "¡Error!",
        text: "Añadir fecha de vencimiento.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return;
    }

    if (parseFloat(cantidadcaja) <= 0) {
      Swal.fire({
        icon: "error",
        title: "Campo negativo",
        text: "Por favor, ingrese valor positivo en cantidad de cajas",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadcaja").val("");
        }
      });
      return;
    }
    const accion = "insertarproducciontotal";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        codrequerimientoproduccion: codrequerimientoproduccion,
        codproductoproduccion: codproductoproduccion,
        numeroproduccion: numeroproduccion,
        cantidadtotalproduccion: cantidadtotalproduccion,
        fechainicio: fechainicio,
        textAreaObservacion: textAreaObservacion,
        cantidadcaja: cantidadcaja,
        fechavencimiento: fechavencimiento,
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
              mostrarProduccionRequerimiento();
              $("#idhiddencodrequerimiento").val("");
              $("#idhiddenproducto").val("");
              $("#productorequerimientoitem").val("");
              $("#numeroproduccion").val("");
              $("#cantidadhiddentotalrequerimiento").val("");
              $("#fechainicio").val("");
              $("#fechavencimiento").val("");
              $("#textAreaObservacion").val("");
              $("#cantidadcaja").val("20");
            }
          });
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
    });
  });

  // function mostrarRequerimientoTotal() {
  //   const accion = "mostrarRquerimientoTotal";
  //   const search = "";
  //   $.ajax({
  //     url: "./c_almacen.php",
  //     type: "POST",
  //     data: { accion: accion, buscartotal: search },
  //     success: function (response) {
  //       if (isJSON(response)) {
  //         let tasks = JSON.parse(response);
  //         console.log(tasks);

  //         let template = ``;
  //         tasks.forEach((task) => {
  //           $resultado = Math.ceil(
  //             task.STOCK_RESULTANTE / task.CANTIDAD_MINIMA
  //           );
  //           $resultadototalinsu = task.CANTIDAD_MINIMA * $resultado;
  //           template += `<tr taskId="${task.COD_REQUERIMIENTO}">
  //                   <td data-titulo="INSUMOS">${task.DES_PRODUCTO}</td>
  //                   <td data-titulo="CANTIDAD">${task.STOCK_RESULTANTE}</td>
  //                   <td data-titulo="CANTIDAD COMPRA">${$resultadototalinsu}</td>
  //                </tr>`;
  //         });
  //         $("#tablatotalinsumosrequeridos").html(template);
  //       } else {
  //         $("#tablatotalinsumosrequeridos").empty();
  //       }
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error al cargar los datos de la tabla:", error);
  //     },
  //   });
  // }
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
