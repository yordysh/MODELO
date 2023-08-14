$(function () {
  mostrarProductoEnvase();

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
  $("#selectInsumosCombo").select2();
  $("#selectEnvasesProductoCombo").select2();

  //------------- Busqueda con ajax registro envases----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      var search = $("#search").val();
      const accion = "buscarregistroenvase";
      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarregistro: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);

            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.COD_AVANCE_INSUMOS}">
    
                  <td data-titulo="FECHA" style="text-align:rigth;">${task.FEC_GENERADO}</td>
                  <td data-titulo="N°BACHADA" style="text-align:rigth;">${task.N_BACHADA}</td>
                  <td data-titulo="PRODUCTO" style="text-align:rigth;">${task.ABR_PRODUCTO}</td>
                  <td data-titulo="PRESENTACION" style="text-align:rigth;">${task.PESO_NETO} ${task.UNI_MEDIDA}</td>
                  <td data-titulo="CANTIDAD FRASCOS" style="text-align:rigth;">${task.CANTIDAD_ENVASES}</td>
                  <td data-titulo="CANTIDAD TAPAS" style="text-align:rigth;">${task.CANTIDAD_TAPAS}</td>
                  <td data-titulo="CANTIDAD SCOOPS" style="text-align:rigth;">${task.CANTIDAD_SCOOPS}</td>
                  <td data-titulo="CANTIDAD ALUPOL" style="text-align:rigth;">${task.CANTIDAD_ALUPOL}</td>
                  <td data-titulo="CANTIDAD CAJAS" style="text-align:rigth;">${task.CANTIDAD_CAJAS}</td>
                  <td data-titulo="LOTE" style="text-align:rigth;">${task.FECHA}</td>
    
                  <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_AVANCE_INSUMOS="${task.COD_AVANCE_INSUMOS}"><i class="icon-trash"></i></button></td>
                  <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_AVANCE_INSUMOS="${task.COD_AVANCE_INSUMOS}"><i class="icon-edit"></i></button></td>
    
              </tr>`;
            });

            $("#tablaRegistroEnvase").html(template);
          }
        },
      });
    } else {
      fetchTasks();
    }
  });

  $("#botonCalcularProductosEnvases").click((e) => {
    e.preventDefault();
    let tbInsumos = $("#tablaInsumos tr");
    let dataInsumo = [];

    for (let i = 0; i < tbInsumos.length; i++) {
      let row = tbInsumos[i];
      let columns = $(row).find("td");
      let insumo = $(columns[0]).text();
      let cantidad = $(columns[2]).text();
      // console.log(cantidad);

      dataInsumo.push({ insumo, cantidad });
    }
    // console.log(dataInsumo);
    let tbEnvases = $("#tablaEnvasesCadaProducto tr");
    let dataEnvase = [];

    for (let i = 0; i < tbEnvases.length; i++) {
      let rowenvase = tbEnvases[i];
      let columns = $(rowenvase).find("td");
      let envase = $(columns[0]).text();
      let cantidadEnvase = $(columns[2]).text();

      dataEnvase.push({ envase, cantidadEnvase });
    }
    // console.log(dataEnvase);
    const accion = "insertarProductoEnvase";
    $.ajax({
      url: "./c_almacen.php",
      dataType: "json",
      data: {
        accion: accion,
        selectProductoCombo: $("#selectProductoCombo").val(),
        cantidadTotal: $("#cantidadTotal").val(),
        dataInsumo: dataInsumo,
        dataEnvase: dataEnvase,
      },
      type: "POST",
      success: function (response) {
        console.log("Response :", response);
      },
    });
  });

  $("#botonCalcularInsumos").click((e) => {
    e.preventDefault();
    let selectInsumosCombo = $("#selectInsumosCombo").val();
    let cantidadInsumos = $("#cantidadInsumos").val();

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
      });
    } else {
      let newRow = `<tr>
                      <td data-titulo='Insumos' style='display:none;'>${selectInsumosCombo}</td>
                      <td data-titulo='Insumo'>${selectInsumosTexto}</td>
                      <td data-titulo='Cantidad'>${cantidadInsumos}</td>
                    </tr>`;
      $("#tablaInsumos").append(newRow);
    }

    // let newRow = `<tr>
    //                 <td  data-titulo='Insumos' style='display:none;'>${selectInsumosCombo}</td>
    //                 <td  data-titulo='Insumo'>${selectInsumosTexto}</td>
    //                 <td  data-titulo='Cantidad'>${cantidadInsumos}</td>
    //               </tr>`;
    // $("#tablaInsumos").append(newRow);

    // const accion = "insertarInsumosProducto";
    // $.ajax({
    //   url: "./c_almacen.php",
    //   data: {
    //     accion: accion,
    //     selectProductoCombo: $("#taskIdProducto").val(),
    //     selectInsumosCombo: $("#selectInsumosCombo").val(),
    //     cantidadInsumos: $("#cantidadInsumos").val(),

    //     // codRegistro: $("#taskId").val(),
    //   },

    //   type: "POST",
    //   success: function (response) {
    //     console.log(response);
    //     mostrarInsumosEnvases();
    //     $("#selectInsumosCombo").append(
    //       $("<option>", {
    //         value: "none",
    //         text: "Seleccione insumos",
    //         disabled: true,
    //         selected: true,
    //       })
    //     );
    //     $("#cantidadInsumos").val("");
    //   },
    // });
  });

  $("#botonCalcularEnvasesProducto").click((e) => {
    e.preventDefault();

    let selectEnvasesProductoCombo = $("#selectEnvasesProductoCombo").val();
    let cantidadEnvaseProducto = $("#cantidadEnvaseProducto").val();

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
      });
    } else {
      let newRow = `<tr>
                    <td  data-titulo='Envases' style='display:none;'>${selectEnvasesProductoCombo}</td>
                    <td  data-titulo='Envase'>${selectEnvasesTexto}</td>
                    <td  data-titulo='Cantidad'>${cantidadEnvaseProducto}</td>
                  </tr>`;
      $("#tablaEnvasesCadaProducto").append(newRow);
    }
    // const accion = "insertarenvasesporproducto";
    // $.ajax({
    //   url: "./c_almacen.php",
    //   data: {
    //     accion: accion,
    //     selectProductoCombo: $("#taskIdProducto").val(),
    //     selectEnvasesProductoCombo: $("#selectEnvasesProductoCombo").val(),
    //     cantidadEnvaseProducto: $("#cantidadEnvaseProducto").val(),
    //   },

    //   type: "POST",
    //   success: function (response) {
    //     console.log(response);
    //     mostrarEnvases();
    //     $("#selectEnvasesProductoCombo").append(
    //       $("<option>", {
    //         value: "none",
    //         text: "Seleccione envases",
    //         disabled: true,
    //         selected: true,
    //       })
    //     );
    //     $("#cantidadEnvaseProducto").val("");
    //   },
    // });
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //

  function mostrarProductoEnvase() {
    const accion = "buscarenvaseproducto";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        // selectProductoCombo: $("#selectProductoCombo").val(),
      },
      success: function (response) {
        // console.log(JSON.parse(response));
        if (!response.error) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="">

                <td data-titulo="CODIGO" style="text-align:rigth;">${task.DES_PRODUCTO}</td>
                <td data-titulo="CANTIDAD PRODUCTO" style="text-align:rigth;">${task.CAN_FORMULACION}</td>

            </tr>`;
          });

          $("#tablaProductoEnvases").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
});
