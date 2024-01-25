$(function () {
  mostrarProductoEnvase();

  let edit = false;

  //===== Prealoder
  // $(".preloader").fadeOut("slow");
  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }

  //----------------------------------------------------------------//

  $("#selectProductoCombo").select2();
  $("#selectInsumosCombo").select2();
  $("#selectEnvasesProductoCombo").select2();

  //------------- Busqueda con ajax registro envases----------------//

  $("#search").keyup(() => {
    // if ($("#search").val()) {
    var search = $("#search").val();
    const accion = "buscarenvaseproducto";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, buscarregistro: search },
      type: "POST",
      success: function (response) {
        let tasks = JSON.parse(response);

        // if (tasks.length === 0) {
        //   let template = `<tr>
        //           <td colspan="2" style="text-align: center;">No data available</td>
        //       </tr>`;
        //   $("#tablaProductoEnvases").html(template);
        // } else {
        let template = ``;
        tasks.forEach((task) => {
          template += `<tr taskId="" cod_formula='${task.COD_FORMULACION}'>
                        <td data-titulo="CODIGO" cod_producto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                        <td data-titulo="CANTIDAD PRODUCTO">${task.CAN_FORMULACION}</td>
                        <td data-titulo="VER"><button class="custom-icon" ><i id='observarformula' class='icon-eye'></i></button></td>
                    </tr>`;
        });
        $("#tablaProductoEnvases").html(template);
        // }
      },
    });
    // } else {
    //   fetchTasks();
    // }
  });

  $("#cantidadTotal").keyup((e) => {
    e.preventDefault();
    let cantidadescrita = $("#cantidadTotal").val();
    const regex = /\d+\./;

    if (regex.test(cantidadescrita)) {
      Swal.fire({
        icon: "error",
        title: "Valor decimal",
        text: "Por favor, ingresa valores enteros en cantidad producto",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadTotal").val("");
        }
      });
      return;
    }
  });

  $("#cantidadEnvaseProducto").keyup((e) => {
    e.preventDefault();
    let cantidadescrita = $("#cantidadEnvaseProducto").val();
    const regex = /\d+\./;

    if (regex.test(cantidadescrita)) {
      Swal.fire({
        icon: "error",
        title: "Valor decimal",
        text: "Por favor, ingresa valores enteros en cantidad envases",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadEnvaseProducto").val("");
        }
      });
      return;
    }
  });
  /*----------Guarda la formula completa con insumos y envases------ */
  $("#botonCalcularProductosEnvases").click((e) => {
    e.preventDefault();
    let tablaEnvase = $("#tablaEnvasesCadaProducto");
    let tablaInsumo = $("#tablaInsumos");
    let codigopersonal = $("#codpersonal").val();

    let productoSeleccionado = $("#selectProductoCombo").val();
    let cantidadTotal = $("#cantidadTotal").val();

    // Validar si los campos están vacíos
    if (!productoSeleccionado || !cantidadTotal) {
      Swal.fire({
        icon: "error",
        title: "Campos vacíos",
        text: "Por favor, seleccione un producto y complete la cantidad total.",
      });
      return;
    }

    if (parseFloat(cantidadTotal) <= 0) {
      Swal.fire({
        icon: "error",
        title: "Valores negativos",
        text: "Por favor, ingresa solo valores positivos en Cantidad producto",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadTotal").val("");
        }
      });
      return;
    }

    let tbInsumos = $("#tablaInsumos tr");
    let dataInsumo = [];

    $("#tablaInsumos tr").each(function () {
      let codigoproductoinsumo = $(this).find("td:eq(0)").attr("cod_producto");
      let nombreproductoinsumo = $(this).find("td:eq(0)").text();
      let cantidadinsumo = $(this).find("td:eq(1) input").val();
      dataInsumo.push({
        codigoproductoinsumo: codigoproductoinsumo,
        nombreproductoinsumo: nombreproductoinsumo,
        cantidadinsumo: cantidadinsumo,
      });
    });

    // for (let i = 0; i < tbInsumos.length; i++) {
    //   let row = tbInsumos[i];
    //   let columns = $(row).find("td");
    //   let insumo = $(columns[0]).text();
    //   let cantidad = $(columns[2]).text();

    //   dataInsumo.push({ insumo, cantidad });
    // }

    // let tbEnvases = $("#tablaEnvasesCadaProducto tr");
    let dataEnvase = [];
    $("#tablaEnvasesCadaProducto tr").each(function () {
      let codigoproductoenvase = $(this)
        .find("td:eq(0)")
        .attr("cod_producto_envase");

      let cantidadenvase = $(this).find("td:eq(1) input").val();
      dataEnvase.push({
        codigoproductoenvase: codigoproductoenvase,
        cantidadenvase: cantidadenvase,
      });
    });
    // for (let i = 0; i < tbEnvases.length; i++) {
    //   let rowenvase = tbEnvases[i];
    //   let columns = $(rowenvase).find("td");
    //   let envase = $(columns[0]).text();
    //   let cantidadEnvase = $(columns[2]).text();

    //   dataEnvase.push({ envase, cantidadEnvase });
    // }
    if (dataInsumo.length === 0 || dataEnvase.length === 0) {
      Swal.fire({
        icon: "error",
        title: "Campos vacíos",
        text: "Por favor, inserte insumos y envases.",
      });
      return;
    }

    const accion = "insertarProductoEnvase";
    $.ajax({
      url: "./c_almacen.php",
      dataType: "text",
      data: {
        accion: accion,
        codigopersonal: codigopersonal,
        selectProductoCombo: productoSeleccionado,
        cantidadTotal: cantidadTotal,
        dataInsumo: dataInsumo,
        dataEnvase: dataEnvase,
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      type: "POST",
      success: function (respuestas) {
        let respuesta = JSON.parse(respuestas);
        if (respuesta.estado === "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              mostrarProductoEnvase();
              $("#selectProductoCombo").val("none").trigger("change");
              $("#selectProductoCombo").prop("disabled", false);
              $("#cantidadTotal").prop("disabled", false);
              tablaInsumo.empty();
              tablaEnvase.empty();

              $("#cantidadTotal").val("");
            }
          });
        } else if (respuesta.estado === "error") {
          Swal.fire({
            icon: "error",
            title: "Error de codigo",
            text: "Error al insertar.",
          }).then((resultado) => {
            if (resultado.isConfirmed || resultado.isDismissed) {
              $("#selectProductoCombo").val("none").trigger("change");

              tablaInsumo.empty();
              tablaEnvase.empty();

              $("#cantidadTotal").val("");
            }
          });
        } else if (respuesta.estado === "cantidaddiferente") {
          Swal.fire({
            icon: "error",
            title: "La cantidad es diferente a la formulación del producto.",
            // text: "Error al insertar.",
          }).then((resultado) => {
            if (resultado.isConfirmed || resultado.isDismissed) {
              $("#selectProductoCombo").val("none").trigger("change");
              $("#selectProductoCombo").prop("disabled", false);
              $("#cantidadTotal").prop("disabled", false);
              tablaInsumo.empty();
              tablaEnvase.empty();

              $("#cantidadTotal").val("");
            }
          });
        } else if (respuesta.estado === "nuevaformula") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos de la nueva formulación se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              mostrarProductoEnvase();
              $("#selectProductoCombo").val("none").trigger("change");
              $("#selectProductoCombo").prop("disabled", false);
              $("#cantidadTotal").prop("disabled", false);

              tablaInsumo.empty();
              tablaEnvase.empty();

              $("#cantidadTotal").val("");
            }
          });
        } else if (respuesta.estado === "sumainsumodiferente") {
          Swal.fire({
            icon: "error",
            title:
              "La suma de los insumos es diferente a la cantidad de la formulación.",
            // text: "Error al insertar.",
          }).then((resultado) => {
            if (resultado.isConfirmed || resultado.isDismissed) {
              $("#selectProductoCombo").val("none").trigger("change");
              $("#selectProductoCombo").prop("disabled", false);
              $("#cantidadTotal").prop("disabled", false);
              tablaInsumo.empty();
              tablaEnvase.empty();

              $("#cantidadTotal").val("");
            }
          });
        }
        // if (response === "ok") {
        //   Swal.fire({
        //     title: "¡Guardado exitoso!",
        //     text: "Los datos se han guardado correctamente.",
        //     icon: "success",
        //     confirmButtonText: "Aceptar",
        //   }).then((result) => {
        //     if (result.isConfirmed) {
        //       mostrarProductoEnvase();
        //       $("#selectProductoCombo").val("none").trigger("change");

        //       tablaInsumo.empty();
        //       tablaEnvase.empty();

        //       $("#cantidadTotal").val("");
        //     }
        //   });
        // } else {
        //   Swal.fire({
        //     icon: "error",
        //     title: "Formulacion producto",
        //     text: "Por favor, elige otro producto.",
        //   }).then((resultado) => {
        //     if (resultado.isConfirmed || resultado.isDismissed) {
        //       $("#selectProductoCombo").val("none").trigger("change");

        //       tablaInsumo.empty();
        //       tablaEnvase.empty();

        //       $("#cantidadTotal").val("");
        //     }
        //   });
        // }
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  /*-------------------------------------------------------------- */
  $("#botonCalcularInsumos").click((e) => {
    e.preventDefault();
    let selectInsumosCombo = $("#selectInsumosCombo").val();
    let cantidadInsumos = $("#cantidadInsumos").val();

    if (!selectInsumosCombo || !cantidadInsumos) {
      Swal.fire({
        icon: "error",
        title: "Campos vacíos",
        text: "Por favor, seleccione un insumo  y complete la cantidad insumos.",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#selectInsumosCombo").append(
            $("<option>", {
              value: "none",
              text: "Seleccione insumo",
              disabled: true,
              selected: true,
            })
          );
          $("#cantidadInsumos").val("");
        }
      });
      return;
    }

    if (parseFloat(cantidadInsumos) <= 0) {
      Swal.fire({
        icon: "error",
        title: "Valores negativos",
        text: "Por favor, ingresa solo valores positivos en Cantidad insumos",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadInsumos").val("");
        }
      });
      return;
    }

    let selectInsumosTexto = $("#selectInsumosCombo option:selected").text();

    if (
      $("#tablaInsumos td[data-titulo='Insumos']").filter(function () {
        return $(this).text() === selectInsumosCombo;
      }).length > 0
    ) {
      Swal.fire({
        icon: "error",
        title: "Insumo duplicado",
        text: "Por favor, elige otro insumo.",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#selectInsumosCombo").val("none").trigger("change");
          $("#cantidadInsumos").val("");
        }
      });
    } else {
      Swal.fire({
        icon: "success",
        title: "Correcto",
        text: "Se añadio los registros.",
      });

      let newRow = `<tr>
                     <!-- <td data-titulo='Insumos' style='display:none;'>${selectInsumosCombo}</td> -->
                      <td data-titulo='Insumo'cod_producto='${selectInsumosCombo}'>${selectInsumosTexto}</td>
                      <td data-titulo='Cantidad'><input value='${cantidadInsumos}' /></td>
                      
                    </tr>`;
      $("#tablaInsumos").prepend(newRow);
      $("#selectInsumosCombo").val("none").trigger("change");
      $("#cantidadInsumos").val("");
    }
  });

  $("#botonCalcularEnvasesProducto").click((e) => {
    e.preventDefault();

    let selectEnvasesProductoCombo = $("#selectEnvasesProductoCombo").val();
    let cantidadEnvaseProducto = $("#cantidadEnvaseProducto").val();

    if (!selectEnvasesProductoCombo || !cantidadEnvaseProducto) {
      Swal.fire({
        icon: "error",
        title: "Campos vacíos",
        text: "Por favor, seleccione un envase  y complete la cantidad envases.",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#selectEnvasesProductoCombo").val("none").trigger("change");
          $("#cantidadEnvaseProducto").val("");
        }
      });
      return;
    }

    if (parseFloat(cantidadEnvaseProducto) <= 0) {
      Swal.fire({
        icon: "error",
        title: "Valores negativos",
        text: "Por favor, ingresa solo valores positivos en Cantidad envases",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#cantidadEnvaseProducto").val("");
        }
      });
      return;
    }

    let selectEnvasesTexto = $(
      "#selectEnvasesProductoCombo option:selected"
    ).text();

    if (
      $(
        "#tablaEnvasesCadaProducto tr:last-child td[data-titulo='Envases']"
      ).filter(function () {
        return $(this).text() === selectEnvasesProductoCombo;
      }).length > 0
    ) {
      Swal.fire({
        icon: "error",
        title: "Envase duplicado",
        text: "Por favor, elige otro envase.",
      }).then((resultado) => {
        if (resultado.isConfirmed || resultado.isDismissed) {
          $("#selectEnvasesProductoCombo").append(
            $("<option>", {
              value: "none",
              text: "Seleccione envases",
              disabled: true,
              selected: true,
            })
          );
          $("#cantidadEnvaseProducto").val("");
        }
      });
    } else {
      Swal.fire({
        icon: "success",
        title: "Correcto",
        text: "Se añadio los registros.",
      });
      let newRow = `<tr>
                   <!-- <td  data-titulo='Envases' style='display:none;'>${selectEnvasesProductoCombo}</td> -->
                    <td  data-titulo='Envase' cod_producto_envase='${selectEnvasesProductoCombo}'>${selectEnvasesTexto}</td>
                    <td  data-titulo='Cantidad'><input value='${cantidadEnvaseProducto}' /></td>
                  </tr>`;
      $("#tablaEnvasesCadaProducto").prepend(newRow);
      $("#selectEnvasesProductoCombo").val("none").trigger("change");
      $("#cantidadEnvaseProducto").val("");
    }
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //

  function mostrarProductoEnvase() {
    var search = "";
    const accion = "buscarenvaseproducto";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        buscarregistro: search,
      },
      success: function (response) {
        let tasks = JSON.parse(response);

        if (tasks.length === 0) {
          let template = `<tr>
                  <td colspan="2" style="text-align: center;">No data available</td>
              </tr>`;
          $("#tablaProductoEnvases").html(template);
        } else {
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="" cod_formula='${task.COD_FORMULACION}'>
                      <td data-titulo="CODIGO" cod_producto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                      <td data-titulo="CANTIDAD PRODUCTO">${task.CAN_FORMULACION}</td>
                      <td data-titulo="VER"><button class="custom-icon" ><i id='observarformula' class='icon-eye'></i></button></td>
                  </tr>`;
          });
          $("#tablaProductoEnvases").html(template);
        }
      },
    });
  }
  //---------------------------------------------------------------------------------//
  /*------------------------- Mostrar insumos y envases de la formulacion---------- */
  $(document).on("click", "#observarformula", function (e) {
    e.preventDefault();
    let fila = $(this).closest("tr");
    let codigoformulacion = fila.attr("cod_formula");
    let codigoproducto = fila.find("td:eq(0)").attr("cod_producto");
    const accionformula = "codigoformulavalor";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accionformula,
        codigoformulacion: codigoformulacion,
        codigoproducto: codigoproducto,
      },
      success: function (responsecabecera) {
        if (isJSON(responsecabecera)) {
          let formula = JSON.parse(responsecabecera);
          $("#selectProductoCombo").prop("disabled", true);
          $("#selectProductoCombo").append(
            new Option(
              formula[0].DES_PRODUCTO,
              formula[0].COD_PRODUCTO,
              true,
              true
            )
          );
          $("#cantidadTotal").val(formula[0].CAN_FORMULACION);
          $("#cantidadTotal").prop("disabled", true);
        }
      },
    });
    const accion = "mostrarlosvaloresinsumosformula";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        codigoformulacion: codigoformulacion,
        codigoproducto: codigoproducto,
      },
      success: function (response) {
        if (isJSON(response)) {
          Swal.fire({
            title: "¡Se añadio los valores!",
            text: "Los datos se han añadido a sus respectivas tablas.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              let tasks = JSON.parse(response);

              let template = ``;
              tasks.forEach((task) => {
                template += `<tr taskId="" cod_formula='${
                  task.COD_FORMULACION
                }'>
                          <td data-titulo="CODIGO" cod_producto='${
                            task.COD_PRODUCTO
                          }'>${task.DES_PRODUCTO}</td>
                          <td data-titulo="CANTIDAD PRODUCTO"><input value='${parseFloat(
                            task.CAN_FORMULACION
                          ).toFixed(3)}' /></td>
                          <td><button class='btn btn-danger' id='btneliminarfilainsumo'><i class='icon-trash'></i></button></td>
                      </tr>`;
              });
              $("#tablaInsumos").html(template);
            }
          });
        }
      },
    });

    const accionenvase = "mostrarlosvaloresenvaseformula";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accionenvase,
        codigoformulacionenvase: codigoformulacion,
        codigoproductoenvase: codigoproducto,
      },
      success: function (responseenvase) {
        if (isJSON(responseenvase)) {
          let tasksenvase = JSON.parse(responseenvase);

          let templateenvase = ``;
          tasksenvase.forEach((taskenvase) => {
            templateenvase += `<tr taskId="" cod_formula='${taskenvase.COD_FORMULACION_ENVASE}'>
                          <td data-titulo="ENVASES" cod_producto_envase='${taskenvase.COD_PRODUCTO_ENVASE}'>${taskenvase.DES_PRODUCTO_ENVASE}</td>
                          <td data-titulo="CANTIDAD"><input value='${taskenvase.CAN_FORMULACION_ENVASE}' /></td>
                          <td><button class='btn btn-danger' id='btneliminarfilaenvase'><i class='icon-trash'></i></button></td>
                      </tr>`;
          });
          $("#tablaEnvasesCadaProducto").html(templateenvase);
        }
      },
    });
  });
  /*------------------------------------------------------------------------------ */

  /*--------------Eliminar fila de insumo--------------------- */
  $("#tablaInsumos").on("click", "#btneliminarfilainsumo", function () {
    // Find the closest 'tr' element and remove it
    $(this).closest("tr").remove();
  });
  $("#tablaEnvasesCadaProducto").on(
    "click",
    "#btneliminarfilaenvase",
    function () {
      // Find the closest 'tr' element and remove it
      $(this).closest("tr").remove();
    }
  );
  /*--------------------------------------------------------- */

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
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
