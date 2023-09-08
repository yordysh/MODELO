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
  $("#cantidadInsumoEnvase").keyup((e) => {
    e.preventDefault();
    let cantidadescrita = $("#cantidadInsumoEnvase").val();
    const regex = /\d+\./;

    if (regex.test(cantidadescrita)) {
      Swal.fire({
        icon: "error",
        title: "Valor decimal",
        text: "Por favor, ingresa valores enteros en cantidad",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadInsumoEnvase").val("");
        }
      });
      return;
    }
  });

  //--------------------- Insertar los valores insumos y envases ------------//

  $("#botonCalcularInsumoEnvase").click((e) => {
    e.preventDefault();
    let selectinsumoenvase = $("#selectInsumoEnvase").val();
    let textoInsumoEnvase = $("#selectInsumoEnvase option:selected").text();

    let cantidadinsumoenvase = $("#cantidadInsumoEnvase").val();

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
    /*-------------------- Verifica si hay formulacion ---------------------------- */

    const accionverifica = "verificaproductoformulacion";
    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accionverifica,
        selectinsumoenvase: selectinsumoenvase,
      },
      type: "POST",
      success: function (dataverificacion) {
        // let data = JSON.parse(dataverificacion);

        console.log(dataverificacion);
        if (dataverificacion == "ok") {
          const filaExistente = $(`tr[id="${selectinsumoenvase}"]`);

          if (filaExistente.length > 0) {
            const celdaCantidadPro = filaExistente.find(
              "td[data-titulo='CANTIDAD TOTAL']"
            );
            const cantidadActual = parseFloat(celdaCantidadPro.text());
            const nuevaCantidad =
              cantidadActual + parseFloat(cantidadinsumoenvase);

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
        } else {
          Swal.fire({
            icon: "error",
            title: "Formulacion no encontrada",
            text: "Por favor, seleccione un producto que tengue formulación.",
          }).then((resultado) => {
            if (resultado.isConfirmed || resultado.isDismissed) {
              $("#cantidadInsumoEnvase").val("");
            }
          });
          return;
        }
      },
    });
    /*_---------------------------------------------------------------------------- */

    /*---------------  Añade tabla de total de cada producto-------------------*/

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
          let template = "";
          // const existingRow = $(
          //   `tr[taskId="${insumos[0]["COD_FORMULACION"]}"]`
          // );
          // const existingRow = $(
          //   `tr td[id="${insumos[0].COD_PRODUCTO}"]`
          // ).closest("tr");
          for (let j = 0; j < insumos.length; j++) {
            let existingRow = $(`tr[taskId='${insumos[j]["COD_PRODUCTO"]}']`);

            if (existingRow.length > 0) {
              // const capturaValoresTabla = existingRow.find("td:eq(1)");
              // // console.log(capturaValoresTabla);
              // // for (let cap = 0; cap < capturaValoresTabla.length; cap++) {
              // let valorFormula = insumos[j]["TOTAL"];
              // // console.log(valorFormula);
              // let valorCelda = capturaValoresTabla[0];
              // console.log(valorCelda);
              // let cambio = parseFloat($(valorCelda).html());
              // let suma = cambio + parseFloat(valorFormula);
              // let sumatotalinsumo = suma.toFixed(3);

              // $(valorCelda).html(sumatotalinsumo);
              let capturaTabla1 = existingRow.find("td:eq(1)");

              let valor1 = insumos[j]["TOTAL"];
              let valorCeldas1 = capturaTabla1[0];

              let cambios = parseFloat($(valorCeldas1).html());

              let sumar1 = cambios + parseFloat(valor1);

              let totalsumar1 = sumar1.toFixed(3);
              $(valorCeldas1).html(totalsumar1);

              $("#cantidadInsumoEnvase").val("");

              // }

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
              // insumos.forEach((insumo) => {
              // template += `<tr taskId="${insumo.COD_FORMULACION}">
              //                   <td data-titulo="INSUMOS" id='${insumo.COD_PRODUCTO}'>${insumo.DES_PRODUCTO}</td>
              //                   <td data-titulo="CANTIDAD">${insumo.TOTAL}</td>
              //                </tr>`;
              // });
              template = `<tr taskId='${insumos[j]["COD_PRODUCTO"]}'>
                                <td data-titulo="INSUMOS">${insumos[j]["DES_PRODUCTO"]}</td>
                                <td data-titulo="CANTIDAD">${insumos[j]["TOTAL"]}</td>
                             </tr>`;
              //  $("#tablaInsumosDatos").html(template);
              $("#tablaInsumosDatos").append(template);

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
          console.log(envases);
          let templateEnvase = "";

          // const existeFila = $(
          //   `tr[idenvasecodigo="${envases[0]["COD_FORMULACIONES"]}"]`
          // );
          // let existeFila;
          // for (let c = 0; c < envases.length; c++) {
          //   existeFila = $(
          //     `tr td[id_envase="${envases[c].COD_PRODUCTO}"]`
          //   ).closest("tr");
          // }

          // const existeFila = $(
          //   `tr[idenvase="${envases[0]["COD_FORMULACIONES"]}"]`
          // );

          // if (existeFila.length > 0) {
          //   const capturaTabla = existeFila.find("td:eq(1)");
          //   for (let i = 0; i < capturaTabla.length; i++) {
          //     const valor = envases[i].TOTAL_ENVASE;
          //     const valorCeldas = capturaTabla[i];
          //     const cambios = parseFloat($(valorCeldas).html());
          //     const sumar = cambios + parseFloat(valor);
          //     const totalsumar = sumar.toFixed(3);
          //     $(valorCeldas).html(totalsumar);
          //     $("#cantidadInsumoEnvase").val("");
          //   }
          // } else {
          // envases.forEach((envase) => {
          for (let i = 0; i < envases.length; i++) {
            let existeFila = $(`tr[id_envase='${envases[i]["COD_PRODUCTO"]}']`);

            if (existeFila.length > 0) {
              let capturaTabla = existeFila.find("td:eq(1)");

              let valor = envases[i]["TOTAL_ENVASE"];
              let valorCeldas = capturaTabla[0];
              let cambios = parseFloat($(valorCeldas).html());
              let sumar = cambios + parseFloat(valor);
              let totalsumar = sumar.toFixed(3);
              $(valorCeldas).html(totalsumar);
              $("#cantidadInsumoEnvase").val("");
            } else {
              // templateEnvase += `<tr idenvasecodigo="${envase.COD_PRODUCTO}>
              templateEnvase = `<tr id_envase='${envases[i]["COD_PRODUCTO"]}'>
                                      <td data-titulo="ENVASES" >${envases[i]["DES_PRODUCTO"]}</td>
                                      <td data-titulo="CANTIDAD" >${envases[i]["TOTAL_ENVASE"]}</td>
                                    </tr>`;
              $("#tablaenvase").append(templateEnvase);
            }
          }
          // });

          // }
          // const existeFila = $(
          //   `#tablaenvase tr td[id_envase="${envases.COD_PRODUCTO}"]`
          // ).closest("tr");
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
      // let valorProducto = $(this).find("td:eq(0)").attr("id");
      let taskid = $(this).attr("taskId");
      let valorCan = $(this).find("td:eq(1)").html();
      // let taskid = $(this).attr("taskid");
      // let cod_formula = $(this).attr("taskId");
      valoresCapturados.push(taskid, valorCan);
    });

    $("#tablaenvase tr").each(function () {
      // let valorProductoEnvase = $(this).find("td:eq(0)").attr("id_envase");
      let idenvasecodigo = $(this).attr("id_envase");
      let valorCanEnvase = $(this).find("td:eq(1)").html();
      // let idenvasecodigo = $(this).attr("idenvasecodigo");

      valoresCapturadosEnvase.push(
        // valorProductoEnvase,
        idenvasecodigo,
        valorCanEnvase
        // idenvasecodigo
      );
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
