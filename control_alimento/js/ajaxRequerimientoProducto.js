$(function () {
  let edit = false;

  //===== Prealoder
  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //-------------------------------------------//

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
    var selectedValue = document.getElementById("selectInsumoEnvase").value;
    if (selectedValue === "none") {
      Swal.fire({
        icon: "error",
        title: "Valor no seleccionado",
        text: "Por favor, seleccione un producto antes de ingresar la cantidad.",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadInsumoEnvase").val("");
        }
      });
      return false;
    }
    const regex = /\d+\./;
    let valorneto = $("#valorneto").val() / 10;
    console.log(valorneto);
    let totalproducto = ($("#cantidadInsumoEnvase").val() * 100) / valorneto;
    $("#txtcantidadproductos").val(Math.round(totalproducto));
  });
  /*-----------Al seleccionar un producto me pongue su peso neto------------------ */
  $("#selectInsumoEnvase").on("change", function () {
    var peso_neto = $(this).find("option:selected").attr("peso_neto");
    $("#valorneto").val(peso_neto);
  });
  /*----------------------------------------------------------------------------- */
  //--------------------- Insertar los valores insumos y envases ------------//

  // $("#botonCalcularInsumoEnvase").click((e) => {
  //   e.preventDefault();

  //   let selectinsumoenvase = $("#selectInsumoEnvase").val();
  //   let textoInsumoEnvase = $("#selectInsumoEnvase option:selected").text();

  //   let cantidadinsumoenvase = $("#cantidadInsumoEnvase").val();

  //   if (!selectinsumoenvase) {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Campo vacío",
  //       text: "Por favor, seleccione un producto.",
  //     });
  //     return;
  //   }
  //   if (!cantidadinsumoenvase) {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Campo vacío",
  //       text: "Por favor, ingrese una cantidad.",
  //     });
  //     return;
  //   }
  //   if (parseFloat(cantidadinsumoenvase) <= 0) {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Campo negativo",
  //       text: "Por favor, ingrese valor positivo en cantidad",
  //     }).then((resultado) => {
  //       if (resultado.isConfirmed || resultado.isDismissed) {
  //         $("#cantidadInsumoEnvase").val("");
  //       }
  //     });
  //     return;
  //   }
  //   if (selectinsumoenvase) {
  //     Swal.fire({
  //       title: "¡Correcto!",
  //       text: "Se añadio los registros.",
  //       icon: "success",
  //       confirmButtonText: "Aceptar",
  //     });
  //   }

  //   /*-------------------- Verifica si hay formulacion ---------------------------- */

  //   const accionverifica = "verificaproductoformulacion";
  //   $.ajax({
  //     url: "./c_almacen.php",
  //     data: {
  //       accion: accionverifica,
  //       selectinsumoenvase: selectinsumoenvase,
  //     },
  //     beforeSend: function () {
  //       $(".preloader").css("opacity", "1");
  //       $(".preloader").css("display", "block");
  //     },
  //     type: "POST",
  //     success: function (dataverificacion) {
  //       // console.log(dataverificacion);
  //       if (dataverificacion == "ok") {
  //         const filaExistente = $(`tr[id="${selectinsumoenvase}"]`);

  //         if (filaExistente.length > 0) {
  //           const celdaCantidadPro = filaExistente.find(
  //             "td[data-titulo='CANTIDAD TOTAL']"
  //           );
  //           const cantidadActual = parseFloat(celdaCantidadPro.text());
  //           const nuevaCantidad =
  //             cantidadActual + parseFloat(cantidadinsumoenvase);

  //           celdaCantidadPro.text(nuevaCantidad);
  //         } else {
  //           let nuevaFila = $("<tr>");
  //           nuevaFila.attr("id", selectinsumoenvase);
  //           let celdaProducto = $("<td data-titulo='PRODUCTO'>").text(
  //             textoInsumoEnvase
  //           );
  //           celdaProducto.attr("id_item", selectinsumoenvase);
  //           let celdaCantidadPro = $("<td data-titulo='CANTIDAD TOTAL'>").text(
  //             cantidadinsumoenvase
  //           );
  //           nuevaFila.append(celdaProducto, celdaCantidadPro);

  //           $("#tablaTotal tbody").append(nuevaFila);
  //         }
  //       } else {
  //         Swal.fire({
  //           icon: "error",
  //           title: "Formulacion no encontrada",
  //           text: "Por favor, seleccione un producto que tengue formulación.",
  //         }).then((resultado) => {
  //           if (resultado.isConfirmed || resultado.isDismissed) {
  //             $("#cantidadInsumoEnvase").val("");
  //           }
  //         });
  //         return;
  //       }
  //     },
  //     complete: function () {
  //       $(".preloader").css("opacity", "0");
  //       $(".preloader").css("display", "none");
  //     },
  //   });
  //   /*_---------------------------------------------------------------------------- */

  //   /*---------------  Añade tabla de total de cada producto-------------------*/

  //   // });

  //   /*-------------------------------------------------------------------------*/

  //   const accion = "mostrardatosinsumos";
  //   $.ajax({
  //     url: "./c_almacen.php",
  //     data: {
  //       accion: accion,
  //       selectinsumoenvase: selectinsumoenvase,
  //       cantidadinsumoenvase: cantidadinsumoenvase,
  //     },
  //     type: "POST",
  //     success: function (responseData) {
  //       if (!responseData.error) {
  //         const insumos = JSON.parse(responseData);
  //         let template = "";

  //         for (let j = 0; j < insumos.length; j++) {
  //           let existingRow = $(`tr[taskId='${insumos[j]["COD_PRODUCTO"]}']`);

  //           if (existingRow.length > 0) {
  //             let capturaTabla1 = existingRow.find("td:eq(1)");

  //             let valor1 = insumos[j]["TOTAL"];
  //             let valorCeldas1 = capturaTabla1[0];

  //             let cambios = parseFloat($(valorCeldas1).html());

  //             let sumar1 = cambios + parseFloat(valor1);

  //             let totalsumar1 = sumar1.toFixed(3);
  //             $(valorCeldas1).html(totalsumar1);

  //             const codigoForm = $("#tinsumo tr:not(:first)");
  //             const capturavalorcantidad = codigoForm.find("td:eq(1)");
  //             let sumatotalinsumos = 0;
  //             for (let n = 0; n < capturavalorcantidad.length; n++) {
  //               const valorceldita = capturavalorcantidad[n];
  //               const cambiofloat = parseFloat($(valorceldita).html());
  //               sumatotalinsumos = sumatotalinsumos + cambiofloat;
  //             }
  //             const tablasuma = $("#tsumatotal tr:not(:first)");
  //             const capturadelvalor = tablasuma.find("td:eq(0)");

  //             if (tablasuma.length > 0) {
  //               const parse = sumatotalinsumos.toFixed(1);
  //               $(capturadelvalor).html(parse);
  //             }
  //             $("#cantidadInsumoEnvase").val("");
  //             $("#selectInsumoEnvase").val("none").trigger("change");
  //           } else {
  //             template = `<tr taskId='${insumos[j]["COD_PRODUCTO"]}'>
  //                               <td data-titulo="INSUMOS">${insumos[j]["DES_PRODUCTO"]}</td>
  //                               <td data-titulo="CANTIDAD">${insumos[j]["TOTAL"]}</td>
  //                            </tr>`;

  //             $("#tablaInsumosDatos").append(template);

  //             const codigoForm = $("#tinsumo tr:not(:first)");
  //             const capturavalorcantidad = codigoForm.find("td:eq(1)");
  //             let sumatotalinsumos = 0;
  //             for (let n = 0; n < capturavalorcantidad.length; n++) {
  //               const valorceldita = capturavalorcantidad[n];
  //               const cambiofloat = parseFloat($(valorceldita).html());
  //               sumatotalinsumos = sumatotalinsumos + cambiofloat;
  //             }
  //             const tablasuma = $("#tsumatotal tr:not(:first)");
  //             const capturadelvalor = tablasuma.find("td:eq(0)");

  //             if (tablasuma.length > 0) {
  //               const parse = sumatotalinsumos.toFixed(1);
  //               $(capturadelvalor).html(parse);
  //             } else {
  //               let nuevaFila = $("<tr>");
  //               let celdasumatotalinsumo = $(
  //                 "<td data-titulo='TOTAL INSUMOS'>"
  //               ).text(sumatotalinsumos.toFixed(1));
  //               nuevaFila.append(celdasumatotalinsumo);

  //               $("#tsumatotal tbody").append(nuevaFila);
  //             }
  //             $("#selectInsumoEnvase").val("none").trigger("change");
  //             $("#cantidadInsumoEnvase").val("");
  //           }
  //         }
  //       }
  //     },
  //     error: function (jqXHR, textStatus, errorThrown) {
  //       console.error("Error in ajaxInsumo AJAX:", textStatus, errorThrown);
  //     },
  //   });

  //   const accionEnvase = "mostrardatosenvases";
  //   $.ajax({
  //     url: "./c_almacen.php",
  //     data: {
  //       accion: accionEnvase,
  //       seleccionadoinsumoenvases: selectinsumoenvase,
  //       cantidadesinsumoenvases: cantidadinsumoenvase,
  //     },
  //     type: "POST",
  //     success: function (response) {
  //       if (!response.error) {
  //         let envases = JSON.parse(response);
  //         console.log(envases);
  //         let templateEnvase = "";

  //         // const existeFila = $(
  //         //   `tr[idenvasecodigo="${envases[0]["COD_FORMULACIONES"]}"]`
  //         // );
  //         // let existeFila;
  //         // for (let c = 0; c < envases.length; c++) {
  //         //   existeFila = $(
  //         //     `tr td[id_envase="${envases[c].COD_PRODUCTO}"]`
  //         //   ).closest("tr");
  //         // }

  //         // const existeFila = $(
  //         //   `tr[idenvase="${envases[0]["COD_FORMULACIONES"]}"]`
  //         // );

  //         // if (existeFila.length > 0) {
  //         //   const capturaTabla = existeFila.find("td:eq(1)");
  //         //   for (let i = 0; i < capturaTabla.length; i++) {
  //         //     const valor = envases[i].TOTAL_ENVASE;
  //         //     const valorCeldas = capturaTabla[i];
  //         //     const cambios = parseFloat($(valorCeldas).html());
  //         //     const sumar = cambios + parseFloat(valor);
  //         //     const totalsumar = sumar.toFixed(3);
  //         //     $(valorCeldas).html(totalsumar);
  //         //     $("#cantidadInsumoEnvase").val("");
  //         //   }
  //         // } else {
  //         // envases.forEach((envase) => {
  //         for (let i = 0; i < envases.length; i++) {
  //           let existeFila = $(`tr[id_envase='${envases[i]["COD_PRODUCTO"]}']`);

  //           if (existeFila.length > 0) {
  //             let capturaTabla = existeFila.find("td:eq(1)");

  //             let valor = envases[i]["TOTAL_ENVASE"];
  //             let valorCeldas = capturaTabla[0];
  //             let cambios = parseFloat($(valorCeldas).html());
  //             let sumar = cambios + parseFloat(valor);
  //             let totalsumar = sumar.toFixed(3);
  //             $(valorCeldas).html(totalsumar);
  //             $("#cantidadInsumoEnvase").val("");
  //           } else {
  //             // templateEnvase += `<tr idenvasecodigo="${envase.COD_PRODUCTO}>
  //             templateEnvase = `<tr id_envase='${envases[i]["COD_PRODUCTO"]}'>
  //                                     <td data-titulo="ENVASES" >${envases[i]["DES_PRODUCTO"]}</td>
  //                                     <td data-titulo="CANTIDAD" >${envases[i]["TOTAL_ENVASE"]}</td>
  //                                   </tr>`;
  //             $("#tablaenvase").append(templateEnvase);
  //           }
  //         }
  //         // });

  //         // }
  //         // const existeFila = $(
  //         //   `#tablaenvase tr td[id_envase="${envases.COD_PRODUCTO}"]`
  //         // ).closest("tr");
  //       }
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error in ajaxEnvase:", error);
  //     },
  //   });
  //   //   });
  //   // }
  // });
  $("#botonCalcularInsumoEnvase").click((e) => {
    e.preventDefault();

    let selectinsumoenvase = $("#selectInsumoEnvase").val();
    let textoInsumoEnvase = $("#selectInsumoEnvase option:selected").text();

    let cantidadinsumoenvase = $("#cantidadInsumoEnvase").val();

    if (!selectinsumoenvase) {
      Swal.fire({
        icon: "error",
        title: "Campo vacío",
        text: "Por favor, seleccione un producto.",
      });
      return;
    }
    if (!cantidadinsumoenvase) {
      Swal.fire({
        icon: "error",
        title: "Campo vacío",
        text: "Por favor, ingrese una cantidad.",
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
    if (selectinsumoenvase) {
      Swal.fire({
        title: "¡Correcto!",
        text: "Se añadio los registros.",
        icon: "success",
        confirmButtonText: "Aceptar",
      });
    }

    /*-------------------- Verifica si hay formulacion ---------------------------- */

    const accionverifica = "verificaproductoformulacion";
    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accionverifica,
        selectinsumoenvase: selectinsumoenvase,
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      type: "POST",
      success: function (dataverificacion) {
        if (dataverificacion == "ok") {
          const filaExistente = $(`tr[id="${selectinsumoenvase}"]`);
          // console.log(filaExistente);
          if (filaExistente.length > 0) {
            const celdaCantidadPro = filaExistente.find(
              "td[data-titulo='CANTIDAD TOTAL']"
            );
            const cantidadActual = parseFloat(celdaCantidadPro.text());
            const nuevaCantidad =
              cantidadActual + parseFloat(cantidadinsumoenvase);

            celdaCantidadPro.text(nuevaCantidad);

            const celdaCanevaces = filaExistente.find(
              "td[data-titulo='cantidadenvace']"
            );
            const cantidadevaceActual = parseFloat(celdaCanevaces.text());
            const nuevaCanenvace =
              cantidadevaceActual +
              parseFloat($("#txtcantidadproductos").val());

            celdaCanevaces.text(nuevaCanenvace);
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
            let cantidaproducto =
              "<td data-titulo='cantidadenvace'>" +
              $("#txtcantidadproductos").val() +
              "</td>";

            nuevaFila.append(celdaProducto, celdaCantidadPro, cantidaproducto);

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
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
    /*_---------------------------------------------------------------------------- */

    /*---------------  Añade tabla de total de cada producto-------------------*/

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
        //console.log(responseData);
        if (!responseData.error) {
          const insumos = JSON.parse(responseData);
          let template = "";

          for (let j = 0; j < insumos.length; j++) {
            let existingRow = $(`tr[taskId='${insumos[j]["COD_PRODUCTO"]}']`);

            if (existingRow.length > 0) {
              let capturaTabla1 = existingRow.find("td:eq(1)");

              let valor1 = insumos[j]["TOTAL"];
              let valorCeldas1 = capturaTabla1[0];

              let cambios = parseFloat($(valorCeldas1).html());

              let sumar1 = cambios + parseFloat(valor1);

              let totalsumar1 = sumar1.toFixed(3);
              $(valorCeldas1).html(totalsumar1);

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
              $("#cantidadInsumoEnvase").val("");
              $("#selectInsumoEnvase").val("none").trigger("change");
            } else {
              template = `<tr taskId='${insumos[j]["COD_PRODUCTO"]}'>
                                <td data-titulo="INSUMOS">${insumos[j]["DES_PRODUCTO"]}</td>
                                <td data-titulo="CANTIDAD">${insumos[j]["TOTAL"]}</td>
                             </tr>`;

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
              $("#selectInsumoEnvase").val("none").trigger("change");
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
        cantidadkg: cantidadinsumoenvase,
        cantidadesinsumoenvases: $("#txtcantidadproductos").val(),
      },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let envases = JSON.parse(response);
          console.log(envases);
          let templateEnvase = "";

          // let cantenvaces = $("#txtcantidadproductos").val();
          for (let i = 0; i < envases.length; i++) {
            let existeFila = $(`tr[id_envase='${envases[i]["COD_PRODUCTO"]}']`);

            if (existeFila.length > 0) {
              let capturaTabla = existeFila.find("td:eq(1)");

              // let valor = cantenvaces;
              let valor = envases[i]["TOTAL_ENVASE"];
              let valorCeldas = capturaTabla[0];
              let cambios = parseFloat($(valorCeldas).html());
              let sumar = cambios + parseFloat(valor);
              let totalsumar = sumar.toFixed(3);
              $(valorCeldas).html(totalsumar);
              $("#cantidadInsumoEnvase").val("");
            } else {
              templateEnvase =
                // `<tr id_envase='${envases[i]["COD_PRODUCTO"]}'>
                //      <td data-titulo="ENVASES" >${envases[i]["DES_PRODUCTO"]}</td>
                //      <td data-titulo="CANTIDAD">` +
                // cantenvaces +
                // `</td>
                // </tr>`;
                `<tr id_envase='${envases[i]["COD_PRODUCTO"]}'>
                                      <td data-titulo="ENVASES" >${envases[i]["DES_PRODUCTO"]}</td>
                                      <td data-titulo="CANTIDAD" >${envases[i]["TOTAL_ENVASE"]}</td>
                </tr>`;
              $("#tablaenvase").append(templateEnvase);
            }
          }
        }
      },
      error: function (xhr, status, error) {
        console.error("Error in ajaxEnvase:", error);
      },
    });
    //   });
    // }
    $("#txtcantidadproductos").val();
  });
  //-------------------------------------------------------------------------//

  //--------------------- Insertar cantidades ------------//
  // $("#botonInsertValor").click((e) => {
  //   e.preventDefault();

  //   let tablaReqInsumo = $("#tablaInsumosDatos");
  //   let tablaReqEnv = $("#tablaenvase");
  //   let tablatotalInEn = $("#tablainsumoenvasetotal");
  //   let codpersonal = $("#codpersonal").val();

  //   if (tablaReqInsumo.find("tr").length === 0) {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Campos vacíos",
  //       text: "Por favor, seleccione un producto y complete la cantidad.",
  //     });
  //     return;
  //   }

  //   let valoresCapturados = [];
  //   let valoresCapturadosEnvase = [];
  //   let valoresCapturadosTotalEnvase = [];

  //   $("#tablaInsumosDatos tr").each(function () {
  //     let taskid = $(this).attr("taskId");
  //     let valorCan = $(this).find("td:eq(1)").html();
  //     valoresCapturados.push(taskid, valorCan);
  //   });

  //   $("#tablaenvase tr").each(function () {
  //     let idenvasecodigo = $(this).attr("id_envase");
  //     let valorCanEnvase = $(this).find("td:eq(1)").html();

  //     valoresCapturadosEnvase.push(idenvasecodigo, valorCanEnvase);
  //   });

  //   $("#tablainsumoenvasetotal tr").each(function () {
  //     let valorProductoTotalEnvase = $(this).find("td:eq(0)").attr("id_item");
  //     let valorCanTotalEnvase = $(this).find("td:eq(1)").html();
  //     valoresCapturadosTotalEnvase.push(
  //       valorProductoTotalEnvase,
  //       valorCanTotalEnvase
  //     );
  //   });

  //   let accion = "guardarvalorescapturadosinsumos";
  //   $.ajax({
  //     type: "POST",
  //     url: "./c_almacen.php",
  //     data: {
  //       accion: accion,
  //       union: valoresCapturados,
  //       unionEnvase: valoresCapturadosEnvase,
  //       unionItem: valoresCapturadosTotalEnvase,
  //       codpersonal: codpersonal,
  //     },
  //     beforeSend: function () {
  //       $(".preloader").css("opacity", "1");
  //       $(".preloader").css("display", "block");
  //     },
  //     success: function (response) {
  //       console.log("respuesta" + response);
  //       if (response == "ok") {
  //         Swal.fire({
  //           title: "¡Guardado exitoso!",
  //           text: "Los datos se han guardado correctamente.",
  //           icon: "success",
  //           confirmButtonText: "Aceptar",
  //         }).then((result) => {
  //           if (result.isConfirmed) {
  //             $("#selectInsumoEnvase").val("none").trigger("change");
  //             $("#cantidadInsumoEnvase").val("");
  //             tablaReqInsumo.empty();
  //             tablaReqEnv.empty();
  //             tablatotalInEn.empty();
  //             $("#tablasumatotalinsumo").empty();
  //           }
  //         });
  //       }
  //     },
  //     error: function (error) {
  //       console.log("ERROR " + error);
  //     },
  //     complete: function () {
  //       $(".preloader").css("opacity", "0");
  //       $(".preloader").css("display", "none");
  //     },
  //   });
  // });
  $("#botonInsertValor").click((e) => {
    e.preventDefault();

    let tablaReqInsumo = $("#tablaInsumosDatos");
    let tablaReqEnv = $("#tablaenvase");
    let tablatotalInEn = $("#tablainsumoenvasetotal");
    let codpersonal = $("#codpersonal").val();

    if (tablaReqInsumo.find("tr").length === 0) {
      Swal.fire({
        icon: "error",
        title: "Campos vacíos",
        text: "Por favor, seleccione un producto y complete la cantidad.",
      });
      return;
    }

    let valoresCapturados = [];
    let valoresCapturadosEnvase = [];
    let valoresCapturadosTotalEnvase = [];

    $("#tablaInsumosDatos tr").each(function () {
      let taskid = $(this).attr("taskId");
      let valorCan = $(this).find("td:eq(1)").html();
      valoresCapturados.push(taskid, valorCan);
    });

    $("#tablaenvase tr").each(function () {
      let idenvasecodigo = $(this).attr("id_envase");
      let valorCanEnvase = $(this).find("td:eq(1)").html();

      valoresCapturadosEnvase.push(idenvasecodigo, valorCanEnvase);
    });

    let tablainsumoevacetotal = $("#tablainsumoenvasetotal tr");
    for (let l = 0; l < tablainsumoevacetotal.length; l++) {
      valoresCapturadosTotalEnvase[l] = [
        $(tablainsumoevacetotal[l]).attr("id"),
        $(tablainsumoevacetotal[l]).find("td")[1].innerHTML,
        $(tablainsumoevacetotal[l]).find("td")[2].innerHTML,
      ];
    }

    let accion = "guardarvalorescapturadosinsumos";
    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        union: valoresCapturados,
        unionEnvase: valoresCapturadosEnvase,
        unionItem: JSON.stringify({ valoresCapturadosTotalEnvase }),
        codpersonal: codpersonal,
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
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
              $("#valorneto").val("");
              tablaReqInsumo.empty();
              tablaReqEnv.empty();
              tablatotalInEn.empty();
              $("#tablasumatotalinsumo").empty();
            }
          });
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  //-------------------------------------------------------------------------//
  /*Carga de loading hasta que de la respuesta*/
  function showLoading() {
    $(".preloader").css("opacity", "1");
    $(".preloader").css("display", "block");
  }

  function hideLoading() {
    $(".preloader").css("opacity", "0");
    $(".preloader").css("display", "none");
  }
  /*---------------------------------------*/
});
