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
            template += `<tr">
                            <td class='encabezado-especial' data-titulo="FECHA DE INGRESO" >${task.FECHA_EMISION}</td>
                            <td data-titulo="HORA"><input class='hora' /></td>
                            <td data-titulo="PRODUCTO">${task.DES_PRODUCTO}</td>
                            <td data-titulo="CODIGO DE LOTE"><input class='codigolote'/></td>
                            <td data-titulo="F.V"><input class='fechavencimiento'/></td>
                            <td data-titulo="PROVEEDOR">${task.NOM_PROVEEDOR}</td>
                            <td data-titulo="G.Remisión"> <input class="form-check-input remision" type="checkbox" value="" id="remision"></td>
                            <td data-titulo="Boleta"><input class="form-check-input boleta" type="checkbox" value="" id="boleta"></td>
                            <td data-titulo="Factura"><input class="form-check-input factura" type="checkbox" value="" id="factura"></td>
                            <td data-titulo="N° GUIA,BOLETA O FACTURA"><input class='gbf'/></td>  
                            <td data-titulo="Primario"><input class="form-check-input primario" type="checkbox" value="" id="primario"></td>
                            <td data-titulo="Secundario"><input class="form-check-input secundario" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td data-titulo="Saco"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td data-titulo="Caja"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td data-titulo="Cilindro"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td data-titulo="Bolsa"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td data-titulo="CANTIDAD (Kg)">${task.CANTIDAD_MINIMA}</td>
                            <td data-titulo="Envase integro/Hermético"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
                            <td data-titulo="Certificado de calidad"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
                            <td data-titulo="Rotulación conforme"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
                            <td data-titulo="Aplicación de las BPD"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
                            <td data-titulo="Higiene & salud"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
                            <td data-titulo="Indumentaria completa y limpia"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
                            <td data-titulo="Limpio"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
                            <td data-titulo="Exclusivo"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
                            <td data-titulo="Hermetico"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
                            <td data-titulo="Ausencia de plagas"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
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

    var datos = [];
    $("#tbrecepcion tbody tr").each(function () {
      let fechaingreso = $(this).find("td:eq(0)").text();
      let hora = $(this).find("td:eq(1) input.hora").val();
      let producto = $(this).find("td:eq(2)").text();
      let codigolote = $(this).find("td:eq(3) input.codigolote").val();
      let fechavencimiento = $(this)
        .find("td:eq(4) input.fechavencimiento")
        .val();
      let proveedor = $(this).find("td:eq(5)").text();
      let remision = $(this).find("td:eq(6) input.remision").is(":checked");
      let boleta = $(this).find("td:eq(6) input.boleta").is(":checked");
      let factura = $(this).find("td:eq(6) input.factura ").is(":checked");
      let gbf = $(this).find("td:eq(7) input.gbf").val();
      datos.push({
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
      });
    });
    console.log(datos);
  });
});
