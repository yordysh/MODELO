$(function () {
  //===== Prealoder

  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //----------------------------------------------------------------//
  $("#selectOperador").select2();
  $("#selectProducto").select2();
  $("#selectNumProduccion").select2();

  /*---------- Al seleccionar un combo producto me muestre contenido en combo produccion---- */
  let selectNumProduccion = $("#selectNumProduccion");
  const accion = "seleccionarProductoCombo";
  $("#selectProducto").change(function () {
    let idp = $("#selectProducto").val();
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
  /*---------------------------------------------------------------------------------------*/

  /*---------------calculo de cajas------------------------ */
  $("#botonCalcularEnvases").click((e) => {
    e.preventDefault();
    let cantidadenvases = $("#cantidadenvases").val();
    let codigoproducto = $("#selectProducto").val();
    // let codigorequerimiento = $("#selectProducto").attr("id_reque");

    const accion = "consultadecajas";
    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        cantidadenvases: cantidadenvases,
        codigoproducto: codigoproducto,
        // codigorequerimiento: codigorequerimiento,
      },
      success: function (response) {
        let dataenvase = JSON.parse(response);
        if (dataenvase.estado === "estado2") {
          var descripcionenvase = dataenvase.descripcionenvase;
          var cantidadenvase = dataenvase.cantidadenvase;
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
              $("#cantidadenvases").val("");
              $("#tablaenvasecalculado").empty();
            }
          });
          // alert("estado2");
        } else {
          let templateenvase = ``;
          dataenvase.forEach((task) => {
            // let lotesenvase = task.LOTES;
            templateenvase += `<tr taskId="${task.COD_FORMULACION}">

                              <td data-titulo="MATERIALES" taskcodigoproducto=${
                                task.COD_PRODUCTO
                              }>${task.DES_PRODUCTO}</td>
                              <td data-titulo="CANTIDAD" >${
                                task.CANTIDAD_TOTAL
                              }</td>
                              <td data-titulo="CANTIDAD MERMA" ><input step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57"/></td>
                              <!-- <td data-titulo="LOTE"><input  class='lotesx' type='text' readonly value="${lote(
                                lotesenvase
                              )}"/></td> -->

                    </tr>`;
          });
        }
      },
    });
  });
  /*------------------------------------------------------- */
});
