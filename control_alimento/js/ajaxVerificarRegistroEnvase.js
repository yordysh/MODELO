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
    $("#txtcantidadproductos").val(Math.round(totalproducto));
  });
  /*------------------------------------------------------------------------------ */
  /*---------Verficar si el producto seleccionado es menor a productos iguales-------------- */
  // $(".selectProducto").on("change", (e) => {
  $("#selectProductoCombo").change(function () {
    // e.preventDefault();
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
    let accioncantidad = "convalidocantidadproduccion";
    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accioncantidad,
        codigoproduccion: codigoproduccion,
        codigoproducto: codigoproducto,
        cantidadenvase: $("#txtcantidadproductos").val(),
        cantidadinsumo: cantidad,
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: function (response) {
        let tasks = JSON.parse(response);
        if (tasks.estado === "estado1") {
          var valorunicoproduccion = tasks.valorunicoproduccion;
          var valorcantidad = tasks.cantidad;
          // console.log(tasks.valorunicoproduccion);
          Swal.fire({
            icon: "error",
            title: "¡La cantidad superada de la producción!",
            text:
              "La cantidad ingresada " +
              valorcantidad +
              "kg es mayor a la cantidad de la producción " +
              valorunicoproduccion +
              "kg.",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#cantidad").val("");
              $("#txtcantidadproductos").val("");
              $("#tablainsumosavancetotal").empty();
              $("#tablacalculoregistroenvase").empty();
            }
          });

          // alert("estado1");
        } else if (tasks.estado === "estado2") {
          var descripcionenvase = tasks.descripcionenvase;
          var cantidadenvase = tasks.cantidadenvase;
          // console.log(descripcionenvase + "aa" + cantidadenvase);
          Swal.fire({
            icon: "error",
            title: "¡La cantidad de envases supera al stock!",
            text:
              "La cantidad ingresada de " +
              descripcionenvase +
              " es mayor a la cantidad del stock que hay " +
              cantidadenvase +
              " " +
              descripcionenvase,
          }).then((result) => {
            if (result.isConfirmed) {
              $("#cantidad").val("");
              $("#txtcantidadproductos").val("");
              $("#tablainsumosavancetotal").empty();
              $("#tablacalculoregistroenvase").empty();
            }
          });
          // alert("estado2");
        } else if (tasks.estado === "estado3") {
          var descripcioninsumo = tasks.descripcioninsumo;
          var cantidaddeinsumo = tasks.cantidaddeinsumo;
          // console.log(descripcionenvase + "aa" + cantidadenvase);
          Swal.fire({
            icon: "error",
            title: "¡La cantidad de insumos supera al stock!",
            text:
              "La cantidad ingresada de " +
              descripcioninsumo +
              " es mayor a la cantidad del stock que hay " +
              cantidaddeinsumo +
              "kg " +
              descripcioninsumo +
              ".",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#cantidad").val("");
              $("#txtcantidadproductos").val("");
              $("#tablainsumosavancetotal").empty();
              $("#tablacalculoregistroenvase").empty();
            }
          });
          // alert("estado3");
        } else if (tasks.json1 && tasks.json2) {
          let dataenvase = tasks.json1;
          let datainsumo = tasks.json2;
          // console.log("json1 json2");
          // console.log(tasks.json1);
          // console.log(tasks.json2);
          let templateenvase = ``;
          dataenvase.forEach((task) => {
            let lotesenvase = task.LOTES;
            templateenvase += `<tr taskId="${task.COD_FORMULACION}">
      
                                <td data-titulo="MATERIALES" taskcodigoproducto=${
                                  task.COD_PRODUCTO
                                }>${task.DES_PRODUCTO}</td>
                                <td data-titulo="CANTIDAD" >${
                                  task.CANTIDAD_TOTAL
                                }</td>
                                <td data-titulo="LOTE"><input  class='lotesx' type='text' readonly value="${lote(
                                  lotesenvase
                                )}"/></td>
      
                      </tr>`;
          });

          let templateinsumo = ``;
          datainsumo.forEach((task) => {
            let lotesinsumo = task.LOTES;
            templateinsumo += `<tr taskId="${task.COD_FORMULACION}">
        
                                  <td data-titulo="MATERIALES" insumocodigoproducto=${
                                    task.COD_PRODUCTO
                                  }>${task.DES_PRODUCTO}</td>
                                  <td data-titulo="CANTIDAD" >${
                                    task.CANTIDAD_TOTAL
                                  }</td>
                                  <td data-titulo="LOTE" ><input type='text' readonly value="${lote(
                                    lotesinsumo
                                  )}"/></td>
                        </tr>`;
          });

          $("#tablacalculoregistroenvase").html(templateenvase);
          $("#tablainsumosavancetotal").html(templateinsumo);
        }
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  /*---------Guardar avance -----------------------*/
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

    // if (hayCampoVacio) {
    //   let titulo = "Error de lote vacio";
    //   let texto = "Necesita insertar una cantidad de lote en el kardex.";
    //   let icon = "info";
    //   alertas(titulo, texto, icon);
    //   // alert("error");
    // }

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

    $("#tablacalculoregistroenvase tr").each(function () {
      let valorcodigolote = $(this).find("td:eq(2) input").val();
      if (valorcodigolote.length == "") {
        let titulo = "Error de lote vacio";
        let texto =
          "Necesita insertar una cantidad de lote de envases en el kardex.";
        let icon = "info";
        alertas(titulo, texto, icon);
        return;
      }
    });

    $("#tablainsumosavancetotal tr").each(function () {
      let valorcodigolote = $(this).find("td:eq(2) input").val();
      if (valorcodigolote.length == "") {
        let titulo = "Error de lote vacio";
        let texto =
          "Necesita insertar una cantidad de lote de insumos en el kardex.";
        let icon = "info";
        alertas(titulo, texto, icon);
        return;
      }
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
        }
      },
      error: function (error) {
        console.log("error");
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  /*--------------------------------------------- */
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
      text += lotes[l][1] + " - " + parseFloat(lotes[l][2]).toFixed(2) + " / ";
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
