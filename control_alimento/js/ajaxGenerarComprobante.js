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
  /*---------------------MOSTRAR EN ALGUNOS CAMPOS---------------- */
  $(document).on("click", "#clickcomprobante", (e) => {
    e.preventDefault();

    var codigoComprobante = $(
      "#tmostrarcomprobante tbody tr:eq(0) td:eq(0)"
    ).text();
    console.log("Código del Comprobante:", codigoComprobante);

    const accion = "ponercomprobantefactura";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, codigoComprobante: codigoComprobante },
      success: function (response) {
        let lista = JSON.parse(response);
        $("#selectempresa").val(lista[0].COD_EMPRESA);
        $("#personal").val(lista[0].NOM_PERSONAL);
        $("#proveedor").val(lista[0].NOM_PROVEEDOR);
        $("#selectformapago").val(lista[0].F_PAGO);
        $("#selectmoneda").val(lista[0].TIPO_MONEDA);
        $("#observacion").val(lista[0].OBSERVACION);
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });

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
            <td data-titulo="LOTE">${task.MONTO}</td>
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

  /*---------- GUARDAR LOS DATOS CAPTURADOS---------------------- */
  $("#guardarfacturaorden").click((e) => {
    e.preventDefault();
    let empresa = $("#selectempresa").val();
    let fecha_emision = $("#fecha_emision").val();
    let hora = $("#hora").val();
    let fecha_entrega = $("#fecha_entrega").val();
    let selecttipocompro = $("#selecttipocompro").val();
    let serie = $("#serie").val();
    let selectformapago = $("#selectformapago").val();
    let selectmoneda = $("#selectmoneda").val();
    let correlativo = $("#correlativo").val();
    let observacion = $("#observacion").val();

    var idcomprobantecaptura = $(
      "#tmostrarcomprobante tbody tr:eq(0) td:eq(0)"
    ).text();

    const accion = "guardadatosfactura";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        idcomprobantecaptura: idcomprobantecaptura,
        empresa: empresa,
        fecha_emision: fecha_emision,
        hora: hora,
        fecha_entrega: fecha_entrega,
        selecttipocompro: selecttipocompro,
        serie: serie,
        selectformapago: selectformapago,
        selectmoneda: selectmoneda,
        correlativo: correlativo,
        observacion: observacion,
      },
      success: function (response) {},
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
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
