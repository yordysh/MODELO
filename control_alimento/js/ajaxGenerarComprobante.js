$(function () {
  //===== Prealoder===============================//

  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //-------------------------------------------//

  cargarOrdenCompraComprobante();
  cargarcambiosunat();

  /*------------------------- PONER LA HORA ACTUAL --------------------*/
  function actualizarHora() {
    var ahora = new Date();
    var horaActual = ahora.getHours();
    var minutosActuales = ahora.getMinutes();
    var horaYMinutos =
      horaActual + ":" + (minutosActuales < 10 ? "0" : "") + minutosActuales;

    $("#hora").val(horaYMinutos);
  }

  actualizarHora();
  setInterval(actualizarHora, 100);
  /*----------------------------------------------------------------- */

  /*----------------------MOSTRAR LA ORDEN DE COMPRA--------------- */
  function cargarOrdenCompraComprobante() {
    const accion = "mostrarcompracomprobante";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr id_orden_compra='${task.COD_ORDEN_COMPRA}'>
                            <td data-titulo='ORDEN' style='text-align: center;'>${task.COD_TMPCOMPROBANTE}</td>
                            <td data-titulo='FECHA' style='text-align: center;'>${task.FECHA_REALIZADA}</td>
                            <td data-titulo='PROVEEDOR' style='text-align: center;'>${task.NOM_PROVEEDOR}</td>
                            <td data-titulo='EMPRESA' style='text-align: center;'>${task.NOMBRE}</td>
                            <td style="text-align:center;"><button class="custom-icon"  id="clickcomprobante"><i class="icon-check"></i></button></td>
                          </tr>`;
          });
          $("#tablamostarcomprobante").html(template);
        } else {
          $("#tablamostarcomprobante").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
  /*-------------------------------------------------------------- */

  /* -----------------------Bloquea las fechas marcadas------------------------- */

  let fechaActual = new Date().toISOString().split("T")[0];
  $("#fecha_emision").val(fechaActual);
  $("#fecha_emision").attr("min", fechaActual);
  $("#fecha_emision").on("blur", function () {
    var fechaemision = $(this).val();

    if (fechaemision < fechaActual) {
      Swal.fire({
        icon: "error",
        title: "Error de fecha ingresada",
        allowOutsideClick: false,
        text: "La fecha es menor a la fecha actual.",
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById("fecha_emision").value = fechaActual;
        }
      });
    }
  });

  $("#fecha_entrega").val(fechaActual);
  $("#fecha_entrega").attr("min", fechaActual);
  $("#fecha_entrega").on("blur", function () {
    var fechaentrega = $(this).val();

    if (fechaentrega < fechaActual) {
      Swal.fire({
        icon: "error",
        title: "Error de fecha ingresada",
        allowOutsideClick: false,
        text: "La fecha de entrega es menor a la fecha actual.",
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById("fecha_entrega").value = fechaActual;
        }
      });
    }
  });
  /*--------------------------------------------------------------------------- */

  /*------------------------------DARLE CLICK EN DOLARES ---------------------- */
  $("#selectmoneda").on("input", function () {
    let tipomonedacambio = $("#selectmoneda").val();
    if (tipomonedacambio === "D") {
      $("#tipocambio").prop("disabled", false);
    } else {
      $("#tipocambio").prop("disabled", true);
    }
  });

  /*---------------------------------------------------------------------------*/

  /*---------------------MOSTRAR EN ALGUNOS CAMPOS---------------- */
  $(document).on("click", "#clickcomprobante", (e) => {
    e.preventDefault();

    Swal.fire({
      icon: "success",
      title: "Se añadio datos",
      text: "Se puso los datos correctos.",
    });

    let filafactura = $(e.target).closest("tr");
    let codigoComprobante = filafactura.find("td:eq(0)").text();
    // console.log(codigoComprobante);
    $("#codigoorden").val(codigoComprobante);

    let oficina = $("#vroficina").val();
    let codigopersonal = $("#codpersonal").val();

    const accion = "ponercomprobantefactura";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        codigoComprobante: codigoComprobante,
        oficina: oficina,
        codigopersonal: codigopersonal,
      },
      success: function (response) {
        let lista = JSON.parse(response);
        $("#selectempresa").val(lista[0].COD_EMPRESA);
        $("#proveedor").val(lista[0].NOM_PROVEEDOR);
        $("#selectformapago").val(lista[0].F_PAGO);
        $("#selectmoneda").val(lista[0].TIPO_MONEDA);
        $("#personal").val(lista[0].NOM_PERSONAL1);
        $("#fecha_emision").val(fechaActual);
        $("#fecha_emision").attr("min", fechaActual);
        $("#fecha_entrega").val(fechaActual);
        $("#fecha_entrega").attr("min", fechaActual);
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });

    let codpersonalusu = $("#codpersonal").val();
    const accionpersonal = "ponerpersonalentrante";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accionpersonal, codpersonalusu: codpersonalusu },
      success: function (response) {
        if (isJSON(response)) {
          let listaresponse = JSON.parse(response);

          $("#personal").val(listaresponse[0].NOM_PERSONAL);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });

    // let filafactura = $(e.target).closest("tr");
    // let idcomprobantefac = filafactura.find("td:eq(0)").text();

    const accionfactura = "ponervaloresacomprarfactura";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accionfactura,
        codigoComprobantemostrar: codigoComprobante,
      },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr">
            <td data-titulo="NOMBRE" style='text-align:center;'>${task.DES_PRODUCTO}</td>
            <td data-titulo="CANTIDAD" style='text-align:center;'>${task.CANTIDAD_MINIMA}</td>
            <td data-titulo="PRECIO" style='text-align:center;'>${task.MONTO}</td>
        </tr>`;
          });

          $("#tablainsumoscomprarfactura").html(template);
        } else {
          $("#tablainsumoscomprarfactura").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  });
  /*------------------------------------------------------------- */
  /*----------------------AL SELECCIONAR EN DOLARES-----------------*/
  // $("#selectmoneda").on("input", function () {
  //   let tipomonedacambio = $("#selectmoneda").val();
  //   if (tipomonedacambio === "D") {
  //     const accion = "consultadecambiodemoneda";

  //     $.ajax({
  //       url: "./c_almacen.php",
  //       type: "POST",
  //       data: {
  //         accion: accion,
  //       },
  //       success: function (response) {
  //         if (isJSON(response)) {
  //           let tipocambio = JSON.parse(response);
  //           console.log(tipocambio);
  //           $("#tipocambio").val(tipocambio[0].VENTA);
  //         }
  //       },
  //       error: function (xhr, status, error) {
  //         console.error("Error al cargar los datos:", error);
  //       },
  //     });
  //   } else {
  //     $("#tipocambio").val("");
  //   }
  // });

  // $("#tipocambiosunat").on("input", function () {
  function cargarcambiosunat() {
    const accion = "consultatipodecambiosunat";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
      },
      success: function (response) {
        if (isJSON(response)) {
          let tipocambio = JSON.parse(response);
          console.log(tipocambio);
          $("#tipocambiosunat").val(tipocambio[0].VENTA);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos:", error);
      },
    });
    // }
    // else {
    //   $("#tipocambio").val("");
    // }
  }
  // });
  /*---------------------------------------------------------------*/
  /*---------- GUARDAR LOS DATOS CAPTURADOS---------------------- */

  $("#formulariocompraorden").submit((e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append("accion", "guardadatosfactura");
    formData.append("idcomprobantecaptura", $("#codigoorden").val());
    formData.append("empresa", $("#selectempresa").val());
    formData.append("fecha_emision", $("#fecha_emision").val());
    formData.append("hora", $("#hora").val());
    formData.append("fecha_entrega", $("#fecha_entrega").val());
    formData.append("codusu", $("#codpersonal").val());
    formData.append("selecttipocompro", $("#selecttipocompro").val());
    formData.append("serie", $("#serie").val());
    formData.append("correlativo", $("#correlativo").val());
    formData.append("selectformapago", $("#selectformapago").val());
    formData.append("selectmoneda", $("#selectmoneda").val());
    formData.append("tipocambio", $("#tipocambio").val());
    formData.append("observacion", $("#observacion").val());

    const fileInput = document.getElementById("foto");
    const file = fileInput.files[0];
    formData.append("foto", file);

    let serieform = $("#serie").val();
    let correlativoform = $("#correlativo").val();
    let observacionform = $("#observacion").val();
    let idcomprobantecapturaform = $("#codigoorden").val();
    let tipoform = $("#selecttipocompro").val();

    if (!idcomprobantecapturaform) {
      Swal.fire({
        icon: "error",
        title: "No hay un comprobante",
        text: "Necesita darle check a un comprobante",
      });
      return;
    }

    if (tipoform === "none") {
      Swal.fire({
        icon: "error",
        title: "Campo obligatorio",
        text: "Necesita seleccionar un tipo comprobante.",
      });
      return;
    }
    if (!serieform) {
      Swal.fire({
        icon: "error",
        title: "Campo obligatorio",
        text: "Necesita añadir una serie.",
      });
      return;
    }
    if (!correlativoform) {
      Swal.fire({
        icon: "error",
        title: "Campo obligatorio",
        text: "Necesita añadir un correlativo.",
      });
      return;
    }
    if (!observacionform) {
      Swal.fire({
        icon: "error",
        title: "Campo obligatorio",
        text: "Necesita añadir una observación.",
      });
      return;
    }

    if (!file) {
      Swal.fire({
        icon: "error",
        title: "Seleccionar imagen",
        text: "Necesita añadir una imagen.",
      });
      return;
    }

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: function (response) {
        // $("#mostrarfacturasubir").modal("hide");
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            allowOutsideClick: false,
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#mostrarfacturasubir").on("hidden.bs.modal", function () {
                $("body").css("overflow", "auto");
              });
              $("#mostrarfacturasubir").modal("hide");
              $(".modal-backdrop").remove();

              $("#selectempresa").val("00003");
              $("#fecha_emision").val(fechaActual);
              $("#fecha_emision").attr("min", fechaActual);
              $("#fecha_entrega").val(fechaActual);
              $("#fecha_entrega").attr("min", fechaActual);
              $("#selecttipocompro").val("none").trigger("change");
              $("#personal").val("");
              $("#proveedor").val("");
              $("#serie").val("");
              $("#correlativo").val("");
              $("#selectformapago").val("E");
              $("#selectmoneda").val("S");
              $("#tipocambio").prop("disabled", true);
              $("#tipocambio").val("");
              $("#observacion").val("");
              $("#codigoorden").val("");
              $("#tablainsumoscomprarfactura").empty();
              $("#foto").val("");
              const img = document.getElementById("img");
              img.src = "";
              cargarOrdenCompraComprobante();
            }
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  // });

  /*---------------------------------------------------------- */

  /*-------------------VISUALIZAR IMAGEN---------------------- */
  /*const defaultFile = 'https://stonegatesl.com/wp-content/uploads/2021/01/avatar-300x300.jpg';*/

  const file = document.getElementById("foto");
  const img = document.getElementById("img");

  const defaultIconClass = "icon-camera";

  file.addEventListener("change", (e) => {
    if (e.target.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        img.src = e.target.result;
      };
      reader.readAsDataURL(e.target.files[0]);
    }
    img.src = "";
    img.classList.add(defaultIconClass);
  });
  /*--------------------------------------------------------- */
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
