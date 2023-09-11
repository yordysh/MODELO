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

  $("#botonCalcularregistros").click((e) => {
    e.preventDefault();
    let codigoproducto = $("#selectProductoCombo").val();
    let codigoproduccion = $("#selectNumProduccion").val();
    let cantidad = $("#cantidad").val();

    console.log("codigoproduccion" + codigoproduccion);

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
        // console.log(response);
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_FORMULACION}">

                                    <td data-titulo="MATERIALES" taskcodigoproducto=${task.COD_PRODUCTO}>${task.DES_PRODUCTO}</td>
                                    <td data-titulo="CANTIDAD" >${task.CANTIDAD_TOTAL}</td>
                                    <td data-titulo="LOTE" ><input type='text'/></td>

                          </tr>`;
          });

          $("#tablacalculoregistroenvase").html(template);
        } else {
          Swal.fire({
            title: "¡Supero cantidad!",
            text: "Cantidad supero lo que hay en produccion.",
            icon: "error",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#cantidad").val("");
              // $("#selectProductoCombo").val("none").trigger("change");
              // $("#selectNumProduccion").val("none").trigger("change");
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
    let codigoproducto = $("#selectProductoCombo").val();
    let codigoproduccion = $("#selectNumProduccion").val();
    let cantidad = $("#cantidad").val();

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
              $("#selectProductoCombo").val("none").trigger("change");
              $("#selectNumProduccion").val("none").trigger("change");
              $("#cantidad").val("");
              $("#tablacalculoregistroenvase").empty();
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
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
