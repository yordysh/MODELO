function buscar_nombre_encargado() {
  var nombres = [];
  $.ajax({
    url: "./c_insumos.php",
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

function generar_filas_tabla_dinamica() {
  var contadorFilas = 0; // Contador para el ítem

  $("#agregarFila").on("click", function () {
    contadorFilas++; // Incrementa el contador en cada inserción de fila

    // Crea una nueva fila con los campos necesarios
    var nuevaFila =
      "<tr>" +
      "<td>" +
      "<input type='hidden' class='form-control' name='contadorFilas[]' value=" +
      contadorFilas +
      ">" +
      contadorFilas +
      "</td>" +
      "<td><input type='text' class='form-control' name='codigo_interno[]' maxlength='10'></td>" +
      "<td><input type='time' class='form-control' name='hora_inicial[]'></td>" +
      "<td><input type='time' class='form-control' name='hora_final[]'></td>" +
      "<td><input type='text' class='form-control' name='peso[]' maxlength='7'></td>" +
      "<td><input type='text' class='form-control' name='observaciones[]' maxlength='30'></td>" +
      "<td><input type='text' class='form-control' name='acciones_correctivas[]' maxlength='30'></td>" +
      "<td><button class='eliminarFila btn btn-danger'><i class='fas fa-trash'></button></td>" +
      "</tr>";

    // Agrega la nueva fila a la tabla
    $("#tablaDetalleInsumos tbody").append(nuevaFila);
  });

  // Agrega el evento para eliminar la fila
  $("#tablaDetalleInsumos").on("click", ".eliminarFila", function () {
    $(this).closest("tr").remove();
  });
}

// Función para calcular la suma del peso
function calcularTotalMezcla() {
  var total = 0;
  // Itera por cada campo de PESO de la tabla principal
  $('#tablaDetalleInsumos input[name="peso[]"]').each(function () {
    var peso = parseFloat($(this).val()) || 0;
    total += peso;
  });
  // Redondea el total a dos decimales
  return total.toFixed(3);
}

// Asigna el evento keyup para actualizar el total cuando se modifiquen los valores
$("#tablaDetalleInsumos").on("keyup", 'input[name="peso[]"]', function () {
  var totalMezcla = calcularTotalMezcla();
  $("#totalMezcla").val(totalMezcla);
});

function pre_carga_datos_pendientes() {
  $.ajax({
    url: "./c_insumos.php",
    type: "POST",
    data: { action: "pre_carga_datos_pendientes1" },
    datatype: "json",
    beforeSend: function () {
      $("#loadingModal").modal("show"); // mostrar el modal
    },
    success: function (response) {
      console.log("respuesta");
      console.log(response);

      if (response.length > 0) {
        $("#tablaDatosPendientes").show();
        $("#tablaDatosPendientes tbody").empty(); // Vacía la tabla antes de cargar nuevos datos

        for (var i = 0; i < response.length; i++) {
          for (var i = 0; i < response.length; i++) {
            var item = response[i];
            var newRow = `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${item.DES_PRODUCTO}</td>
                        <td>${item.N_BACHADA}</td>
                        <td>${item.NUM_PRODUCION_LOTE}</td>
                        <td>${formatDate(item.FECHA)}</td>
                        <td><button onclick="generar_maqueta_insumos('${
                          item.COD_AVANCE_INSUMOS
                        }')" class="btn btn-success"><i class='fas fa-plus'></i></button></td>
                    </tr>`;
            $("#tablaDatosPendientes tbody").append(newRow);
          }
        }
      } else {
        $("#tablaDatosPendientes").hide();
        $("#contenido").html("<br><h5>No hay elementos pendientes.</h5>");
      }
    },
    error: function (err) {
      $("#loadingModal").modal("hide");
      console.error(err);
    },
    complete: function () {
      $("#loadingModal").modal("hide"); // esconder el modal
    },
  });
}

function generar_maqueta_insumos(cod_avance_insumos) {
  //console.log('cod_avance_insumos ' + cod_avance_insumos)
  $.ajax({
    url: "./c_insumos.php",
    type: "POST",
    data: {
      action: "traer_dato_maqueta_1",
      cod_avance_insumos: cod_avance_insumos,
    },
    datatype: "json",
    beforeSend: function () {
      $("#loadingModalMaqueta").modal("show"); // mostrar el modal
    },
    success: function (response) {
      console.log("respuesta maqueta");
      console.log(response);

      $("#codigo_avance_insumo").val("");
      $("#nombre_encargado").val("");
      $("#codigo_encargado").val("");
      $("#fecha_dato").val("");
      $("#nombre_producto").val("");
      $("#numero_bachada").val("");
      $("#peso_mezcla").val("");
      $("#lote").val("");

      $("#totalMezcla").val("");
      $("#totalMerma").val("");

      $("#codigo_avance_insumo").val(response.COD_AVANCE_INSUMOS);
      $("#fecha_dato").val(formatDate(response.FECHA));
      $("#nombre_producto").val(response.DES_PRODUCTO);
      $("#numero_bachada").val(response.N_BACHADA);
      $("#peso_mezcla").val(response.CANT_INSUMOS);
      $("#lote").val(response.NUM_PRODUCION_LOTE);

      $("#tablaDetalleInsumos tbody").empty();
      $("#contenido_maqueta").show();

      console.log("fin");
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

function guardar_maqueta_datos() {
  $("#myFormMaqueta").submit(function (event) {
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

function formatDate(date) {
  var fecha = new Date(date);
  var dd = String(fecha.getDate()).padStart(2, "0");
  var mm = String(fecha.getMonth() + 1).padStart(2, "0");
  var yyyy = fecha.getFullYear();
  return dd + "/" + mm + "/" + yyyy;
}

function llenar_Datos_input_cod() {
  var nombres = [];
  var lotes = [];
  $.ajax({
    url: "./c_insumos.php",
    type: "POST",
    data: { action: "traer_datos_cod_producto_produccion1" },
    datatype: "json",
    success: function (response) {
      console.log("respuesta datos p");
      //console.log(response);

      // Recorrer todos los elementos y almacenar los nombres y lotes
      response.forEach(function (data) {
        nombres.push(data.datos_producto);
        lotes.push(data.datos_produccion);
      });

      var allNombres = nombres.flat(); // Convertir todos los nombres en una sola lista
      var allLotes = lotes.flat(); // Convertir todos los lotes en una sola lista

      //console.log(allNombres);
      //console.log(allLotes);

      $("#nombre_producto_pdf").autocomplete({
        source: function (request, response) {
          var results = $.ui.autocomplete.filter(allNombres, request.term);
          response(results.slice(0, 10));
        },
        select: function (event, ui) {
          console.log("Evento select disparado");
          $("#cod_producto_pdf").val(ui.item.codigo);
        },
      });

      $("#nombre_lote_pdf").autocomplete({
        source: function (request, response) {
          var results = $.ui.autocomplete.filter(allLotes, request.term);
          response(results.slice(0, 10));
        },
        select: function (event, ui) {
          console.log("Evento select disparado");
          $("#cod_lote_pdf").val(ui.item.codigo);
        },
      });
    },
    error: function (err) {
      console.log(err);
    },
  });
}

function generar_pdf_reporte_1() {
  $(document).on("click", "button.generar_pdf_reporte", function () {
    var cod_producto = $("#cod_producto_pdf").val();
    var cod_lote = $("#cod_lote_pdf").val();
    console.log(cod_producto);
    console.log(cod_lote);

    $.ajax({
      url: "./c_insumos.php",
      type: "POST",
      data: {
        action: "traer_datos_reporte_pdf1",
        cod_producto_pdf: cod_producto,
        cod_lote_pdf: cod_lote,
      },
      datatype: "json",
      success: function (response) {
        console.log("respuesta datos reporte");
        console.log(response);

        //var prueba = response[0];
        //console.log(prueba);

        if (response.length > 0) {
          var doc = new jsPDF({
            orientation: "landscape",
          });

          for (let i = 0; i < response.length; i += 2) {
            console.log(i);
            const item1 = response[i];
            const item2 = response[i + 1];

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
            doc.setFontSize(20);
            doc.text("CONTROL DE MEZCLADO Y CERNIDO", 75, 19); //TITULO DOSIMETRIA
            doc.line(210, 6.5, 210, 26); //linea vertical
            doc.line(290, 6.5, 290, 26); //linea vertical
            doc.setFontSize(9);
            doc.setFont("helvetica", "bold");
            doc.text("CÓDIGO: " + response[0].DATO_VERSION.NOMBRE, 211, 11); //reemplazar
            doc.line(210, 13, 290, 13); //linea horizontal
            doc.text(
              "FECHA: " + response[0].NOMBRE_MES + " " + response[0].ANIO,
              211,
              17
            ); //campo para agregar la version reemplazar
            doc.line(210, 19, 290, 19); //linea horizontal
            doc.text("VERSIÓN: " + response[0].DATO_VERSION.VERSION, 211, 23.5); //campo para agregar la fecha reemplazar

            if (item1) {
              /*primera columna----  PARTE IZQUIERDA*/
              const nombreCompleto = item1.NOM_PERSONAL.NOM_PERSONAL1;
              const primeraPalabra = nombreCompleto.split(" ")[0]; // Obtiene la primera palabra

              doc.text("ENCARGADO: " + primeraPalabra, 6, 31);
              doc.line(28, 32, 70, 32); //linea horizontal

              doc.text("PRODUCTO: " + item1.DES_PRODUCTO, 6, 38);
              doc.line(26, 39, 70, 39); //linea horizontal

              doc.text("PESO DE MEZCLA: ", 6, 45);
              doc.text(item1.CANT_INSUMOS, 50, 45);
              doc.line(36, 46, 70, 46); //linea horizontal

              doc.text("FECHA:   " + formatDate(item1.FECHA), 76, 31);
              doc.line(88, 32, 137, 32); //linea horizontal

              doc.text("Nº BACHADA:       " + item1.N_BACHADA, 76, 38);
              doc.line(98, 39, 137, 39); //linea horizontal

              doc.text("LOTE: ", 76, 45);
              doc.text(item1.NUM_PRODUCION_LOTE, 90, 45);
              doc.line(86, 46, 137, 46); //linea horizontal
              /*----------------------------------------------------*/

              /*-------------PRIMERA TABLA */
              doc.line(6, 52, 137, 52); //linea horizontal
              doc.line(6, 52, 6, 152); //primera linea vertical
              doc.line(25, 52, 25, 152); // linea vertical
              doc.line(45, 52, 45, 152); // linea vertical
              doc.line(63, 52, 63, 152); // linea vertical
              doc.line(77, 52, 77, 152); // linea vertical
              doc.line(108, 52, 108, 152); // linea vertical
              doc.line(137, 52, 137, 152); // ultima linea vertical

              doc.text("CODIGO ", 9, 56);
              doc.text("INTERNO", 9, 60);
              doc.text("HORA ", 30, 56);
              doc.text("INICIAL", 30, 60);
              doc.text("HORA ", 50, 56);
              doc.text("FINAL", 50, 60);
              doc.text("PESO", 65, 58);
              doc.text("OBSERVACIONES", 78, 58);
              doc.text("ACCIONES ", 110, 56);
              doc.text("CORRECTIVAS", 110, 60);

              doc.line(6, 62, 137, 62); //linea horizontal

              let p = 68;
              for (let i = 0; i < 15; i++) {
                doc.line(6, p, 137, p); //linea horizontal
                //doc.text("Dato ", 9, p - 2); // Ajusta la posición vertical para el texto
                // Verifica si hay un elemento en item1.items[j]
                if (i < item1.items.length) {
                  doc.text(item1.items[i].CODIGO_INTERNO, 9, p - 2); // Agrega el CODIGO_INTERNO en cada fila
                  doc.text(item1.items[i].HORA_INICIAL, 30, p - 2);
                  doc.text(item1.items[i].HORA_FINAL, 50, p - 2);
                  doc.text(item1.items[i].PESO, 65, p - 2);
                  if (
                    item1.items[i].OBSERVACIONES !== null &&
                    item1.items[i].OBSERVACIONES !== undefined
                  ) {
                    let observaciones = item1.items[i].OBSERVACIONES;
                    if (observaciones.length > 10) {
                      observaciones = observaciones.substring(0, 10); // Limitar a 10 caracteres
                    }
                    doc.text(observaciones, 78, p - 2);
                  }
                  if (
                    item1.items[i].ACCION_CORRECTIVA !== null &&
                    item1.items[i].ACCION_CORRECTIVA !== undefined
                  ) {
                    let accion_correctiva = item1.items[i].ACCION_CORRECTIVA;
                    if (accion_correctiva.length > 10) {
                      accion_correctiva = accion_correctiva.substring(0, 10); // Limitar a 10 caracteres
                    }
                    doc.text(accion_correctiva, 110, p - 2);
                  }
                }
                p += 6;
              }

              /*TABLA DEBAJO MAS COLUMNA 1 LADO IZQUIERDO*/

              doc.line(6, 158, 137, 158); //primera linea horizontal
              doc.line(6, 180, 6, 158); //primera linea vertical

              doc.line(63, 158, 63, 165); // segunda linea vertical
              doc.line(63, 180, 63, 172); // segunda - 2 linea vertical

              doc.line(137, 180, 137, 158); // ultima linea vertical

              doc.line(6, 165, 137, 165); // segunda linea horizontal
              doc.line(6, 172, 137, 172); // tercera linea horizontal
              doc.line(6, 180, 137, 180); // cuarta linea horizontal

              doc.text("TOTAL DE MEZCLA", 20, 162);
              doc.text("TOTAL DE MERMA", 80, 162);
              doc.text("Kg", 61, 170);
              doc.text(item1.TOTAL_MEZCLA, 30, 177); //TOTAL MEZCLA DATO
              doc.text(item1.MERMA, 90, 177); //TOTAL MERMA DATO

              doc.setFontSize(7);
              doc.line(9, 200, 60, 200); //linea horizontal de firma 1
              doc.text("Firma del Asistente de calidad", 18, 205); //text de firma 1
              doc.line(78, 200, 135, 200); //linea horizontal de firma 2
              doc.text(
                "Firma del Jefe de Aseguramiento de la calidad",
                80,
                205
              ); //text de firma 2
              /*------------*/
              doc.setFontSize(9);
              doc.setFont("helvetica", "bold");
            }

            if (item2) {
              /*segunda columna PARTE DERECHA*/
              const nombreCompleto2 = item2.NOM_PERSONAL.NOM_PERSONAL1;
              const primeraPalabra2 = nombreCompleto2.split(" ")[0]; // Obtiene la primera palabra

              doc.text("ENCARGADO: " + primeraPalabra2, 160, 31);
              doc.line(182, 32, 224, 32); //linea horizontal

              doc.text("PRODUCTO: " + item2.DES_PRODUCTO, 160, 38);
              doc.line(180, 39, 224, 39); //linea horizontal

              doc.text("PESO DE MEZCLA: ", 160, 45);
              doc.text(item2.CANT_INSUMOS, 205, 45);
              doc.line(190, 46, 224, 46); //linea horizontal

              doc.text("FECHA:   " + formatDate(item1.FECHA), 229, 31);
              doc.line(242, 32, 290, 32); //linea horizontal

              doc.text("Nº BACHADA:        " + item2.N_BACHADA, 229, 38);
              doc.line(251, 39, 290, 39); //linea horizontal

              doc.text("LOTE: ", 229, 45);
              doc.text(item1.NUM_PRODUCION_LOTE, 250, 45);
              doc.line(239, 46, 290, 46); //linea horizontal/**/

              /*-SEGUNDA TABLA PARTE DERECHA*/
              doc.line(159, 52, 159, 152); //primera linea vertical/**/
              doc.line(178, 52, 178, 152); //segunda linea vertical
              doc.line(198, 52, 198, 152); // tercera linea vertical
              doc.line(216, 52, 216, 152); // cuarta linea vertical
              doc.line(230, 52, 230, 152); //quinta linea vertical
              doc.line(261, 52, 261, 152); //sexta linea vertical
              doc.line(290, 52, 290, 152); //linea vertical

              doc.line(159, 52, 290, 52); //primera linea horizontal/**/
              doc.text("CODIGO ", 162.5, 56);
              doc.text("INTERNO", 162.5, 60);
              doc.text("HORA ", 183, 56);
              doc.text("INICIAL", 183, 60);
              doc.text("HORA ", 203, 56);
              doc.text("FINAL", 203, 60);
              doc.text("PESO", 218, 58);
              doc.text("OBSERVACIONES", 231, 58);
              doc.text("ACCIONES ", 263, 56);
              doc.text("CORRECTIVAS", 263, 60);
              doc.line(159, 62, 290, 62); //ultima horizontal/**/

              let s = 68;
              for (let i = 0; i < 15; i++) {
                doc.line(159, s, 290, s); //linea horizontal

                if (i < item2.items.length) {
                  doc.text(item2.items[i].CODIGO_INTERNO, 162.5, s - 2); // Agrega el CODIGO_INTERNO en cada fila
                  doc.text(item2.items[i].HORA_INICIAL, 183, s - 2);
                  doc.text(item2.items[i].HORA_FINAL, 203, s - 2);
                  doc.text(item2.items[i].PESO, 218, s - 2);
                  if (
                    item2.items[i].OBSERVACIONES !== null &&
                    item2.items[i].OBSERVACIONES !== undefined
                  ) {
                    let observaciones = item2.items[i].OBSERVACIONES;
                    if (observaciones.length > 10) {
                      observaciones = observaciones.substring(0, 10); // Limitar a 10 caracteres
                    }
                    doc.text(observaciones, 231, s - 2);
                  }
                  if (
                    item2.items[i].ACCION_CORRECTIVA !== null &&
                    item2.items[i].ACCION_CORRECTIVA !== undefined
                  ) {
                    let accion_correctiva = item2.items[i].ACCION_CORRECTIVA;
                    if (accion_correctiva.length > 10) {
                      accion_correctiva = accion_correctiva.substring(0, 10); // Limitar a 10 caracteres
                    }
                    doc.text(accion_correctiva, 263, s - 2);
                  }
                }

                s += 6;
              }

              /*TABLA DEBAJO MAS COLUMNA 1 LADO DERECHO*/
              doc.line(159, 180, 159, 158); //primera linea vertical
              doc.line(216, 158, 216, 165); // segunda linea vertical
              doc.line(216, 180, 216, 172); // segunda - 2 linea vertical
              doc.line(290, 180, 290, 158); // ultima linea vertical

              doc.line(159, 158, 290, 158); //primera linea horizontal
              doc.line(159, 165, 290, 165); // segunda linea horizontal
              doc.line(159, 172, 290, 172); // tercera linea horizontal
              doc.line(159, 180, 290, 180); // cuarta linea horizontal

              doc.text("TOTAL DE MEZCLA", 173, 162);
              doc.text("TOTAL DE MERMA", 233, 162);
              doc.text("Kg", 214, 170);

              doc.text(item2.TOTAL_MEZCLA, 183, 177); //TOTAL MEZCLA DATO
              doc.text(item2.MERMA, 243, 177); //TOTAL MERMA DATO

              doc.setFontSize(30);

              doc.setFontSize(7);
              doc.line(162, 200, 212, 200); //linea horizontal de firma 1
              doc.text("Firma del Asistente de calidad", 170, 205); //text de firma 1
              doc.line(230, 200, 287.5, 200); //linea horizontal de firma 2
              doc.text(
                "Firma del Jefe de Aseguramiento de la calidad",
                232,
                205
              ); //text de firma 2
            } else {
              doc.text("ENCARGADO: ", 160, 31);
              doc.line(182, 32, 224, 32); //linea horizontal

              doc.text("PRODUCTO: ", 160, 38);
              doc.line(180, 39, 224, 39); //linea horizontal

              doc.text("PESO DE MEZCLA: ", 160, 45);
              doc.text(" ", 205, 45);
              doc.line(190, 46, 224, 46); //linea horizontal

              doc.text("FECHA: ", 229, 31);
              doc.line(242, 32, 290, 32); //linea horizontal

              doc.text("Nº BACHADA:        ", 229, 38);
              doc.line(251, 39, 290, 39); //linea horizontal

              doc.text("LOTE: ", 229, 45);
              doc.text(" ", 250, 45);
              doc.line(239, 46, 290, 46); //linea horizontal/**/

              /*-SEGUNDA TABLA PARTE DERECHA*/
              doc.line(159, 52, 159, 152); //primera linea vertical/**/
              doc.line(178, 52, 178, 152); //segunda linea vertical
              doc.line(198, 52, 198, 152); // tercera linea vertical
              doc.line(216, 52, 216, 152); // cuarta linea vertical
              doc.line(230, 52, 230, 152); //quinta linea vertical
              doc.line(261, 52, 261, 152); //sexta linea vertical
              doc.line(290, 52, 290, 152); //linea vertical

              doc.line(159, 52, 290, 52); //primera linea horizontal/**/
              doc.text("CODIGO ", 162.5, 56);
              doc.text("INTERNO", 162.5, 60);
              doc.text("HORA ", 183, 56);
              doc.text("INICIAL", 183, 60);
              doc.text("HORA ", 203, 56);
              doc.text("FINAL", 203, 60);
              doc.text("PESO", 218, 58);
              doc.text("OBSERVACIONES", 231, 58);
              doc.text("ACCIONES ", 263, 56);
              doc.text("CORRECTIVAS", 263, 60);
              doc.line(159, 62, 290, 62); //ultima horizontal/**/

              let s = 68;
              for (let i = 0; i < 15; i++) {
                doc.line(159, s, 290, s); //linea horizontal

                s += 6;
              }

              /*TABLA DEBAJO MAS COLUMNA 1 LADO DERECHO*/
              doc.line(159, 180, 159, 158); //primera linea vertical
              doc.line(216, 158, 216, 165); // segunda linea vertical
              doc.line(216, 180, 216, 172); // segunda - 2 linea vertical
              doc.line(290, 180, 290, 158); // ultima linea vertical

              doc.line(159, 158, 290, 158); //primera linea horizontal
              doc.line(159, 165, 290, 165); // segunda linea horizontal
              doc.line(159, 172, 290, 172); // tercera linea horizontal
              doc.line(159, 180, 290, 180); // cuarta linea horizontal

              doc.text("TOTAL DE MEZCLA", 173, 162);
              doc.text("TOTAL DE MERMA", 233, 162);
              doc.text("Kg", 214, 170);

              doc.text(" ", 183, 177); //TOTAL MEZCLA DATO
              doc.text(" ", 243, 177); //TOTAL MERMA DATO

              doc.setFontSize(30);

              doc.setFontSize(7);
              doc.line(162, 200, 212, 200); //linea horizontal de firma 1
              doc.text("Firma del Asistente de calidad", 170, 205); //text de firma 1
              doc.line(230, 200, 287.5, 200); //linea horizontal de firma 2
              doc.text(
                "Firma del Jefe de Aseguramiento de la calidad",
                232,
                205
              ); //text de firma 2
            }

            /*
                        if (response.length > 2) {
                            doc.addPage(); // Añade una nueva página
                        }*/

            if (i < response.length - 2) {
              doc.addPage();
            }
          }

          doc.save("reporte_insumos.pdf");
        } else {
          Swal.fire({
            icon: "warning",
            title: "Datos no validos.",
            text: "No se encontro coincidencias para poder exportar, verifique si los datos son correctos",
          });
        }
      },
      error: function (err) {
        console.log(err);
      },
    });
  });
}

$(document).ready(function () {
  window.jsPDF = window.jspdf.jsPDF;
  buscar_nombre_encargado();
  generar_filas_tabla_dinamica();

  pre_carga_datos_pendientes();

  guardar_maqueta_datos();

  llenar_Datos_input_cod();

  generar_pdf_reporte_1();
});
