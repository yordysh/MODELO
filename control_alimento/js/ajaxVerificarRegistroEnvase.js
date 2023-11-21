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
  //----------------------------------------------------------------//

  $("#selectProductoCombo").select2();
  $("#selectNumProduccion").select2();
  $("#selectOperario").select2();
  /*---------- Al seleccionar un combo producto me muestre contenido en combo produccion---- */
  let selectNumProduccion = $("#selectNumProduccion");
  const accion = "seleccionarProductoCombo";
  $("#selectProductoCombo").change(function () {
    let idp = $("#selectProductoCombo").val();
    let idProductoCombo = $(this).find("option:selected").attr("id_reque");

    $.ajax({
      data: {
        idProductoCombo: idProductoCombo,
        idp: idp,
        accion: accion,
      },
      dataType: "html",
      type: "POST",
      url: "./c_almacen.php",
    }).done(function (data) {
      selectNumProduccion.html(data);
    });
  });
  /*-------------------------------------------------------------------------------------- */
  /*--------------Al poner un valor de kilogramos me pone total de enmvases totales */
  $("#cantidad").keyup((e) => {
    e.preventDefault();
    let totalproducto = ($("#cantidad").val() * 100) / 60;
    $("#txtcantidadproductos").val(Math.trunc(totalproducto));
  });
  /*------------------------------------------------------------------------------ */
  /*---------Verficar si el producto seleccionado es menor a productos iguales-------------- */
  $("#selectProductoCombo").on("change", (e) => {
    e.preventDefault();
    let idrequerimiento = $(this).find("option:selected").attr("id_reque");
    let codigoproductoverifica = $("#selectProductoCombo").val();

    let accion = "verificaregistromenorconproducto";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        codigoproductoverifica: codigoproductoverifica,
        idrequerimiento: idrequerimiento,
      },
      success: function (response) {
        if (response == "error") {
          Swal.fire({
            title: "¡Valor incorrecto!",
            text: "Elija el valor minimo de requeriento del producto.",
            icon: "error",
            confirmButtonText: "Aceptar",
          });
          $("#selectNumProduccion").prop("disabled", true);
          $("#cantidad").prop("disabled", true);
        } else {
          $("#selectNumProduccion").prop("disabled", false);
          $("#cantidad").prop("disabled", false);
        }
      },
    });
  });
  /*-------------------------------------------------------------------------------------- */

  $("#botonCalcularregistros").click((e) => {
    e.preventDefault();

    let codigoproducto = $("#selectProductoCombo").val();
    $("#hiddenproducto").val(codigoproducto);
    let codigoproduccion = $("#selectNumProduccion").val();
    $("#hiddenproduccion").val(codigoproduccion);
    let cantidad = $("#cantidad").val();
    $("#hiddencantidad").val(cantidad);
    // let txtcantidadproductos = $("#txtcantidadproductos").val();
    // $("#productocod").val(txtcantidadproductos);

    if (!codigoproducto) {
      Swal.fire({
        icon: "error",
        title: "Seleccione un producto",
        text: "Debe de seleccionar un producto.",
      });
      return;
    }
    if (!codigoproduccion) {
      Swal.fire({
        icon: "error",
        title: "Seleccione una produccion",
        text: "Debe de seleccionar una produccion.",
      });
      return;
    }
    if (cantidad == "") {
      Swal.fire({
        icon: "error",
        title: "Inserte una cantidad",
        text: "Debe de escribir una cantidad.",
      });
      return;
    }

    let accion = "mostrarregistrosporenvases";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        codigoproduccion: codigoproduccion,
        codigoproducto: codigoproducto,
        cantidad: $("#txtcantidadproductos").val(),
      },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          if (tasks["tipo"] == 0) {
            Swal.fire({
              icon: "success",
              title: "Calculo de registro",
              text: "Se añadio correctamente el registro.",
            });

            let template = ``;
            tasks["respuesta"].forEach((task) => {
              template += `<tr taskId="${task.COD_FORMULACION}">

                          <td data-titulo="MATERIALES" taskcodigoproducto=${task.COD_PRODUCTO}>${task.DES_PRODUCTO}</td>
                          <td data-titulo="CANTIDAD" >${task.CANTIDAD_TOTAL}</td>
                          <td data-titulo="LOTE" ><input type='text'/></td>

                </tr>`;
            });

            $("#tablacalculoregistroenvase").html(template);
            // $("#selectProductoCombo").val("none").trigger("change");
            $("#selectNumProduccion").val("none").trigger("change");
            $("#cantidad").val("");
            // $("#txtcantidadproductos").val("");
          } else {
            console.log(tasks);
            Swal.fire({
              title: "¡Supero cantidad!",
              text: "Cantidad supero lo que hay en producción.",
              html: `<p>La cantidad minima de  ${tasks["respuesta"].COD_PRODUCCION} ${tasks["respuesta"].DES_PRODUCTO} es ${tasks["respuesta"].CANTIDAD_PRODUCIDA} KG y TOTAL PRODUCTO es ${tasks["respuesta"].VALOR_KG} </p>`,
              icon: "error",
              confirmButtonText: "Aceptar",
            }).then((result) => {
              if (result.isConfirmed) {
                $("#cantidad").val("");
                // $("#selectProductoCombo").val("none").trigger("change");
                $("#selectNumProduccion").val("none").trigger("change");
                $("#tablacalculoregistroenvase").empty();
              }
            });
            $("#tablacalculoregistroenvase").empty();
          }
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
    });

    let accioninsumos = "mostrarinsumostotales";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accioninsumos,
        codigoproduccion: codigoproduccion,
        codigoproducto: codigoproducto,
        cantidad: $("#txtcantidadproductos").val(),
        cantidadinsumo: cantidad,
      },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          if (tasks["tipo"] == 0) {
            Swal.fire({
              icon: "success",
              title: "Calculo de registro",
              text: "Se añadio correctamente el registro.",
            });

            let template = ``;
            tasks["respuesta"].forEach((task) => {
              template += `<tr taskId="${task.COD_FORMULACION}">

                          <td data-titulo="MATERIALES" insumocodigoproducto=${task.COD_PRODUCTO}>${task.DES_PRODUCTO}</td>
                          <td data-titulo="CANTIDAD" >${task.CANTIDAD_TOTAL}</td>
                          <td data-titulo="LOTE" ><input type='text'/></td>

                </tr>`;
            });

            $("#tablainsumosavancetotal").html(template);
            // $("#selectProductoCombo").val("none").trigger("change");
            $("#selectNumProduccion").val("none").trigger("change");
            $("#cantidad").val("");
          } else {
            console.log(tasks);
            // Swal.fire({
            //   title: "¡Supero cantidad!",
            //   text: "Cantidad supero lo que hay en producción.",
            //   html: `<p>La cantidad minima de ${tasks["respuesta"].COD_PRODUCCION} ${tasks["respuesta"].DES_PRODUCTO} es ${tasks["respuesta"].CANTIDAD_PRODUCIDA}</p>`,
            //   icon: "error",
            //   confirmButtonText: "Aceptar",
            // }).then((result) => {
            //   if (result.isConfirmed) {
            //     $("#cantidad").val("");
            //     $("#selectProductoCombo").val("none").trigger("change");
            //     $("#selectNumProduccion").val("none").trigger("change");
            //     $("#tablacalculoregistroenvase").empty();
            //   }
            // });
            // $("#tablacalculoregistroenvase").empty();
          }
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
    });
  });

  $("#botonguardarregistro").click((e) => {
    e.preventDefault();
    let productocombo = $("#selectProductoCombo").val();
    let codigoproducto = $("#hiddenproducto").val();
    // let produccioncombo = $("#selectNumProduccion").val();
    let codigoproduccion = $("#hiddenproduccion").val();
    let cantidad = $("#hiddencantidad").val();
    let cantidadtotalenvases = $("#txtcantidadproductos").val();
    let codpersonal = $("#codpersonal").val();
    let codoperario = $("#selectOperario").val();

    let valoresCapturadosProduccion = [];
    let valoresCapturadosProduccioninsumo = [];

    if (!productocombo) {
      Swal.fire({
        icon: "error",
        title: "Seleccione un producto",
        text: "Debe de seleccionar un producto.",
      });
      return;
    }
    if (!codigoproduccion) {
      Swal.fire({
        icon: "error",
        title: "Seleccione una produccion",
        text: "Debe de seleccionar una produccion.",
      });
      return;
    }
    if (cantidad == "") {
      Swal.fire({
        icon: "error",
        title: "Inserte una cantidad",
        text: "Debe de escribir una cantidad.",
      });
      return;
    }
    if (!codoperario) {
      Swal.fire({
        icon: "error",
        title: "Seleccione un operario",
        text: "Debe de seleccionar un operario.",
      });
      return;
    }

    $("#tablacalculoregistroenvase tr").each(function () {
      let valorProducto = $(this).find("td:eq(0)").attr("taskcodigoproducto");
      let valorCan = $(this).find("td:eq(1)").text();
      let valorLote = $(this).find("td:eq(2) input").val();

      valoresCapturadosProduccion.push(valorProducto, valorCan, valorLote);
    });
    $("#tablainsumosavancetotal tr").each(function () {
      let valorProductoinsumo = $(this)
        .find("td:eq(0)")
        .attr("insumocodigoproducto");
      let valorCaninsumo = $(this).find("td:eq(1)").text();
      let valorLoteinsumo = $(this).find("td:eq(2) input").val();

      valoresCapturadosProduccioninsumo.push(
        valorProductoinsumo,
        valorCaninsumo,
        valorLoteinsumo
      );
    });

    let accion = "guardarvalordeinsumosporregistro";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        valoresCapturadosProduccion: valoresCapturadosProduccion,
        valoresCapturadosProduccioninsumo: valoresCapturadosProduccioninsumo,
        codigoproducto: codigoproducto,
        codigoproduccion: codigoproduccion,
        cantidad: cantidad,
        cantidadtotalenvases: cantidadtotalenvases,
        codpersonal: codpersonal,
        codoperario: codoperario,
      },
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
            allowOutsideClick: false,
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#selectProductoCombo").val("none").trigger("change");
              $("#selectNumProduccion").val("none").trigger("change");
              $("#hiddenproducto").val("");
              $("#hiddenproduccion").val("");
              $("#cantidad").val("");
              $("#tablacalculoregistroenvase").empty();
              $("#tablainsumosavancetotal").empty();
              $("#selectOperario").val("none").trigger("change");
              actualizarCombo();
            }
          });
        } else {
          alert("errr");
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
  function actualizarCombo() {
    const accion = "actualizarcomboproduccionproducto";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion },
      type: "POST",
      success: function (response) {
        // console.log(JSON.parse(response));
        let data = JSON.parse(response);
        $("#selectProductoCombo").empty();
        $("#selectProductoCombo").append(
          $("<option>", {
            value: "none",
            text: "Seleccione producto",
            disabled: true,
            selected: true,
          })
        );
        data.forEach((item) => {
          const $option = $("<option>", {
            value: item.COD_PRODUCTO,
            text:
              item.COD_REQUERIMIENTO +
              " " +
              item.ABR_PRODUCTO +
              " " +
              item.DES_PRODUCTO,
          })
            .attr("id_reque", item.COD_REQUERIMIENTO)
            .addClass("option");

          $("#selectProductoCombo").append($option);
        });
      },
      error: function (error) {
        console.error("Error fetching data:", error);
      },
    });
  }

  /*---------------- actualizar control maquinas el pdf ------------------------ */
  // $("#guardarcontrolmaquinapdf").click((e) => {
  //   e.preventDefault();
  //   let alertobs = false;
  //   let alertacc = false;
  //   let alertvb = false;
  //   let alertestado = false;

  //   $("#tablaControlModal tr").each(function () {
  //     let frecuenciavalor = $(this)
  //       .find("td:eq(1)")
  //       .find("input[type='checkbox']")
  //       .prop("checked");
  //     let observacion = $(this).find("td:eq(2)").find(".observacion").val();
  //     let accioncorrectiva = $(this)
  //       .find("td:eq(3)")
  //       .find(".acccioncorrectiva")
  //       .val();
  //     let vb = $(this).find("td:eq(4)").find(".selectVerif").val();
  //     let estado = $(this).find("td:eq(5)").find(".selectEstado").val();

  //     if (!frecuenciavalor && observacion == "") {
  //       alertobs = true;
  //       return false;
  //     }
  //     if (!frecuenciavalor && accioncorrectiva == "") {
  //       alertacc = true;
  //       return false;
  //     }
  //     if (!frecuenciavalor && vb != "1" && vb != "2") {
  //       alertvb = true;
  //       return false;
  //     }
  //     if (
  //       frecuenciavalor &&
  //       estado != "R" &&
  //       estado != "PO" &&
  //       estado != "OB"
  //     ) {
  //       alertestado = true;
  //       return false;
  //     }
  //   });
  //   if (alertobs) {
  //     Swal.fire({
  //       icon: "info",
  //       title: "Observación vacia",
  //       text: "Debe de escribir una observación.",
  //     });
  //     return;
  //   }
  //   if (alertacc) {
  //     Swal.fire({
  //       icon: "info",
  //       title: "Accion correctiva vacia",
  //       text: "Debe de escribir una acción correctiva.",
  //     });
  //     return;
  //   }
  //   if (alertvb) {
  //     Swal.fire({
  //       icon: "info",
  //       title: "V°B vacio",
  //       text: "Seleccione una opcion de V°B°.",
  //     });
  //     return;
  //   }
  //   if (alertestado) {
  //     Swal.fire({
  //       icon: "info",
  //       title: "Proceso vacio",
  //       text: "Seleccione una opcion del proceso.",
  //     });
  //     return;
  //   }

  //   let valorcapturadocontrol = [];
  //   $("#tablaControlModal tr").each(function () {
  //     let codigoalertacontrol = $(this).attr("idcontrol");
  //     let codcontrol = $(this).find("td:eq(0)").attr("idcontrolmaquina");

  //     let frecuenciavalor = $(this)
  //       .find("td:eq(1)")
  //       .find("input[type='checkbox']")
  //       .prop("checked");

  //     let observacion = $(this).find("td:eq(2)").find(".observacion").val();
  //     let accioncorrectiva = $(this)
  //       .find("td:eq(3)")
  //       .find(".acccioncorrectiva")
  //       .val();
  //     let vb = $(this).find("td:eq(4)").find(".selectVerif").val();
  //     let estado = $(this).find("td:eq(5)").find(".selectEstado").val();

  //     valorcapturadocontrol.push({
  //       codigoalertacontrol: codigoalertacontrol,
  //       codcontrol: codcontrol,
  //       frecuenciavalor: frecuenciavalor,
  //       observacion: observacion,
  //       accioncorrectiva: accioncorrectiva,
  //       vb: vb,
  //       estado: estado,
  //     });
  //   });
  //   console.log(valorcapturadocontrol);
  //   let accioncontrol = "actualizardatoscontrolpdf";
  //   $.ajax({
  //     type: "POST",
  //     url: "./c_almacen.php",
  //     data: {
  //       accion: accioncontrol,
  //       valorcapturadocontrol: valorcapturadocontrol,
  //     },
  //     beforeSend: function () {
  //       $(".preloader").css("opacity", "1");
  //       $(".preloader").css("display", "block");
  //     },
  //     success: function (response) {
  //       if (response == "ok") {
  //         Swal.fire({
  //           title: "¡Guardado exitoso!",
  //           text: "Los datos se han guardado correctamente.",
  //           icon: "success",
  //           allowOutsideClick: false,
  //           confirmButtonText: "Aceptar",
  //         }).then((result) => {
  //           if (result.isConfirmed) {
  //             $("#tablaControlModal tr").each(function () {
  //               let checkboxdesactiva = $(this).find("#frecuenciamarca");
  //               checkboxdesactiva.prop("checked", false);
  //             });
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
  /*--------------------------------------------------------------------------- */

  /*---------------- Darle click en switch y me añada textarea----------------- */

  // $(".inputcheck").change(function () {
  //   var fila = $(this).closest("tr");

  //   if ($(this).is(":checked")) {
  //     var columnaobservacion = $(
  //       `<td><textarea class="form-control observacion" id="observacion" rows="2" style="margin:5px 80px"></textarea></td>`
  //     );
  //     var columnaaccioncorrectiva = $(
  //       `<td><textarea class="form-control acccioncorrectiva" id="acccioncorrectiva" rows="2" style="margin:5px 80px"></textarea></td>`
  //     );
  //     var vb = $(
  //       `<td>    <select id="selectVB" class="form-select selectVerif" style="margin:5px 80px" >
  //                       <option value="none" selected>Seleccione V°B°</option>
  //                       <option value="1">J.A.C</option>
  //                        <option value="2">A.A.C</option>
  //               </select>
  //       </td>`
  //     );
  //     var estado = $(
  //       `<td>    <select id="selectEstado" class="form-select selectEstado" style="margin:5px 80px" >
  //                       <option selected>Seleccione proceso</option>
  //                       <option value="R">Realizado</option>
  //                       <option value="PO">Pendiente</option>
  //                        <option value="OB">Observado</option>
  //               </select>
  //       </td>`
  //     );

  //     /*----------------------------Al darle click en opcion realizado ------------*/
  //     estado.find("select").change(function () {
  //       var selectedValue = $(this).val();
  //       if (selectedValue === "R") {
  //         columnaobservacion.find("textarea").prop("disabled", true).val("");
  //         columnaaccioncorrectiva
  //           .find("textarea")
  //           .prop("disabled", true)
  //           .val("");
  //         vb.find("select")
  //           .prop("disabled", true)
  //           .val("none")
  //           .trigger("change");
  //       } else {
  //         columnaobservacion.find("textarea").prop("disabled", false);
  //         columnaaccioncorrectiva.find("textarea").prop("disabled", false);
  //         vb.find("select").prop("disabled", false);
  //       }
  //     });
  //     /*------------------------------------------------------------------------- */

  //     fila.append(columnaobservacion, columnaaccioncorrectiva, vb, estado);
  //   } else {
  //     fila.find(".observacion").parent().remove();
  //     fila.find(".acccioncorrectiva").parent().remove();
  //     fila.find(".selectVerif").parent().remove();
  //     fila.find(".selectEstado").parent().remove();
  //   }
  // });
  /*-------------------------------------------------------------------------- */
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
