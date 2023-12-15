function formatDate(date) {
  var fecha = new Date(date);
  var dd = String(fecha.getDate()).padStart(2, "0");
  var mm = String(fecha.getMonth() + 1).padStart(2, "0");
  var yyyy = fecha.getFullYear();
  return dd + "/" + mm + "/" + yyyy;
}

function formatDateAnio(date) {
  var fecha = new Date(date);
  var dd = String(fecha.getDate()).padStart(2, "0");
  var mm = String(fecha.getMonth() + 1).padStart(2, "0");
  var yyyy = fecha.getFullYear().toString();
  var final = yyyy.slice(-2);
  return dd + "/" + mm + "/" + final;
}

function buscar_nombre_encargado() {
  var nombres = [];
  $.ajax({
    url: "c_insumos.php",
    type: "POST",
    data: { action: "trae_nombre_personal_mezclado1" },
    success: function (data) {
      nombres = JSON.parse(data);
      //console.log(nombres);

      $("#nombre_encargado").autocomplete({
        source: function (request, response) {
          var results = $.ui.autocomplete.filter(nombres, request.term);
          response(results.slice(0, 10));
        },
        select: function (event, ui) {
          console.log("Evento select disparado");
          $("#codigo_encargado").val(ui.item.codigo);
        },
      });
    },
    error: function (err) {
      console.error(err);
    },
  });
}

function generar_pdfControlBachada_2() {
  $(document).on(
    "click",
    "button.generar_pdf_reporte_control_bachada2",
    function () {
      var cod_producto = $("#cod_producto_pdf").val();
      var cod_lote = $("#cod_lote_pdf").val();

      console.log(cod_producto);
      console.log(cod_lote);

      $.ajax({
        url: "c_insumos.php",
        type: "POST",
        data: {
          action: "traer_datos_reporte_bachada_pdf1",
          cod_producto_pdf: cod_producto,
          cod_lote_pdf: cod_lote,
        },
        datatype: "json",
        success: function (response) {
          console.log(response);
          if (response.length > 0) {
            const bachadasPorPersonal = {};

            for (let i = 0; i < response.length; i++) {
              const currentItem = response[i];
              const codPersonal = currentItem["COD_PERSONAL"];

              if (!bachadasPorPersonal[codPersonal]) {
                bachadasPorPersonal[codPersonal] = [];
              }

              bachadasPorPersonal[codPersonal].push(currentItem);
            }

            const doc = new jsPDF({
              orientation: "landscape",
            });

            let firstPage = true;

            for (const codPersonal in bachadasPorPersonal) {
              if (bachadasPorPersonal.hasOwnProperty(codPersonal)) {
                const bachadas = bachadasPorPersonal[codPersonal];

                let s = 58;
                let counter = 0;

                //let s1 = 150;

                if (!firstPage) {
                  doc.addPage(); // Agregar una nueva página solo si no es la primera
                }

                dibujarEncabezado(doc, bachadas); // Dibujar encabezado con las bachadas específicas

                for (let i = 0; i < bachadas.length; i++) {
                  const currentItem = bachadas[i];

                  doc.text(
                    formatDateAnio(currentItem.FECHA_MEZCLADO),
                    8,
                    s - 2
                  ); // Columna de Fecha
                  doc.text(currentItem.NUMERO_BACHADA, 25, s - 2); // Columna de
                  doc.text(currentItem.PESO_TOTAL_OBTENIDO, 36, s - 2); // Columna de
                  doc.text(currentItem.CANT_BOLSAS, 55, s - 2); // Columna de
                  doc.text(currentItem.CANT_PROGRAMADA_UNIDADES, 67, s - 2); // Columna de
                  doc.text(currentItem.PESO_ESTIMADO, 81, s - 2); // Columna de
                  doc.text(currentItem.CANT_BOL_SELECT, 102, s - 2); // Columna de
                  doc.text(currentItem.PESO_TOTAL_SELECT, 111, s - 2); // Columna de

                  doc.text(currentItem.MEZCLA_SELECT_BOL_INCO, 135, s - 2); // Columna de
                  doc.text(currentItem.MEZCLA_SOBRANTE, 153, s - 2); // Columna de
                  doc.text(currentItem.MEZCLA_ENV_TOTAL, 168, s - 2); // Columna de
                  doc.text(currentItem.CANT_ESTIMADA, 189, s - 2); // Columna de
                  doc.text(currentItem.CANT_BOL_SOBRANTE, 206, s - 2); // Columna de
                  doc.text(currentItem.PESO_TOTAL_BOL_SOBRANTE, 220, s - 2); // Columna de
                  doc.text(currentItem.LOTE, 236, s - 2); // Columna de
                  doc.text(
                    formatDateAnio(currentItem.FECHA_PRODUCCION),
                    246,
                    s - 2
                  ); // Columna de
                  doc.text(
                    formatDateAnio(currentItem.FECHA_VENCIMIENTO),
                    258,
                    s - 2
                  ); // Columna de

                  if (currentItem.BACHADA_ANTERIOR == 0) {
                    doc.text("0", 276, s - 2); // Columna de
                  } else {
                    doc.text(currentItem.BACHADA_ANTERIOR, 276, s - 2); // Columna de
                  }

                  //if (currentItem.OBSERVACIONES_ENV !== null && currentItem.OBSERVACIONES_ENV !== undefined) {
                  //    doc.text(observaciones, 231, s - 2);
                  //}

                  //doc.text(currentItem.OBSERVACIONES_ENV, 18, s1 - 2); // Columna de
                  //s1 += 5;

                  s += 5;
                  counter++;

                  if (counter >= 15) {
                    doc.addPage(); // Agregar una nueva página
                    dibujarEncabezado(doc, bachadas); // Dibujar encabezado en la nueva página
                    s = 58; // Reiniciar posición vertical
                    counter = 0; // Reiniciar contador de líneas
                  }
                }

                firstPage = false;
              }
            }

            doc.save(`reporte_control_bachadas.pdf`);
          } else {
            Swal.fire({
              icon: "warning",
              title: "Datos no válidos.",
              text: "No se encontraron coincidencias para poder exportar, verifica si los datos son correctos.",
            });
          }
        },
        error: function (err) {
          console.log(err);
        },
      });
    }
  );
}

function dibujarEncabezado(doc, response) {
  limitleft = 6;

  var logo = new Image();
  logo.src = "recursos/img_lab.jpg";
  doc.setFont(undefined, "normal");
  doc.setFontSize(12);
  doc.line(6, 6.5, 6, 26); //linea vertical
  doc.line(limitleft, 6.5, 290, 6.5); //linea horizontal
  doc.addImage(logo.src, "JPG", 9, 9, 60, 15);
  doc.line(limitleft, 26, 290, 26); //linea horizontal
  doc.line(70, 6.5, 70, 26); //linea vertical
  doc.setFontSize(13);
  doc.text("CONTROL DE BACHADAS SELECCIONADAS PARA ENVASADO", 72, 19); //TITULO DOSIMETRIA
  doc.line(210, 6.5, 210, 26); //linea vertical
  doc.line(290, 6.5, 290, 26); //linea vertical
  doc.setFontSize(7);
  doc.setFont("helvetica", "bold");
  doc.text("CÓDIGO: " + response[0].DATO_VERSION.NOMBRE, 211, 11); //reemplazar
  doc.line(210, 13, 290, 13); //linea horizontal
  doc.text("VERSIÓN: " + response[0].DATO_VERSION.VERSION, 211, 17); //campo para agregar la version reemplazar
  doc.line(210, 19, 290, 19); //linea horizontal
  doc.text("FECHA: " + response[0].NOMBRE_MES, 211, 23.5); //campo para agregar la fecha reemplazar

  doc.setFontSize(7);

  doc.line(6, 42, 6, 128); //1 linea vertical //50
  doc.line(21, 42, 21, 128); //2 linea vertical
  doc.line(33, 42, 33, 128); //3 linea vertical
  doc.line(50, 42, 50, 128); // 4 linea vertical
  doc.line(60, 42, 60, 128); //5 linea vertical
  doc.line(79, 42, 79, 128); //6 linea vertical

  doc.line(95, 42, 95, 128); //7 linea vertical
  doc.line(109, 45.5, 109, 128); //8 linea vertical

  doc.line(125, 42, 125, 128); //9 linea vertical
  doc.line(152, 42, 152, 128); //10 linea vertical

  doc.line(167, 42, 167, 128); //11 linea vertical
  doc.line(188, 42, 188, 128); //12 linea vertical
  doc.line(205, 42, 205, 128); //13 linea vertical
  doc.line(219, 45.5, 219, 128); //14 linea vertical

  doc.line(235, 42, 235, 128); //15 linea vertical
  doc.line(245, 42, 245, 128); //16 linea vertical
  doc.line(256, 42, 256, 128); //17 linea vertical
  doc.line(268, 42, 268, 128); //18 linea vertical

  doc.line(290, 42, 290, 128); //ultima linea vertical

  doc.text("PRODUCTO:", 46, 35);
  doc.text(response[0].ABR_PRODUCTO, 65, 34.5);
  doc.line(61, 35, 85, 35); // linea horizontal/**/
  doc.text("PRESENTACIÓN:", 120, 35);
  doc.text(response[0].PESO_NETO, 145, 34.5);
  doc.line(141, 35, 165, 35); // linea horizontal/**/
  doc.text("RESPONSABLE:", 190, 35);
  doc.text(response[0].NOM_PERSONAL.NOM_PERSONAL1, 211, 34.5);
  doc.line(210, 35, 260, 35); // linea horizontal/**/

  doc.line(6, 42, 290, 42); //primera linea horizontal/**/
  doc.line(95, 45.5, 152, 45.5); //segunda linea horizontal/**/
  doc.line(205, 45.5, 235, 45.5); //tercera linea horizontal/**/
  doc.line(6, 52, 290, 52); //cuarta linea horizontal/**/

  doc.setFontSize(6);

  doc.text("FECHA DE", 8, 45);
  doc.text("MEZCLADO", 8, 48);
  doc.text("Nº BACH.", 22, 45);
  doc.text("PESO TOTAL", 34, 45);
  doc.text("OBTENIDO", 34, 48);
  doc.text("CTB", 51, 45);
  doc.text("CANTIDAD", 61, 45);
  doc.text("PROGRAMADA", 61, 48);
  doc.text("(UNIDADES)", 61, 51);
  doc.text("PESO", 80, 45);
  doc.text("ESTIMADO", 80, 48);
  doc.text("(Kg)", 80, 51);
  doc.text("BOLSAS SELECCIONADAS", 96, 45);
  doc.text("CANTIDAD", 96, 48);
  doc.text("PESO TOTAL", 110, 48);
  doc.text("(KG) A", 110, 51);
  doc.text("BOLSAS INCOMPLETA", 126, 45);
  doc.text("MEZCLA", 126, 48);
  doc.text("SELECCIONADA(Kg) B", 126, 51);

  doc.text("MEZCLA", 153, 45);
  doc.text("SOBRANTE", 153, 48);
  doc.text("(Kg)", 153, 51);

  doc.text("MEZCLA A", 168, 45);
  doc.text("ENVASAR TOTAL", 168, 48);
  doc.text("(Kg) A+B", 168, 51);

  doc.text("CANTIDAD", 189, 45);
  doc.text("ESTIMADA", 189, 48);
  doc.text("(UNID.)", 189, 51);

  doc.text("BOLSAS SOBRANTES", 206, 45);
  doc.text("CANTIDAD", 206, 48);
  doc.text("PESO", 220, 48);
  doc.text("TOTAL(Kg)", 220, 51);

  doc.text("LOTE", 236, 45);

  doc.text("F.P.", 247, 45);

  doc.text("F.V.", 258, 45);

  doc.text("BACHADA", 272, 45);
  doc.text("ANTERIOR", 272, 48);
  doc.text("(Kg)", 272, 51);

  doc.line(6, 58, 290, 58); // línea horizontal
  doc.line(6, 63, 290, 63); // línea horizontal
  doc.line(6, 68, 290, 68); // línea horizontal
  doc.line(6, 73, 290, 73); // línea horizontal
  doc.line(6, 78, 290, 78); // línea horizontal
  doc.line(6, 83, 290, 83); // línea horizontal
  doc.line(6, 88, 290, 88); // línea horizontal
  doc.line(6, 93, 290, 93); // línea horizontal
  doc.line(6, 98, 290, 98); // línea horizontal
  doc.line(6, 103, 290, 103); // línea horizontal
  doc.line(6, 108, 290, 108); // línea horizontal
  doc.line(6, 113, 290, 113); // línea horizontal
  doc.line(6, 118, 290, 118); // línea horizontal
  doc.line(6, 123, 290, 123); // línea horizontal
  doc.line(6, 128, 290, 128); // línea horizontal

  doc.line(6, 140, 290, 140); //linea horizontal
  doc.text(" ", 12, 143);
  //doc.text("FECHA", 30, 143);
  doc.text("OBSERVACIONES", 65, 143);
  doc.text("ACCIONES CORRECTIVAS", 170, 143);
  //doc.text("VERIFICACIÓN REALIZADA", 215, 143);
  doc.text("V°B° SUPERVISOR", 260, 143);

  doc.line(6, 140, 290, 140); //linea horizontal

  let s1 = 145;
  doc.line(6, 145, 290, 145); // línea horizontal
  doc.line(6, 150, 290, 150); // línea horizontal
  doc.line(6, 155, 290, 155); // línea horizontal
  doc.line(6, 160, 290, 160); // línea horizontal
  doc.line(6, 165, 290, 165); // línea horizontal
  doc.line(6, 170, 290, 170); // línea horizontal
  doc.line(6, 175, 290, 175); // línea horizontal

  doc.line(6, 140, 6, 175); //1 linea vertical/**/
  doc.line(16, 140, 16, 175); //2 linea vertical/**/
  //doc.line(60, 140, 60, 175); //3 linea vertical/**/
  doc.line(130, 140, 130, 175); //4 linea vertical/**/
  doc.line(240, 140, 240, 175); //5 linea vertical/**/
  doc.line(250, 140, 250, 175); //6 linea vertical/**/
  doc.line(290, 140, 290, 175); //ultima linea vertical

  doc.setFontSize(7);
  doc.line(120, 192, 185, 192); //linea horizontal de firma
  doc.text("Jefe de Aseguramiento de la Calidad", 130, 195); //text de firma
  doc.text("FECHA", 135, 200); //linea de fecha debajo de firma
  doc.line(145, 200, 165, 200); //linea horizontal fecha debajo de firma
}

function traer_datos_productos_ylotesPendientes() {
  //DATOS PARA LA BUSQUEDA Y GENERAR LA TABLA
  var productos = [];
  var lotes = [];

  $.ajax({
    url: "c_insumos.php",
    type: "POST",
    data: { action: "EnviarDatosProductosYLotesBusqueda1" },
    datatype: "json",
    success: function (response) {
      console.log(response);
      response.forEach(function (item) {
        productos.push({ label: item.label, cod_producto: item.cod_producto });
        lotes.push({ label: item.lote_b, cod_producto: item.cod_producto });
      });

      $("#nombre_producto_busca").autocomplete({
        source: function (request, response) {
          var results = $.ui.autocomplete.filter(productos, request.term);
          response(results.slice(0, 10));
        },
        select: function (event, ui) {
          $("#cod_producto_busca").val(ui.item.cod_producto);
        },
      });

      $("#nombre_lote_busca").autocomplete({
        source: function (request, response) {
          var currentProduct = $("#cod_producto_busca").val();
          var filteredLotes = lotes.filter(function (item) {
            return item.cod_producto === currentProduct;
          });
          var results = $.ui.autocomplete.filter(filteredLotes, request.term);
          response(results.slice(0, 10));
        },
        select: function (event, ui) {
          $("#cod_lote_busca").val(ui.item.label);
        },
      });
    },
    error: function (err) {
      console.error(err);
    },
  });
}

function pre_carga_datos_pendientes_bachada() {
  $(".generar_datos_busqueda").on("click", function () {
    var cod_producto_busca = $("#cod_producto_busca").val();
    var cod_lote_busca = $("#cod_lote_busca").val();

    $.ajax({
      url: "c_insumos.php",
      type: "POST",
      data: {
        action: "pre_carga_datos_pendientes_bachada1",
        cod_producto_busca: cod_producto_busca,
        cod_lote_busca: cod_lote_busca,
      },
      datatype: "json",
      beforeSend: function () {
        $("#loadingModal").modal("show"); // mostrar el modal
      },
      success: function (response) {
        console.log("respuesta");
        console.log(response);

        if (response.length > 0) {
          $("#contenido1").show();
          $("#tablaDatosPendientes_Bachadas").show();
          $("#tablaDatosPendientes_Bachadas tbody").empty(); // Vacía la tabla antes de cargar nuevos datos

          for (var i = 0; i < response.length; i++) {
            for (var i = 0; i < response.length; i++) {
              var item = response[i];
              var newRow = `
                    <tr>
                        <td class="id_kard" data-id_kard="${
                          item.ID
                        }" data-estado_fila="${item.ESTADO}">${i + 1}</td>
                        <td>${item.DES_PRODUCTO}</td>
                        <td>${item.BACHADA}</td>
                        <td>${item.LOTE}</td>
                        <td>${formatDate(item.FECHA_MEZCLADO)}</td>
                        

                        <td>${item.SALDO}</td>
                        <td style="display: none;">${item.ID}</td>

                        <td><input type="radio" name="check_bolsas_add" id="check_bolsas_add"></td>
                        <td><button onclick="generar_maqueta_bachada('${
                          item.ID
                        }')" class="btn btn-success btn_agregar_bachada_genera"><i class='fas fa-plus'></i></button></td>
                    </tr>`;
              $("#tablaDatosPendientes_Bachadas tbody").append(newRow);
            }
          }
          //<td>${item.TOTAL_ITEM_BOLSAS}</td>
        } else {
          Swal.fire({
            icon: "warning",
            title: "Datos no validos.",
            text: "No se encontro coincidencias en la búsqueda, verifique si los datos ingresados son correctos",
          });
          //console.log('1');
          $("#tablaDatosPendientes_Bachadas").hide();
          //$('#contenido').html('<br><h5>No hay elementos pendientes.</h5>');
        }

        // Desactivar botones después de hacer clic en el botón "Agregar"
        $("button.btn_agregar_bachada_genera").on("click", function () {
          $("button.btn_agregar_bachada_genera").prop("disabled", true); // Deshabilitar todos los botones "Agregar"
          $(this).closest("tr").remove(); // Eliminar la fila actual después de hacer clic en el botón
        });

        // Desactivar todos los checkboxes al principio
        $('input[type="radio"]').prop("disabled", true);

        // Iterar sobre cada fila para obtener y establecer el estado de los checkboxes
        $("#tablaDatosPendientes_Bachadas tbody")
          .find("tr")
          .each(function () {
            var estado_fila = $(this).find(".id_kard").data("estado_fila");
            var checkbox = $(this).find('input[type="radio"]');

            if (estado_fila === "P") {
              checkbox.prop("disabled", true);
            } else if (estado_fila === "S") {
              checkbox.prop("disabled", false);
            }
          });

        // Después de tu bucle para agregar filas a la tabla
        $("#tablaDatosPendientes_Bachadas tbody")
          .find("tr")
          .each(function () {
            var estado_fila = $(this).find(".id_kard").data("estado_fila");
            var botonAgregar = $(this).find(".btn_agregar_bachada_genera");

            if (estado_fila === "S") {
              botonAgregar.prop("disabled", true);
              $("#valida_bachada_obligatoria").val("OB");
            } else {
              botonAgregar.prop("disabled", false);
            }
          });

        limpiar_datos_input_bachada();
        $("#contenido_maqueta_bachada").hide();

        $('input[name="check_bolsas_add"]').on("change", function () {
          console.log("radio_selec");
          var valida_bachada_inicial = $("#codigo_id_kardex").val();
          console.log(valida_bachada_inicial);
          if (valida_bachada_inicial == "") {
            Swal.fire({
              icon: "warning",
              title: "Alerta",
              text: "Primero debe agregar una bachada.",
            });
            $('input[name="check_bolsas_add"]').prop("checked", false);
            return;
          }
        });
      },
      error: function (err) {
        $("#loadingModal").modal("hide");
        console.error(err);
      },
      complete: function () {
        $("#loadingModal").modal("hide"); // esconder el modal
      },
    });
  });
}

function guardar_datos_bachada() {
  $("#myFormMaquetaBachada").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      type: "POST",
      url: "c_insumos.php",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function () {
        $("#loadingGeneral").modal("show"); // mostrar el modal
      },
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Éxito",
            text: res.message,
          }).then(function () {
            location.reload();
          });
        } else if (res.status === "error") {
          Swal.fire({
            icon: "error",
            title: "Error",
            html: res.message,
          });
        }
      },
      error: function () {
        $("#loadingGeneral").modal("hide");
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Ha ocurrido un error al procesar la solicitud",
        });
      },
      complete: function () {
        $("#loadingGeneral").modal("hide"); // esconder el modal
      },
    });
  });
}

function generar_maqueta_bachada(id_bachada) {
  $.ajax({
    url: "c_insumos.php",
    type: "POST",
    data: {
      action: "traer_dato_maqueta_bachada_1",
      id_bachada: id_bachada,
    },
    datatype: "json",
    beforeSend: function () {
      $("#loadingModalMaqueta").modal("show"); // mostrar el modal
    },
    success: function (response) {
      console.log("respuesta maqueta");
      console.log(response);
      limpiar_datos_input_bachada();

      $("#codigo_id_kardex").val(response.ID);
      $("#peso_neto_producto").val(response.PESO_NETO);

      $("#producto_bachada").val(response.DES_PRODUCTO);
      $("#fecha_mezclado").val(formatDate(response.FECHA_MEZCLADO));
      $("#cantidad_de_bolsas").val(response.TOTAL_ITEM_BOLSAS);

      $("#numero_bachada").val(response.BACHADA);
      $("#lote_bachada").val(response.LOTE);
      $("#peso_total_obtenido").val(response.SALDO);

      $("#fecha_de_produccion").val(formatDate(response.FECHA_PRODUCCION));
      $("#fecha_de_vencimiento").val(formatDate(response.FECHA_VENCIMIENTO));

      $("#contenido_maqueta_bachada").show();

      console.log("fin");

      // Manejar el evento del checkbox
      $('input[name="check_bolsas_add"]').on("change", function () {
        if (this.checked) {
          // Obtener la fila actual
          var row = $(this).closest("tr");

          // Obtener el saldo de esa fila específica
          var saldoFila = parseFloat(row.find("td:eq(5)").text()); // Ajusta el índice si es necesario

          $("#bachada_anterior").val(saldoFila);

          var id_bachada_anterior = parseFloat(row.find("td:eq(6)").text());

          //var id_kard = parseFloat($('td.id_kard').data('id_kard'));
          console.log("id" + id_bachada_anterior);
          $("#codigo_id_kardex_sobrante").val(id_bachada_anterior);

          $("#cantidad_programada_unidades").val("");
          $("#peso_estimado_kg").val("");
          $("#bolsas_seleccionadas_cantidad").val("");
          $("#bolsas_seleccionadas_peso_total_kg").val("");
          $("#bolsa_incompleta_mezcla_seleccionada").val("");
          $("#mezcla_sobrante").val("");
          $("#mezcla_total_envasar").val("");
          $("#cantidad_estimada_unidad").val("");
          $("#bolsas_sobrantes_cantidad").val("");
          $("#bolsas_sobrante_peso_total").val("");
        }
      });
    },
    error: function (err) {
      $("#loadingModalMaqueta").modal("hide");
      console.error(err);
    },
    complete: function () {
      $("#loadingModalMaqueta").modal("hide"); // esconder el modal
    },
  });
}

function limpiar_datos_input_bachada() {
  $(
    "#codigo_id_kardex, #peso_neto_producto, #nombre_encargado, #codigo_encargado, #producto_bachada, #fecha_mezclado, #numero_bachada, #peso_total_obtenido, #cantidad_de_bolsas"
  ).val("");

  $(
    "#cantidad_programada_unidades, #peso_estimado_kg, #bolsas_seleccionadas_cantidad, #bolsas_seleccionadas_peso_total_kg, #bolsa_incompleta_mezcla_seleccionada"
  ).val("");

  $(
    "#mezcla_sobrante, #mezcla_total_envasar, #cantidad_estimada_unidad, #bolsas_sobrantes_cantidad, #bolsas_sobrante_peso_total, #lote_bachada"
  ).val("");

  $(
    "#fecha_de_produccion, #fecha_de_vencimiento, #observaciones_envasado, #acc_correctiva_envasado"
  ).val("");
}

//INPUT CANTIDAD PROGRAMADA UNIDADES
function calcularTotalPesoEstimadoKg() {
  var total = 0;

  var cantidad_programada_unidades =
    parseFloat($("#cantidad_programada_unidades").val()) || 0;
  var peso_neto_producto = parseFloat($("#peso_neto_producto").val()) || 0;
  total = cantidad_programada_unidades * peso_neto_producto;

  $("#peso_estimado_kg").val(total.toFixed(3));
  console.log("ge 01");
}
$("#cantidad_programada_unidades").on("input", calcularTotalPesoEstimadoKg);

//INPUT BOLSAS INCOMPLETA (MEZCLA SELECCIONADA)
function calcularTotales() {
  var totalSobrante = 0;
  var totalEnvasar = 0;

  var peso_total_obtenido = parseFloat($("#peso_total_obtenido").val()) || 0;
  var bolsas_seleccionadas_peso_total_kg =
    parseFloat($("#bolsas_seleccionadas_peso_total_kg").val()) || 0;
  var bolsa_incompleta_mezcla_seleccionada =
    parseFloat($("#bolsa_incompleta_mezcla_seleccionada").val()) || 0;
  var bachada_anterior = parseFloat($("#bachada_anterior").val()) || 0;

  totalSobrante =
    peso_total_obtenido +
    bachada_anterior -
    (bolsas_seleccionadas_peso_total_kg + bolsa_incompleta_mezcla_seleccionada);
  totalEnvasar =
    bolsas_seleccionadas_peso_total_kg + bolsa_incompleta_mezcla_seleccionada;

  cantidad_estimada_unidades = (totalEnvasar * 100) / 60;

  $("#mezcla_sobrante").val(totalSobrante.toFixed(3));
  $("#bolsas_sobrante_peso_total").val(totalSobrante.toFixed(3));
  $("#mezcla_total_envasar").val(totalEnvasar.toFixed(3));
  $("#cantidad_estimada_unidad").val(
    parseInt(Math.round(cantidad_estimada_unidades))
  );
  console.log("nm 01");
}
$("#bolsa_incompleta_mezcla_seleccionada").on("input", calcularTotales);
$("#bolsas_seleccionadas_peso_total_kg").on("input", calcularTotales);

//INPUT BOLSAS SELECCIONADAS(CANTIDAD)
function calcularBolsasSobrantes() {
  var totalCantidadBolsasSobrante = 0;

  var cantidad_total_bolsas = parseFloat($("#cantidad_de_bolsas").val()) || 0;
  var bolsas_seleccionadas_cantidad =
    parseFloat($("#bolsas_seleccionadas_cantidad").val()) || 0;

  totalCantidadBolsasSobrante =
    cantidad_total_bolsas - bolsas_seleccionadas_cantidad;

  $("#bolsas_sobrantes_cantidad").val(totalCantidadBolsasSobrante);
  console.log("ej 01");
}
$("#bolsas_seleccionadas_cantidad").on("input", calcularBolsasSobrantes);

function traer_datos_productos_ylotesReporte() {
  //DATOS PARA GENERAR EL REPORTE
  var productos = [];
  var lotes = [];

  $.ajax({
    url: "c_insumos.php",
    type: "POST",
    data: { action: "TraerDatosProducto_lote_envasado1" },
    datatype: "json",
    success: function (response) {
      console.log(response);
      response.forEach(function (item) {
        productos.push({ label: item.label, cod_producto: item.cod_producto });
        lotes.push({ label: item.lote_b, cod_producto: item.cod_producto });
      });

      $("#nombre_producto_pdf").autocomplete({
        source: function (request, response) {
          var results = $.ui.autocomplete.filter(productos, request.term);
          response(results.slice(0, 10));
        },
        select: function (event, ui) {
          $("#cod_producto_pdf").val(ui.item.cod_producto);
        },
      });

      $("#nombre_lote_pdf").autocomplete({
        source: function (request, response) {
          var currentProduct = $("#cod_producto_pdf").val();
          var filteredLotes = lotes.filter(function (item) {
            return item.cod_producto === currentProduct;
          });
          var results = $.ui.autocomplete.filter(filteredLotes, request.term);
          response(results.slice(0, 10));
        },
        select: function (event, ui) {
          $("#cod_lote_pdf").val(ui.item.label);
        },
      });
    },
    error: function (err) {
      console.error(err);
    },
  });
}

$(document).ready(function () {
  window.jsPDF = window.jspdf.jsPDF;

  traer_datos_productos_ylotesPendientes();

  pre_carga_datos_pendientes_bachada();

  guardar_datos_bachada();

  generar_pdfControlBachada_2();

  buscar_nombre_encargado();

  traer_datos_productos_ylotesReporte();
});
