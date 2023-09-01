$(function () {
  // mostarRequerimientoProducto();
  let edit = false;

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

  $("#selectInsumoEnvase").select2();
  //------------- Busqueda con ajax infraestructura Accesorio----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      let search = $("#search").val();
      const accion = "buscarrequerimientoproducto";

      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarrequerimiento: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);

            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.COD_REQUERIMIENTO}">
      
                              <td data-titulo="CODIGO PRODUCTO" >${task.DES_PRODUCTO}</td>      
                              <td data-titulo="CANTIDAD" >${task.CANTIDAD}</td>
  
                          </tr>`;
            });

            $("#tablaRequerimientoProducto").html(template);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos de la tabla:", error);
        },
      });
    } else {
      mostarRequerimientoProducto();
    }
  });
  //-------------------------------------------------------------------------//

  //--------------------- Insertar los valores insumos y envases ------------//

  $("#botonCalcularInsumoEnvase").click((e) => {
    e.preventDefault();
    let selectinsumoenvase = $("#selectInsumoEnvase").val();
    let textoInsumoEnvase = $("#selectInsumoEnvase option:selected").text();

    let cantidadinsumoenvase = $("#cantidadInsumoEnvase").val();

    let cantidadInsumoEnvaseEntero = parseInt(cantidadinsumoenvase);

    if (cantidadinsumoenvase != cantidadInsumoEnvaseEntero) {
      Swal.fire({
        icon: "error",
        title: "Valor decimal",
        text: "Por favor, ingrese un valor entero en cantidad",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadInsumoEnvase").val("");
        }
      });
      return;
    }

    if (!selectinsumoenvase || !cantidadinsumoenvase) {
      Swal.fire({
        icon: "error",
        title: "Campos vacíos",
        text: "Por favor, seleccione un producto y complete la cantidad.",
      });
      return;
    }
    if (parseFloat(cantidadinsumoenvase) <= 0) {
      Swal.fire({
        icon: "error",
        title: "Campo negativo",
        text: "Por favor, ingrese valor positivo en cantidad",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadInsumoEnvase").val("");
        }
      });
      return;
    }
    // if (!Number.isInteger(cantidadInsumoEnvase)) {
    //   Swal.fire({
    //     icon: "error",
    //     title: "No se aceptan decimales",
    //     text: "Por favor, escriba un valor entero y no decimal",
    //   }).then((resultado) => {
    //     if (resultado.isConfirmed || resultado.isDismissed) {
    //       $("#cantidadInsumoEnvase").val("");
    //     }
    //   });
    //   return;
    // }

    /*---------------  Añade tabla de total de cada producto-------------------*/

    const filaExistente = $(`tr[id="${selectinsumoenvase}"]`);

    if (filaExistente.length > 0) {
      const celdaCantidadPro = filaExistente.find(
        "td[data-titulo='CANTIDAD TOTAL']"
      );
      const cantidadActual = parseFloat(celdaCantidadPro.text());
      const nuevaCantidad = cantidadActual + parseFloat(cantidadinsumoenvase);

      celdaCantidadPro.text(nuevaCantidad);
    } else {
      let nuevaFila = $("<tr>");
      nuevaFila.attr("id", selectinsumoenvase);
      let celdaProducto = $("<td data-titulo='PRODUCTO'>").text(
        textoInsumoEnvase
      );
      celdaProducto.attr("id_item", selectinsumoenvase);
      let celdaCantidadPro = $("<td data-titulo='CANTIDAD TOTAL'>").text(
        cantidadinsumoenvase
      );
      nuevaFila.append(celdaProducto, celdaCantidadPro);

      $("#tablaTotal tbody").append(nuevaFila);
    }

    // });

    /*-------------------------------------------------------------------------*/

    const accion = "mostrardatosinsumos";
    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        selectinsumoenvase: selectinsumoenvase,
        cantidadinsumoenvase: cantidadinsumoenvase,
      },
      type: "POST",
      success: function (responseData) {
        if (!responseData.error) {
          const insumos = JSON.parse(responseData);
          let template = $("#tablaInsumosDatos").html();
          const existingRow = $(
            `tr[taskId="${insumos[0]["COD_FORMULACION"]}"]`
          );
          if (existingRow.length > 0) {
            const capturaValoresTabla = existingRow.find("td:eq(1)");

            for (let i = 0; i < capturaValoresTabla.length; i++) {
              const valorFormula = insumos[i].TOTAL;

              const valorCelda = capturaValoresTabla[i];
              const cambio = parseFloat($(valorCelda).html());
              const suma = cambio + parseFloat(valorFormula);
              const sumatotalinsumo = suma.toFixed(3);
              $(valorCelda).html(sumatotalinsumo);

              $("#cantidadInsumoEnvase").val("");
            }

            const codigoForm = $("#tinsumo tr:not(:first)");
            const capturavalorcantidad = codigoForm.find("td:eq(1)");
            let sumatotalinsumos = 0;
            for (let n = 0; n < capturavalorcantidad.length; n++) {
              const valorceldita = capturavalorcantidad[n];
              const cambiofloat = parseFloat($(valorceldita).html());
              sumatotalinsumos = sumatotalinsumos + cambiofloat;
            }
            const tablasuma = $("#tsumatotal tr:not(:first)");
            const capturadelvalor = tablasuma.find("td:eq(0)");

            if (tablasuma.length > 0) {
              const parse = sumatotalinsumos.toFixed(1);
              $(capturadelvalor).html(parse);
            }
          } else {
            insumos.forEach((insumo) => {
              template += `<tr taskId="${insumo.COD_FORMULACION}">
                                <td data-titulo="INSUMOS" id='${insumo.COD_PRODUCTO}'>${insumo.DES_PRODUCTO}</td>
                                <td data-titulo="CANTIDAD">${insumo.TOTAL}</td>
                             </tr>`;
            });
            $("#tablaInsumosDatos").html(template);

            const codigoForm = $("#tinsumo tr:not(:first)");
            const capturavalorcantidad = codigoForm.find("td:eq(1)");
            let sumatotalinsumos = 0;
            for (let n = 0; n < capturavalorcantidad.length; n++) {
              const valorceldita = capturavalorcantidad[n];
              const cambiofloat = parseFloat($(valorceldita).html());
              sumatotalinsumos = sumatotalinsumos + cambiofloat;
            }
            const tablasuma = $("#tsumatotal tr:not(:first)");
            const capturadelvalor = tablasuma.find("td:eq(0)");

            if (tablasuma.length > 0) {
              const parse = sumatotalinsumos.toFixed(1);
              $(capturadelvalor).html(parse);
            } else {
              let nuevaFila = $("<tr>");
              let celdasumatotalinsumo = $(
                "<td data-titulo='TOTAL INSUMOS'>"
              ).text(sumatotalinsumos.toFixed(1));
              nuevaFila.append(celdasumatotalinsumo);

              $("#tsumatotal tbody").append(nuevaFila);
            }

            $("#cantidadInsumoEnvase").val("");
          }
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error in ajaxInsumo AJAX:", textStatus, errorThrown);
      },
    });

    const accionEnvase = "mostrardatosenvases";
    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accionEnvase,
        seleccionadoinsumoenvases: selectinsumoenvase,
        cantidadesinsumoenvases: cantidadinsumoenvase,
      },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let envases = JSON.parse(response);

          let templateEnvase = $("#tablaenvase").html();

          const existeFila = $(
            `tr[idenvase="${envases[0]["COD_FORMULACIONES"]}"]`
          );

          if (existeFila.length > 0) {
            const capturaTabla = existeFila.find("td:eq(1)");
            for (let i = 0; i < capturaTabla.length; i++) {
              const valor = envases[i].TOTAL_ENVASE;
              const valorCeldas = capturaTabla[i];
              const cambios = parseFloat($(valorCeldas).html());
              const sumar = cambios + parseFloat(valor);
              const totalsumar = sumar.toFixed(3);
              $(valorCeldas).html(totalsumar);
              $("#cantidadInsumoEnvase").val("");
            }
          } else {
            envases.forEach((envase) => {
              templateEnvase += `<tr idenvase="${envase.COD_FORMULACIONES}">
                                <td data-titulo="ENVASES" id_envase='${envase.COD_PRODUCTO}'>${envase.DES_PRODUCTO}</td>
                                <td data-titulo="CANTIDAD">${envase.TOTAL_ENVASE}</td>
                             </tr>`;
            });
            $("#tablaenvase").html(templateEnvase);
          }
        }
      },
      error: function (xhr, status, error) {
        console.error("Error in ajaxEnvase:", error);
      },
    });
    //   });
    // }
  });
  //-------------------------------------------------------------------------//

  //--------------------- Insertar cantidades ------------//
  $("#botonInsertValor").click((e) => {
    e.preventDefault();
    let cantidadInsert = $("#cantidadInsumoEnvase").val();
    let tablaReqInsumo = $("#tablaInsumosDatos");
    let tablaReqEnv = $("#tablaenvase");
    let tablatotalInEn = $("#tablainsumoenvasetotal");

    let valoresCapturados = [];
    let valoresCapturadosEnvase = [];
    let valoresCapturadosTotalEnvase = [];

    $("#tablaInsumosDatos tr").each(function () {
      // let valorCelda = $(this).find("td:eq(1)").text();
      // valoresCapturados.push(valorCelda);
      // find(":input");
      let valorProducto = $(this).find("td:eq(0)").attr("id");
      let valorCan = $(this).find("td:eq(1)").html();
      // let cod_formula = $(this).attr("taskId");
      valoresCapturados.push(valorProducto, valorCan);
      // console.log(valorProducto + "hola" + valorCan + " cod " + cod_formula);
    });

    $("#tablaenvase tr").each(function () {
      let valorProductoEnvase = $(this).find("td:eq(0)").attr("id_envase");
      let valorCanEnvase = $(this).find("td:eq(1)").html();
      valoresCapturadosEnvase.push(valorProductoEnvase, valorCanEnvase);
    });

    $("#tablainsumoenvasetotal tr").each(function () {
      let valorProductoTotalEnvase = $(this).find("td:eq(0)").attr("id_item");
      let valorCanTotalEnvase = $(this).find("td:eq(1)").html();
      valoresCapturadosTotalEnvase.push(
        valorProductoTotalEnvase,
        valorCanTotalEnvase
      );
    });

    let accion = "guardarvalorescapturadosinsumos";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        union: valoresCapturados,
        unionEnvase: valoresCapturadosEnvase,
        unionItem: valoresCapturadosTotalEnvase,
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
              $("#selectInsumoEnvase").val("none").trigger("change");
              $("#cantidadInsumoEnvase").val("");
              tablaReqInsumo.empty();
              tablaReqEnv.empty();
              tablatotalInEn.empty();
            }
          });
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
    });
  });
  //-------------------------------------------------------------------------//
});
