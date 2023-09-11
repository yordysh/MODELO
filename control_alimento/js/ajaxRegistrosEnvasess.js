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

    // console.log("codigoproduccion" + codigoproduccion);

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
        if (!response.error) {
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
    // let cantidad = $("#cantidad").val();

    let valoresCapturadosProduccion = [];

    $("#tablacalculoregistroenvase tr").each(function () {
      let valorProducto = $(this).find("td:eq(0)").attr("taskcodigoproducto");
      let valorCan = $(this).find("td:eq(1)").text();
      let valorlote = $(this).find("td:eq(2)").text();

      valoresCapturadosProduccion.push(valorProducto, valorCan, valorlote);
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
      },
      success: function (response) {
        console.log("respuesta" + response);
        // if (response == "ok") {
        //   Swal.fire({
        //     title: "¡Guardado exitoso!",
        //     text: "Los datos se han guardado correctamente.",
        //     icon: "success",
        //     confirmButtonText: "Aceptar",
        //   }).then((result) => {
        //     if (result.isConfirmed) {
        //       $("#selectInsumoEnvase").val("none").trigger("change");
        //       $("#cantidadInsumoEnvase").val("");
        //       tablaReqInsumo.empty();
        //       tablaReqEnv.empty();
        //       tablatotalInEn.empty();
        //     }
        //   });
        // }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
    });
  });
});
