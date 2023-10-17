$(function () {
  mostrarProduccionRequerimiento();

  //===== Prealoder

  window.onload = function () {
    fadeout();
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

  const dia = fechaActual.getDate();
  const mes = fechaActual.getMonth() + 1;
  const ano = fechaActual.getFullYear();

  const fechaActualFormato = `${ano}-${mes.toString().padStart(2, "0")}-${dia
    .toString()
    .padStart(2, "0")}`;

  document.getElementById("fechainicio").value = fechaActualFormato;

  fechaActual.setDate(fechaActual.getDate() - 3);
  const anoActual = fechaActual.getFullYear();
  const mesActual = fechaActual.getMonth() + 1;
  const diaActual = fechaActual.getDate();

  const fechaMinima = `${anoActual}-${mesActual
    .toString()
    .padStart(2, "0")}-${diaActual.toString().padStart(2, "0")}`;
  document.getElementById("fechainicio").setAttribute("min", fechaMinima);

  var fechaAct = new Date();
  var siguienteAnio = fechaAct.getFullYear() + 1;

  var fechaMin = new Date(siguienteAnio, 0, 1);
  var fechaMinimaFormato = fechaMin.toISOString().slice(0, 10);
  var fechvencimin = document
    .getElementById("fechavencimiento")
    .setAttribute("min", fechaMinimaFormato);

  $("#fechainicio").on("blur", function () {
    var fechaProduc = $(this).val();
    var fechaActual = new Date();
    fechaActual.setDate(fechaActual.getDate() - 3);
    var fechaLimite = fechaActual.toISOString().split("T")[0];

    if (fechaProduc < fechaLimite) {
      Swal.fire({
        icon: "error",
        title: "Error de fecha ingresada",
        text: "La fecha es menor a la fecha actual o está dentro de los últimos 3 días.",
      });
      document.getElementById("fechainicio").value = fechaActualFormato;
    }
    $("#fechavencimiento").val("");
  });

  /*------------------------------ */

  $("#fechavencimiento").on("blur", function () {
    var fechaVencimiento = new Date($(this).val());
    var fechaActual = new Date();
    var siguienteAnio = new Date(fechaActual);
    siguienteAnio.setFullYear(siguienteAnio.getFullYear() + 1);

    if (fechaVencimiento < fechaActual) {
      Swal.fire({
        icon: "error",
        title: "Error de fecha vencimiento",
        text: "La fecha es menor a la fecha producción",
      });
      $(this).val("");
    }
  });
  // $("#fechainicio").change(function () {
  //   var fechaProduccion = $(this).val();
  //   $("#fechavencimiento").attr("min", fechaProduccion);
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
          // document.getElementById("fechainicio").value = fechaMinima;
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
              // document.getElementById("fechainicio").value = fechaMinima;
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
