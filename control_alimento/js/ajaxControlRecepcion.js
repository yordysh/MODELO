$(function () {
  //===== Prealoder

  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //----------------------------------------------------------------//
  $("#idrequerimientoorden").change(function () {
    let selectrequerimiento = $("#idrequerimientoorden").val();

    const accion = "mostrarvaloresporcodigorequerimiento";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, selectrequerimiento: selectrequerimiento },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr">
                            <td data-titulo="PRODUCTOS" style='text-align:center;'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CANTIDAD TOTAL" style='text-align:center;'>${task.CANTIDAD}</td>
                         </tr>`;
          });
          $("#tablaproductoscantidades").html(template);
        }
      },
    });

    const accionmostrar = "mostrartotaldeinsumosporcomprar";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accionmostrar, selectrequerimiento: selectrequerimiento },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);
          console.log(tasks);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr  class="hoverable">
                            <td class='encabezado-especial' data-titulo="FECHA DE INGRESO" >${task.FECHA_EMISION}</td>
                            <td data-titulo="REQUERIMIENTO">${task.COD_REQUERIMIENTO}</td>
                            <td data-titulo="HORA"><input class='form-control' type='time'/></td>
                            <td data-titulo="CODIGO INTERNO">${task.COD_PRODUCCION}</td>
                            <td data-titulo="PRODUCTO" codigoproducto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CODIGO DE LOTE"><input class='codigolote' id='codigolote'maxlength='20' /></td>
                            <td data-titulo="F.V"><input type='date' class='fechavencimiento'/></td>
                            <td data-titulo="PROVEEDOR" codigoproveedor='${task.COD_PROVEEDOR}'>${task.NOM_PROVEEDOR}</td>
                            <td data-titulo="G.Remisión"> <input class="form-check-input remision" type="checkbox" value="" id="remision" style='margin-left:20px;'></td>
                            <td data-titulo="Boleta"><input class="form-check-input boleta" type="checkbox" value="" id="boleta" style='margin-left:20px;'></td>
                            <td data-titulo="Factura"><input class="form-check-input factura" type="checkbox" value="" id="factura" style='margin-left:20px;'></td>
                            <td data-titulo="N° GUIA,BOLETA O FACTURA"><input /></td>
                            <td data-titulo="Primario"><input class="form-check-input primario" type="checkbox" value="" id="primario"></td>
                            <td data-titulo="Secundario"><input class="form-check-input secundario" type="checkbox" value="" id="secundario"></td>
                            <td data-titulo="Saco"><input class="form-check-input saco" type="checkbox" value="" id="saco"></td>
                            <td data-titulo="Caja"><input class="form-check-input caja" type="checkbox" value="" id="caja"></td>
                            <td data-titulo="Cilindro"><input class="form-check-input cilindro" type="checkbox" value="" id="cilindro"></td>
                            <td data-titulo="Bolsa"><input class="form-check-input bolsa" type="checkbox" value="" id="bolsa"></td>
                            <td data-titulo="CANTIDAD (Kg)"><input value="${task.CANTIDAD_INSUMO_ENVASE}" /></td>
                            <td data-titulo="Envase integro/Hermético"><input class="form-check-input eih obs" type="checkbox" value="" id="eih" data-codigoprod='${task.COD_PRODUCTO}' checked></td>
                            <td data-titulo="Certificado de calidad"><input class="form-check-input cdc obs" type="checkbox" value="" id="cdc" data-codigoprod='${task.COD_PRODUCTO}'  checked></td>
                            <td data-titulo="Rotulación conforme"><input class="form-check-input rotulacion obs" type="checkbox" value="" id="rotulacion" data-codigoprod='${task.COD_PRODUCTO}' checked></td>
                            <td data-titulo="Aplicación de las BPD"><input class="form-check-input aplicacion obs" type="checkbox" value="" id="aplicacion" data-codigoprod='${task.COD_PRODUCTO}' checked></td>
                            <td data-titulo="Higiene & salud"><input class="form-check-input higienesalud obs" type="checkbox" value="" id="higienesalud" data-codigoprod='${task.COD_PRODUCTO}' checked></td>
                            <td data-titulo="Indumentaria completa y limpia"><input class="form-check-input indumentaria obs" type="checkbox" value="" id="indumentaria" data-codigoprod='${task.COD_PRODUCTO}' checked></td>
                            <td data-titulo="Limpio"><input class="form-check-input limpio obs" type="checkbox" value="" id="limpio" data-codigoprod='${task.COD_PRODUCTO}' checked></td>
                            <td data-titulo="Exclusivo"><input class="form-check-input exclusivo obs" type="checkbox" value="" id="exclusivo" data-codigoprod='${task.COD_PRODUCTO}' checked></td>
                            <td data-titulo="Hermetico"><input class="form-check-input hermetico obs" type="checkbox" value="" id="hermetico" data-codigoprod='${task.COD_PRODUCTO}' checked></td>
                            <td data-titulo="Ausencia de plagas"><input class="form-check-input ausencia obs" type="checkbox" value="" id="ausencia" data-codigoprod='${task.COD_PRODUCTO}' checked></td>
                            <td data-titulo="V°B°"></td>
                         </tr>`;
          });
          $("#tablacontrolrecepcion").html(template);
        }
      },
    });
  });

  /*----click en check y me muestre tabla----------------- */

  function agregarFila(codigoprod, checkboxId) {
    var nuevafila = $("<tr></tr>");

    var columnafecha = $(
      `<td><input type="date" codigo_productos="${codigoprod}" codigoidcheck=${checkboxId}></td>`
    );
    var columnaobservacion = $(
      `<td><textarea class="form-control" id="observacioneih_${checkboxId}" rows="2"></textarea></td>`
    );
    var columnaaccioncorrectiva = $(
      `<td><textarea class="form-control" id="acccioncorrectivaeih_${checkboxId}" rows="2"></textarea></td>`
    );

    nuevafila.append(columnafecha, columnaobservacion, columnaaccioncorrectiva);

    $("#tbrecepcionobservacion tbody").append(nuevafila);
  }

  function eliminarFila(checkboxId) {
    $(`#observacioneih_${checkboxId}`).closest("tr").remove();
  }

  $(document).on("click", ".obs", (e) => {
    var celda = $(e.target);
    var codigoprod = celda.data("codigoprod");
    var checkboxId = celda.attr("id");

    if (celda.is(":checked")) {
      eliminarFila(checkboxId);
    } else {
      agregarFila(codigoprod, checkboxId);
    }
  });

  /*---------------------------------------------------- */

  $("#guardarrecepcion").click((e) => {
    e.preventDefault();
    let idrequerimiento = $("#idrequerimientoorden").val();
    let codpersonal = $("#codpersonal").val();

    let datos = [];
    $("#tbrecepcion tbody tr").each(function () {
      let fechaingreso = $(this).find("td:eq(0)").text();
      let codigorequerimiento = $(this).find("td:eq(1)").text();
      let hora = $(this).find("td:eq(2) input").val();
      let codigointerno = $(this).find("td:eq(3)").text();
      let producto = $(this).find("td:eq(4)").attr("codigoproducto");
      let codigolote = $(this).find("td:eq(5) input.codigolote").val();
      let fechavencimiento = $(this)
        .find("td:eq(6) input.fechavencimiento")
        .val();
      let proveedor = $(this).find("td:eq(7)").attr("codigoproveedor");
      let remision = $(this).find("td:eq(8) input.remision").is(":checked");
      let boleta = $(this).find("td:eq(9) input.boleta").is(":checked");
      let factura = $(this).find("td:eq(10) input.factura ").is(":checked");
      let numerofactura = $(this).find("td:eq(11) input").val();

      let primario = $(this).find("td:eq(12) input.primario").is(":checked");
      let secundario = $(this)
        .find("td:eq(13) input.secundario")
        .is(":checked");
      let saco = $(this).find("td:eq(14) input.saco").is(":checked");
      let caja = $(this).find("td:eq(15) input.caja").is(":checked");
      let cilindro = $(this).find("td:eq(16) input.cilindro").is(":checked");
      let bolsa = $(this).find("td:eq(17) input.bolsa").is(":checked");
      let cantidadminima = $(this).find("td:eq(18) input").val();
      let eih = $(this).find("td:eq(19) input.eih").is(":checked");
      let cdc = $(this).find("td:eq(20) input.cdc").is(":checked");
      let rotulacion = $(this)
        .find("td:eq(21) input.rotulacion")
        .is(":checked");
      let aplicacion = $(this)
        .find("td:eq(22) input.aplicacion")
        .is(":checked");
      let higienesalud = $(this)
        .find("td:eq(23) input.higienesalud")
        .is(":checked");
      let indumentaria = $(this)
        .find("td:eq(24) input.indumentaria")
        .is(":checked");
      let limpio = $(this).find("td:eq(25) input.limpio").is(":checked");
      let exclusivo = $(this).find("td:eq(26) input.exclusivo").is(":checked");
      let hermetico = $(this).find("td:eq(27) input.hermetico").is(":checked");
      let ausencia = $(this).find("td:eq(28) input.ausencia").is(":checked");

      datos.push({
        fechaingreso: fechaingreso,
        codigorequerimiento: codigorequerimiento,
        hora: hora,
        codigointerno: codigointerno,
        producto: producto,
        codigolote: codigolote,
        fechavencimiento: fechavencimiento,
        proveedor: proveedor,
        remision: remision,
        boleta: boleta,
        factura: factura,
        numerofactura: numerofactura,
        primario: primario,
        secundario: secundario,
        saco: saco,
        caja: caja,
        cilindro: cilindro,
        bolsa: bolsa,
        cantidadminima: cantidadminima,
        eih: eih,
        cdc: cdc,
        rotulacion: rotulacion,
        aplicacion: aplicacion,
        higienesalud: higienesalud,
        indumentaria: indumentaria,
        limpio: limpio,
        exclusivo: exclusivo,
        hermetico: hermetico,
        ausencia: ausencia,
      });
    });
    console.log(datos);
    let codigolote;
    let fechavencimiento;
    let iscodigoloteEmpty = false;
    let isFechavencimientoEmpty = false;
    $("#tbrecepcion tbody tr").each(function () {
      codigolote = $(this).find("td:eq(5) input.codigolote").val();
      fechavencimiento = $(this).find("td:eq(6) input.fechavencimiento").val();
      if (codigolote === "") {
        iscodigoloteEmpty = true;
      }

      if (fechavencimiento === "") {
        isFechavencimientoEmpty = true;
      }
    });
    if (!idrequerimiento) {
      Swal.fire({
        icon: "info",
        title: "Seleccione un requerimiento",
        text: "Debe de seleccionar un requerimiento.",
      });
      return;
    }
    if (iscodigoloteEmpty) {
      Swal.fire({
        icon: "info",
        title: "Inserte un codigo",
        text: "Debe de escribir un codigo lote.",
      });
      return;
    }
    if (isFechavencimientoEmpty) {
      Swal.fire({
        icon: "info",
        title: "Inserte una fecha",
        text: "Debe seleccionar una fecha en al menos una fila.",
      });
      return;
    }

    var datosTabla = [];
    $("#tbrecepcionobservacion tbody tr").each(function () {
      let productoc = $(this)
        .find('input[type="date"]')
        .attr("codigo_productos");
      let idc = $(this).find('input[type="date"]').attr("codigoidcheck");
      var fechax = $(this).find('input[type="date"]').val();
      var observacionx = $(this).find('textarea[id^="observacioneih"]').val();
      var accionCorrectivax = $(this)
        .find('textarea[id^="acccioncorrectivaeih"]')
        .val();

      var fila = {
        productoc: productoc,
        idc: idc,
        Fechax: fechax,
        Observacionx: observacionx,
        AccionCorrectivax: accionCorrectivax,
      };
      datosTabla.push(fila);
    });
    let fechax;
    let fechaobs = false;
    $("#tbrecepcionobservacion tbody tr").each(function () {
      fechax = $(this).find('input[type="date"]').val();
      if (fechax === "") {
        fechaobs = true;
      }
    });

    if (fechaobs) {
      Swal.fire({
        icon: "info",
        title: "Inserte una fecha en la tabla observación",
        text: "Debe seleccionar una fecha en al menos una fila.",
      });
      return;
    }

    const accioninsertardatos = "insertardatoscontrolrecepcion";
    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accioninsertardatos,
        datos: datos,
        datosTabla: datosTabla,
        idrequerimiento: idrequerimiento,
        codpersonal: codpersonal,
      },
      type: "POST",
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: function (response) {
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#selectrequerimiento").val("none").trigger("change");
              $("#tablaproductoscantidades").empty();
              $("#tablacontrolrecepcion").empty();
              $("#tablacontrolrecepcionobservacion").empty();
            }
          });
        }
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
});
