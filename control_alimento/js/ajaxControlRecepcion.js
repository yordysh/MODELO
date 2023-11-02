$(function () {
  $("#selectrequerimiento").change(function () {
    let selectrequerimiento = $("#selectrequerimiento").val();

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
                            <td data-titulo="CODIGO">${task.DES_PRODUCTO}</td>
                            <td data-titulo="NOMBRE">${task.CANTIDAD}</td>
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
            template += `<tr idcomprobante='${task.COD_TMPCOMPROBANTE}'">
                            <td class='encabezado-especial' data-titulo="FECHA DE INGRESO" >${task.FECHA_EMISION}</td>
                            <td data-titulo="HORA"><input class='hora' /></td>
                            <td data-titulo="PRODUCTO" codigoproducto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CODIGO DE LOTE"><input class='codigolote'/></td>
                            <td data-titulo="F.V"><input class='fechavencimiento'/></td>
                            <td data-titulo="PROVEEDOR">${task.NOM_PROVEEDOR}</td>
                            <td data-titulo="G.Remisión"> <input class="form-check-input remision" type="checkbox" value="" id="remision"></td>
                            <td data-titulo="Boleta"><input class="form-check-input boleta" type="checkbox" value="" id="boleta"></td>
                            <td data-titulo="Factura"><input class="form-check-input factura" type="checkbox" value="" id="factura"></td>
                            <td data-titulo="N° GUIA,BOLETA O FACTURA"><input class='gbf'/></td>  
                            <td data-titulo="Primario"><input class="form-check-input primario" type="checkbox" value="" id="primario"></td>
                            <td data-titulo="Secundario"><input class="form-check-input secundario" type="checkbox" value="" id="secundario"></td>
                            <td data-titulo="Saco"><input class="form-check-input saco" type="checkbox" value="" id="saco"></td>
                            <td data-titulo="Caja"><input class="form-check-input caja" type="checkbox" value="" id="caja"></td>
                            <td data-titulo="Cilindro"><input class="form-check-input cilindro" type="checkbox" value="" id="cilindro"></td>
                            <td data-titulo="Bolsa"><input class="form-check-input bolsa" type="checkbox" value="" id="bolsa"></td>
                            <td data-titulo="CANTIDAD (Kg)">${task.CANTIDAD_MINIMA}</td>
                            <td data-titulo="Envase integro/Hermético"><input class="form-check-input eih" type="checkbox" value="" id="eih" checked></td>
                            <td data-titulo="Certificado de calidad"><input class="form-check-input cdc" type="checkbox" value="" id="cdc" checked></td>
                            <td data-titulo="Rotulación conforme"><input class="form-check-input rotulacion" type="checkbox" value="" id="rotulacion" checked></td>
                            <td data-titulo="Aplicación de las BPD"><input class="form-check-input aplicacion" type="checkbox" value="" id="aplicacion" checked></td>
                            <td data-titulo="Higiene & salud"><input class="form-check-input higienesalud" type="checkbox" value="" id="higienesalud" checked></td>
                            <td data-titulo="Indumentaria completa y limpia"><input class="form-check-input indumentaria" type="checkbox" value="" id="indumentaria" checked></td>
                            <td data-titulo="Limpio"><input class="form-check-input limpio" type="checkbox" value="" id="limpio" checked></td>
                            <td data-titulo="Exclusivo"><input class="form-check-input exclusivo" type="checkbox" value="" id="exclusivo" checked></td>
                            <td data-titulo="Hermetico"><input class="form-check-input hermetico" type="checkbox" value="" id="hermetico" checked></td>
                            <td data-titulo="Ausencia de plagas"><input class="form-check-input ausencia" type="checkbox" value="" id="ausencia" checked></td>
                            <td data-titulo="V°B°"></td>
                         </tr>`;
          });
          $("#tablacontrolrecepcion").html(template);
        }
      },
    });
  });

  $("#guardarrecepcion").click((e) => {
    e.preventDefault();
    let idrequerimiento = $("#selectrequerimiento").val();
    let codpersonal = $("#codpersonal").val();
    let datos = [];
    $("#tbrecepcion tbody tr").each(function () {
      let idcomprobante = $(this).attr("idcomprobante");
      let fechaingreso = $(this).find("td:eq(0)").text();
      let hora = $(this).find("td:eq(1) input.hora").val();
      let producto = $(this).find("td:eq(2)").attr("codigoproducto");
      let codigolote = $(this).find("td:eq(3) input.codigolote").val();
      let fechavencimiento = $(this)
        .find("td:eq(4) input.fechavencimiento")
        .val();
      let proveedor = $(this).find("td:eq(5)").text();
      let remision = $(this).find("td:eq(6) input.remision").is(":checked");
      let boleta = $(this).find("td:eq(7) input.boleta").is(":checked");
      let factura = $(this).find("td:eq(8) input.factura ").is(":checked");
      let gbf = $(this).find("td:eq(9) input.gbf").is(":checked");
      let primario = $(this).find("td:eq(10) input.primario").is(":checked");
      let secundario = $(this)
        .find("td:eq(11) input.secundario")
        .is(":checked");
      let saco = $(this).find("td:eq(12) input.saco").is(":checked");
      let caja = $(this).find("td:eq(13) input.caja").is(":checked");
      let cilindro = $(this).find("td:eq(14) input.cilindro").is(":checked");
      let bolsa = $(this).find("td:eq(15) input.bolsa").is(":checked");
      let cantidadminima = $(this).find("td:eq(16)").text();
      let eih = $(this).find("td:eq(17) input.eih").is(":checked");
      let cdc = $(this).find("td:eq(18) input.cdc").is(":checked");
      let rotulacion = $(this)
        .find("td:eq(19) input.rotulacion")
        .is(":checked");
      let aplicacion = $(this)
        .find("td:eq(20) input.aplicacion")
        .is(":checked");
      let higienesalud = $(this)
        .find("td:eq(21) input.higienesalud")
        .is(":checked");
      let indumentaria = $(this)
        .find("td:eq(22) input.indumentaria")
        .is(":checked");
      let limpio = $(this).find("td:eq(23) input.limpio").is(":checked");
      let exclusivo = $(this).find("td:eq(24) input.exclusivo").is(":checked");
      let hermetico = $(this).find("td:eq(25) input.hermetico").is(":checked");
      let ausencia = $(this).find("td:eq(26) input.ausencia").is(":checked");

      datos.push({
        idcomprobante: idcomprobante,
        fechaingreso: fechaingreso,
        hora: hora,
        producto: producto,
        codigolote: codigolote,
        fechavencimiento: fechavencimiento,
        proveedor: proveedor,
        remision: remision,
        boleta: boleta,
        factura: factura,
        gbf: gbf,
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

    const accioninsertardatos = "insertardatoscontrolrecepcion";
    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accioninsertardatos,
        datos: datos,
        idrequerimiento: idrequerimiento,
        codpersonal: codpersonal,
      },
      type: "POST",
      success: function (response) {
        if (response == "ok") {
        }
      },
    });
  });
});
