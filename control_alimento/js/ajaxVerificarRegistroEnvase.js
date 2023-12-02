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
        cantidadenvase: $("#txtcantidadproductos").val(),
        cantidadinsumo: cantidad,
      },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          if (tasks["tipoe"] == 0) {
            let template = ``;
            tasks["respuestae"].forEach((task) => {
              let lotes = task.LOTES;
              template += `<tr taskId="${task.COD_FORMULACION}">

                          <td data-titulo="MATERIALES" taskcodigoproducto=${
                            task.COD_PRODUCTO
                          }>${task.DES_PRODUCTO}</td>
                          <td data-titulo="CANTIDAD" >${
                            task.CANTIDAD_TOTAL
                          }</td>
                          <td data-titulo="LOTE" ><input type='text' readonly value="${lote(
                            lotes
                          )}"/></td>

                </tr>`;
            });

            $("#tablacalculoregistroenvase").html(template);
            // $("#selectProductoCombo").val("none").trigger("change");
            $("#selectNumProduccion").val("none").trigger("change");
            $("#cantidad").val("");
            // $("#txtcantidadproductos").val("");
          } else {
            console.log("error");
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
        cantidadenvase: $("#txtcantidadproductos").val(),
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
              let lotes = task.LOTES;
              template += `<tr taskId="${task.COD_FORMULACION}">

                          <td data-titulo="MATERIALES" insumocodigoproducto=${
                            task.COD_PRODUCTO
                          }>${task.DES_PRODUCTO}</td>
                          <td data-titulo="CANTIDAD" >${
                            task.CANTIDAD_TOTAL
                          }</td>
                          <td data-titulo="LOTE" ><input type='text' readonly value="${lote(
                            lotes
                          )}"/></td>
                </tr>`;
            });

            $("#tablainsumosavancetotal").html(template);
            $("#selectNumProduccion").val("none").trigger("change");
            $("#cantidad").val("");
          } else {
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
          console.log(response);
          let titulo = "Error al ser mayor la cantidad";
          let texto = "Necesita una cantidad menor al insertar";
          let icon = "error";
          alertas(titulo, texto, icon);
        }
      },
      error: function (error) {
        console.log("object");
        let titulo = "Error al ser mayor la cantidad";
        let texto = "Necesita una cantidad menor al insertar";
        let icon = "error";
        alertas(titulo, texto, icon);
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
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
function lote(lotes) {
  let text = "";
  if (lotes != null) {
    for (let l = 0; l < lotes.length; l++) {
      text += lotes[l][1] + " - " + lotes[l][2] + " / ";
    }
  } else {
    text = "";
  }
  return text;
}
function alertas(titulo, texto, icon) {
  Swal.fire({
    title: "¡" + titulo + "!",
    text: "" + texto + "",
    icon: icon,
    confirmButtonText: "Aceptar",
  });
}
