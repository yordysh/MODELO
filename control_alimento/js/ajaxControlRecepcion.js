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
            template += `<tr codigorequerimiento='${task.COD_REQUERIMIENTO}'">
                            <td data-titulo="PRODUCTOS" style='text-align:center;' codigoproducto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CANTIDAD (KG)" style='text-align:center;'>${task.CANTIDAD}</td>
                            <td data-titulo="UNIDADES" style='text-align:center;'>${task.TOTAL_PRODUCTO}</td>
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
          let i = 1;
          tasks.forEach((task) => {
            let quitarceros = parseInt(selectrequerimiento, 10);
            let requerimiento = "RQ-" + quitarceros;
            template += `<tr  class="hoverable">
                            <td data-titulo="ITEM" >${i}</td>
                            <td class='encabezado-especial' data-titulo="FECHA DE INGRESO" >${task.FECHA_EMISION}</td>
                            <td data-titulo="REQUERIMIENTO" style="text-align:center;" codigoordencompra='${task.COD_ORDEN_COMPRA}'>${requerimiento}</td>
                            <td data-titulo="HORA"><input class='form-control' type='time'  min="10:00:00" max="11:00:00" id='horaInput' class='hora'/></td>
                            <td data-titulo="CODIGO INTERNO">${task.COD_PRODUCCION}</td>
                            <td data-titulo="PRODUCTO" codigoproducto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CODIGO DE LOTE"><input type="text" onkeypress="return /[A-Za-z0-9]/.test(String.fromCharCode(event.which))" class='codigolote' id='codigolote' maxlength='20' /></td>
                            <td data-titulo="F.V"><input type='date' class='fechavencimiento' id='fechavencimiento'/></td>
                            <td data-titulo="PROVEEDOR" codigoproveedor='${task.COD_PROVEEDOR}'>${task.NOM_PROVEEDOR}</td>
                            <td data-titulo="G.Remisión"> <input class="form-check-input remision" type="checkbox" value="" id="remision" style='margin-left:20px;'></td>
                            <td data-titulo="Boleta"><input class="form-check-input boleta" type="checkbox" value="" id="boleta" style='margin-left:20px;'></td>
                            <td data-titulo="Factura"><input class="form-check-input factura" type="checkbox" value="" id="factura" style='margin-left:20px;'></td>
                            <td data-titulo="N° GUIA,BOLETA O FACTURA"><input  maxlength='20'/></td>
                            <td data-titulo="Primario"><input class="form-check-input primario" type="checkbox" value="" id="primario"></td>
                            <td data-titulo="Secundario"><input class="form-check-input secundario" type="checkbox" value="" id="secundario"></td>
                            <td data-titulo="Saco"><input class="form-check-input saco" type="checkbox" value="" id="saco"></td>
                            <td data-titulo="Caja"><input class="form-check-input caja" type="checkbox" value="" id="caja"></td>
                            <td data-titulo="Cilindro"><input class="form-check-input cilindro" type="checkbox" value="" id="cilindro"></td>
                            <td data-titulo="Bolsa"><input class="form-check-input bolsa" type="checkbox" value="" id="bolsa"></td>
                            <td data-titulo="CANTIDAD (Kg)"><input class="cantidadminima" value="${task.CANTIDAD_INSUMO_ENVASE}" /></td>
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
            i++;
          });
          $("#tablacontrolrecepcion").html(template);
          // $(document).ready(function () {
          //   let fechaActual = new Date();
          //   fechaActual.setFullYear(fechaActual.getFullYear() + 1);
          //   let fechaMinimaFormato = fechaActual.toISOString().split("T")[0];

          //   $("#tablacontrolrecepcion tr").each(function () {
          //     let fechavencimientoInput = $(this).find(
          //       "td:eq(7) input.fechavencimiento"
          //     );
          //     fechavencimientoInput.val(fechaMinimaFormato);
          //   });
          // });
        }
      },
    });
  });

  /*----click en check y me muestre tabla----------------- */

  function agregarFila(despro, codigoprod, checkboxId) {
    var nuevafila = $("<tr></tr>");

    var descripcionproducto = $(
      `<td style="text-align:center;">${despro}</td>`
    );

    var columnafecha = $(
      `<td style="text-align:center;"><input type="date" codigo_productos="${codigoprod}" codigoidcheck=${checkboxId}></td>`
    );
    var columnaobservacion = $(
      `<td><textarea class="form-control" id="observacioneih_${checkboxId}" rows="2"></textarea></td>`
    );
    var columnaaccioncorrectiva = $(
      `<td><textarea class="form-control" id="acccioncorrectivaeih_${checkboxId}" rows="2"></textarea></td>`
    );

    nuevafila.append(
      descripcionproducto,
      columnafecha,
      columnaobservacion,
      columnaaccioncorrectiva
    );

    $("#tbrecepcionobservacion tbody").append(nuevafila);
  }

  function eliminarFila(checkboxId) {
    $(`#observacioneih_${checkboxId}`).closest("tr").remove();
  }

  $(document).on("click", ".obs", (e) => {
    var celda = $(e.target);
    var codigoprod = celda.data("codigoprod");
    var checkboxId = celda.attr("id");
    var despro = celda.closest("tr").find("td:eq(4)").text();

    if (celda.is(":checked")) {
      eliminarFila(checkboxId);
    } else {
      agregarFila(despro, codigoprod, checkboxId);
    }
  });

  /*---------------------------------------------------- */

  /*-------------------------------------FECHA VENCIMIENTO-------------------- */
  $(document).on("blur", "#fechavencimiento", function () {
    var fechavencimiento = $(this).val();
    var partesFecha = fechavencimiento.split("-");
    var an = partesFecha[0];
    var anio = parseInt(partesFecha[0]);
    var mes = parseInt(partesFecha[1]);
    var dia = parseInt(partesFecha[2]);

    var fechaActual = new Date();
    var añoActual = fechaActual.getFullYear();
    var mesActual = fechaActual.getMonth() + 1; // Los meses en JavaScript van de 0 a 11
    var diaActual = fechaActual.getDate();

    console.log(anio);
    if (an.length < 5) {
      if (
        anio <= añoActual ||
        mes < mesActual ||
        (mes == mesActual && dia < diaActual)
      ) {
        Swal.fire({
          icon: "info",
          title: "¡Introducir una año superior a la actual!",
        }).then((result) => {
          if (result.isConfirmed) {
            $(this).val("");
          }
        });
      }
    } else if (an.length > 4) {
      Swal.fire({
        icon: "info",
        title:
          "¡Introducir la fecha correcta, el año debe de ser menor a 5 cifras!",
      }).then((result) => {
        if (result.isConfirmed) {
          $(this).val("");
        }
      });
    }
  });
  /*------------------------------------------------------------------------- */
  /*------------------------- GUARDAR LA RECEPCION ------------------------------- */
  $("#guardarrecepcion").click((e) => {
    e.preventDefault();
    let idrequerimiento = $("#idrequerimientoorden").val();
    let codpersonal = $("#codpersonal").val();

    let datos = [];
    $("#tbrecepcion tbody tr").each(function () {
      let row = $(this);
      let remision = row.find("td:eq(9) input.remision").is(":checked")
        ? "1"
        : "0";
      let boleta = row.find("td:eq(10) input.boleta").is(":checked")
        ? "1"
        : "0";
      let factura = row.find("td:eq(11) input.factura").is(":checked")
        ? "1"
        : "0";
      let primario = row.find('td:eq(13) input[type="checkbox"]').is(":checked")
        ? "1"
        : "0";
      let secundario = row.find("td:eq(14) input").is(":checked") ? "1" : "0";
      let saco = row.find('td:eq(15) input[type="checkbox"]').is(":checked")
        ? "1"
        : "0";
      let caja = row.find('td:eq(16) input[type="checkbox"]').is(":checked")
        ? "1"
        : "0";
      let cilindro = row.find('td:eq(17) input[type="checkbox"]').is(":checked")
        ? "1"
        : "0";
      let bolsa = row.find('td:eq(18) input[type="checkbox"]').is(":checked")
        ? "1"
        : "0";
      let eih = row.find('td:eq(20) input[type="checkbox"]').is(":checked")
        ? "1"
        : "0";
      let cdc = row.find('td:eq(21) input[type="checkbox"]').is(":checked")
        ? "1"
        : "0";
      let rotulacion = row
        .find('td:eq(22) input[type="checkbox"]')
        .is(":checked")
        ? "1"
        : "0";
      let aplicacion = row.find("td:eq(23) input.aplicacion").is(":checked")
        ? "1"
        : "0";
      let higienesalud = row.find("td:eq(24) input.higienesalud").is(":checked")
        ? "1"
        : "0";
      let indumentaria = row.find("td:eq(25) input.indumentaria").is(":checked")
        ? "1"
        : "0";
      let limpio = row.find('td:eq(26) input[type="checkbox"]').is(":checked")
        ? "1"
        : "0";
      let exclusivo = row
        .find('td:eq(27) input[type="checkbox"]')
        .is(":checked")
        ? "1"
        : "0";
      let hermetico = row
        .find('td:eq(28) input[type="checkbox"]')
        .is(":checked")
        ? "1"
        : "0";
      let ausencia = row.find('td:eq(29) input[type="checkbox"]').is(":checked")
        ? "1"
        : "0";

      datos.push({
        fechaingreso: row.find("td:eq(1)").text(),
        codigoordencompra: row.find("td:eq(2)").attr("codigoordencompra"),
        hora: row.find("td:eq(3) input").val(),
        codigointerno: row.find("td:eq(4)").text(),
        producto: row.find("td:eq(5)").attr("codigoproducto"),
        codigolote: row.find("td:eq(6) input.codigolote").val(),
        fechavencimiento: row.find("td:eq(7) input.fechavencimiento").val(),
        proveedor: row.find("td:eq(8)").attr("codigoproveedor"),
        remision: remision,
        boleta: boleta,
        factura: factura,
        numerofactura: row.find("td:eq(12) input").val(),
        primario: primario,
        secundario: secundario,
        saco: saco,
        caja: caja,
        cilindro: cilindro,
        bolsa: bolsa,
        cantidadminima: row.find("td:eq(19) input").val(),
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

    let horaEmpty = false;
    let iscodigoloteEmpty = false;
    let isFechavencimientoEmpty = false;
    let gbfEmpty = false;
    let facturaEmpty = false;
    let items = [];
    $("#tbrecepcion tbody tr").each(function () {
      let row = $(this);
      let item = row.find("td:eq(0)").text();
      let hora = row.find("td:eq(3) input").val();
      let codigolote = row.find("td:eq(6) input.codigolote").val();
      let fechavencimiento = row.find("td:eq(7) input.fechavencimiento").val();

      let guia = row.find("td:eq(9) input:checkbox").is(":checked");
      let boleta = row.find("td:eq(10) input:checkbox").is(":checked");
      let factura = row.find("td:eq(11) input:checkbox").is(":checked");
      let gbf = row.find("td:eq(12) input").val();
      items.push(item);
      if (hora === "") {
        horaEmpty = true;
        return false;
      }

      if (codigolote === "") {
        iscodigoloteEmpty = true;
        return false;
      }

      if (fechavencimiento === "") {
        isFechavencimientoEmpty = true;
        return false;
      }

      if (factura === false && boleta === false && guia === false) {
        facturaEmpty = true;
        return false;
      }

      if (gbf === "") {
        gbfEmpty = true;
        return false;
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
    if (horaEmpty) {
      Swal.fire({
        icon: "info",
        title: "Inserte una hora",
        text:
          "Debe de seleccionar una hora del item " +
          items[items.length - 1] +
          ".",
      });
      return;
    }
    if (iscodigoloteEmpty) {
      Swal.fire({
        icon: "info",
        title: "Inserte un codigo",
        text:
          "Debe de escribir un codigo lote del item " +
          items[items.length - 1] +
          ".",
      });
      return;
    }
    if (isFechavencimientoEmpty) {
      Swal.fire({
        icon: "info",
        title: "Inserte una fecha",
        text:
          "Debe seleccionar una fecha del item " +
          items[items.length - 1] +
          ".",
      });
      return;
    }
    if (facturaEmpty) {
      Swal.fire({
        icon: "info",
        title: "Darle check",
        text:
          "Debe de darle check obligatorio GIA/BOLETA/FACTURA a cualquiera del item " +
          items[items.length - 1] +
          ".",
      });
      return;
    }
    if (gbfEmpty) {
      Swal.fire({
        icon: "info",
        title: "Inserte numero de guia, boleta factura",
        text:
          "Debe insertar un valor en el recuadro del item " +
          items[items.length - 1] +
          ".",
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
        idrequerimiento: idrequerimiento,
        codpersonal: codpersonal,
        datos: datos,
        datosTabla: datosTabla,
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
              // $("#selectrequerimiento").val("none").trigger("change");
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
  /*----------------------------------------------------------------------------- */

  $(document).on("blur", "#horaInput", function () {
    var enteredTime = $(this).val();
    var enteredDate = new Date("2000-01-01 " + enteredTime);

    var minHour = 8;
    var maxHour = 12;
    if (
      !(enteredDate.getHours() >= minHour && enteredDate.getHours() < maxHour)
    ) {
      // console.log("Hora dentro del rango permitido");
      Swal.fire({
        icon: "info",
        title: "Introducir una hora correcta",
        text: "La hora debe de ser mayor o igual a 8:00 am y menor  a 11:00 am",
      }).then((result) => {
        if (result.isConfirmed) {
          $(this).val("");
        }
      });
    }
  });
});
