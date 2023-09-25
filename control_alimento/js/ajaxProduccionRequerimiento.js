$(function () {
  mostrarProduccionRequerimiento();

  //===== Prealoder

  window.onload = function () {
    window.setTimeout(fadeout, 500);
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //-------------------------------------------//

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
  /* -----------------------Bloquea las fechas marcadas------------------------- */

  /*fecha ingresada menor a la actual */
  const fechaActual = new Date();
  const anoActual = fechaActual.getFullYear();
  const fechaMinima = `${anoActual}-01-01`;

  document.getElementById("fechainicio").setAttribute("min", fechaMinima);
  document.getElementById("fechainicio").setAttribute("min", fechaMinima);

  $("#fechainicio").on("input", function () {
    var fechaProduc = $(this).val();
    var fechaActual = new Date().toISOString().split("T")[0];

    if (fechaProduc < fechaActual) {
      // $(this).val(currentDate);
      Swal.fire({
        icon: "error",
        title: "Error de fecha ingresada",
        text: "La fecha es menor a la fecha actual",
      });
      $(this).val("");
    }
    $("#fechavencimiento").val("");
  });

  /*------------------------------ */

  $("#fechavencimiento").on("input", function () {
    var fechaVencimiento = $(this).val();
    var fechaActual = new Date().toISOString().split("T")[0];

    if (fechaVencimiento < fechaActual) {
      Swal.fire({
        icon: "error",
        title: "Error de fecha vencimiento",
        text: "La fecha es menor a la fecha producción",
      });
      $(this).val("");
    }
  });
  $("#fechainicio").change(function () {
    var fechaProduccion = $(this).val();
    $("#fechavencimiento").attr("min", fechaProduccion);
  });

  // $("#fechainicio").on("input", function () {
  //   var fechaInicio = new Date($(this).val());
  //   var currentYear = new Date().getFullYear();

  //   if (
  //     fechaInicio.getFullYear() === currentYear &&
  //     fechaInicio.getMonth() === 11
  //   ) {
  //     // 11 representa diciembre (los meses en JavaScript son 0-indexados)
  //     var nextYear = currentYear + 1;
  //     $(this).attr("max", nextYear + "-12-31");
  //   } else {
  //     $(this).attr("max", currentYear + "-12-31");
  //   }
  // });
  /* -------------------------------------------------------------------------- */

  /*--------------------------Mostrar tabla principal pendientes-------------- */
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
  /*-------------------------------------------------------------------------- */

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
    if (capturaTr) {
      Swal.fire({
        title: "¡Se añadio correctamente!",
        text: "Los datos se añadieron correctamente al formulario.",
        icon: "success",
        confirmButtonText: "Aceptar",
      }).then((result) => {
        if (result.isConfirmed) {
          $("#numeroproduccion").val("");
          $("#fechainicio").val("");
          $("#fechavencimiento").val("");
          $("#textAreaObservacion").val("");
          $("#cantidadcaja").val("20");
        }
      });
    }
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
    let codpersonal = $("#codpersonal").val();
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
    if (textAreaObservacion === "") {
      Swal.fire({
        title: "¡Error!",
        text: "Añadir la observación.",
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
        codpersonal: codpersonal,
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
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
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
