$(function () {
  // fetchTasks();

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

  $("#selectProductoCombo").select2();
  $("#selectNumProduccion").select2();
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
        console.log(response);
        if (response == "error") {
          Swal.fire({
            title: "¡Valor incorrecto!",
            text: "Elija el valor minimo de requeriento del producto.",
            icon: "error",
            confirmButtonText: "Aceptar",
          });
        } else {
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
        cantidad: cantidad,
      },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          Swal.fire({
            icon: "success",
            title: "Calculo de registro",
            text: "Se añadio correctamente el registro.",
          });

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_FORMULACION}">

                                    <td data-titulo="MATERIALES" taskcodigoproducto=${task.COD_PRODUCTO}>${task.DES_PRODUCTO}</td>
                                    <td data-titulo="CANTIDAD" >${task.CANTIDAD_TOTAL}</td>
                                    <td data-titulo="LOTE" ><input type='text'/></td>

                          </tr>`;
          });

          $("#tablacalculoregistroenvase").html(template);
          $("#selectProductoCombo").val("none").trigger("change");
          $("#selectNumProduccion").val("none").trigger("change");
          $("#cantidad").val("");
        } else {
          Swal.fire({
            title: "¡Supero cantidad!",
            text: "Cantidad supero lo que hay en produccion.",
            icon: "error",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#cantidad").val("");
              $("#selectProductoCombo").val("none").trigger("change");
              $("#selectNumProduccion").val("none").trigger("change");
              $("#tablacalculoregistroenvase").empty();
            }
          });
          $("#tablacalculoregistroenvase").empty();
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
    });
  });

  $("#botonguardarregistro").click((e) => {
    e.preventDefault();
    let codigoproducto = $("#hiddenproducto").val();
    let codigoproduccion = $("#hiddenproduccion").val();
    let cantidad = $("#hiddencantidad").val();
    let codpersonal = $("#codpersonal").val();

    let valoresCapturadosProduccion = [];

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

    $("#tablacalculoregistroenvase tr").each(function () {
      let valorProducto = $(this).find("td:eq(0)").attr("taskcodigoproducto");
      let valorCan = $(this).find("td:eq(1)").text();
      let valorLote = $(this).find("td:eq(2) input").val();

      valoresCapturadosProduccion.push(valorProducto, valorCan, valorLote);
    });

    let accion = "guardarvalordeinsumosporregistro";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        valoresCapturadosProduccion: valoresCapturadosProduccion,
        codigoproducto: codigoproducto,
        codigoproduccion: codigoproduccion,
        cantidad: cantidad,
        codpersonal: codpersonal,
      },
      success: function (response) {
        // console.log("respuesta" + response);
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#selectProductoCombo").val("none").trigger("change");
              $("#selectNumProduccion").val("none").trigger("change");
              $("#hiddenproducto").val("");
              $("#hiddenproduccion").val("");
              $("#cantidad").val("");
              $("#tablacalculoregistroenvase").empty();
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
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
