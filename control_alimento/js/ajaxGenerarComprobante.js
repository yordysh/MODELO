$(function () {
  //===== Prealoder

  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //-------------------------------------------//

  cargarOrdenCompraComprobante();

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
                            <!--<td style="text-align:center;"><button class="custom-icon-pdf"  id="clickpdf"><i class="icon-print"></i></button></td>-->
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
    $("#codigoorden").val(codigoComprobante);
    const accion = "ponercomprobantefactura";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, codigoComprobante: codigoComprobante },
      success: function (response) {
        let lista = JSON.parse(response);
        $("#selectempresa").val(lista[0].COD_EMPRESA);
        // $("#personal").val(lista[0].NOM_PERSONAL);
        $("#proveedor").val(lista[0].NOM_PROVEEDOR);
        $("#selectformapago").val(lista[0].F_PAGO);
        $("#selectmoneda").val(lista[0].TIPO_MONEDA);
        // $("#observacion").val(lista[0].OBSERVACION);
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
        let listaresponse = JSON.parse(response);
        $("#personal").val(listaresponse[0].NOM_PERSONAL);
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
            <td data-titulo="NOMBRE">${task.DES_PRODUCTO}</td>
            <td data-titulo="CANTIDAD">${task.CANTIDAD_MINIMA}</td>
            <td data-titulo="PRECIO">${task.MONTO}</td>
            <!--<td data-titulo="LOTE">${task.MONTO}</td>-->
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
  $("#selectmoneda").on("input", function () {
    let tipomonedacambio = $("#selectmoneda").val();
    if (tipomonedacambio === "D") {
      const accion = "consultadecambiodemoneda";

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
            $("#tipocambio").val(tipocambio[0].VENTA);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos:", error);
        },
      });
    } else {
      $("#tipocambio").val("");
    }
  });
  /*---------------------------------------------------------------*/
  /*---------- GUARDAR LOS DATOS CAPTURADOS---------------------- */
  $("#guardarfacturaorden").click((e) => {
    e.preventDefault();
    let empresa = $("#selectempresa").val();
    let fecha_emision = $("#fecha_emision").val();
    let hora = $("#hora").val();
    let fecha_entrega = $("#fecha_entrega").val();
    let codusu = $("#codpersonal").val();
    let selecttipocompro = $("#selecttipocompro").val();
    let serie = $("#serie").val();
    let correlativo = $("#correlativo").val();
    let selectformapago = $("#selectformapago").val();
    let selectmoneda = $("#selectmoneda").val();
    let tipocambio = $("#tipocambio").val();
    let observacion = $("#observacion").val();

    let idcomprobantecaptura = $("#codigoorden").val();
    console.log(empresa);
    // const accion = "guardadatosfactura";

    // $.ajax({
    //   url: "./c_almacen.php",
    //   type: "POST",
    //   data: {
    //     accion: accion,
    //     idcomprobantecaptura: idcomprobantecaptura,
    //     empresa: empresa,
    //     fecha_emision: fecha_emision,
    //     hora: hora,
    //     fecha_entrega: fecha_entrega,
    //     codusu: codusu,
    //     selecttipocompro: selecttipocompro,
    //     serie: serie,
    //     selectformapago: selectformapago,
    //     selectmoneda: selectmoneda,
    //     tipocambio: tipocambio,
    //     correlativo: correlativo,
    //     observacion: observacion,
    //   },
    //   success: function (response) {
    //     if (response == "ok") {
    //       Swal.fire({
    //         title: "¡Guardado exitoso!",
    //         text: "Los datos se han guardado correctamente.",
    //         icon: "success",
    //         allowOutsideClick: false,
    //         confirmButtonText: "Aceptar",
    //       }).then((result) => {
    //         if (result.isConfirmed) {
    //           $("#selectempresa").val("00003");
    //           $("#fecha_emision").val(fechaActual);
    //           $("#fecha_emision").attr("min", fechaActual);
    //           $("#fecha_entrega").val(fechaActual);
    //           $("#fecha_entrega").attr("min", fechaActual);
    //           $("#selecttipocompro").val("none").trigger("change");
    //           $("#personal").val("");
    //           $("#proveedor").val("");
    //           $("#serie").val("");
    //           $("#correlativo").val("");
    //           $("#selectformapago").val("E");
    //           $("#selectmoneda").val("S");
    //           $("#tipocambio").prop("disabled", true);
    //           $("#tipocambio").val("");
    //           $("#observacion").val("");
    //           $("#codigoorden").val("");
    //           cargarOrdenCompraComprobante();
    //         }
    //       });
    //     }
    //   },
    //   error: function (xhr, status, error) {
    //     console.error("Error al cargar los datos de la tabla:", error);
    //   },
    // });
  });
  /*---------------------------------------------------------- */
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
