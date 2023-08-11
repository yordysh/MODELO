$(function () {
  // fetchTasks();
  // cargarCombo();

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

  //------------- Añadiendo con ajax registro envases----------------//
  // $("#formularioEnvasesFormula").submit((e) => {
  //   e.preventDefault();

  //   const accion = edit === false ? "insertarRegistro" : "actualizarRegistro";

  //   $.ajax({
  //     url: "./c_almacen.php",
  //     data: {
  //       accion: accion,
  //       selectProductoCombo: $("#selectProductoCombo").val(),
  //       cantidad: $("#cantidad").val(),
  //       // fecha: $("#fecha").val(),
  //       codRegistro: $("#taskId").val(),
  //     },

  //     type: "POST",
  //     success: function (response) {
  //       console.log(response);
  //       //       if (response.toLowerCase() === "ok") {
  //       //         Swal.fire({
  //       //           title: "¡Guardado exitoso!",
  //       //           text: "Los datos se han guardado correctamente.",
  //       //           icon: "success",
  //       //           confirmButtonText: "Aceptar",
  //       //         }).then((result) => {
  //       //           if (result.isConfirmed) {
  //       //             fetchTasks();
  //       //             $("#formularioRegistroEnvases").trigger("reset");
  //       //             $("#selectProductoCombo").val(null).trigger("change");
  //       //             $("#selectProductoCombo").append(
  //       //               '<option value="none" selected disabled>Seleccione producto</option>'
  //       //             );
  //       //             $("#selectProduccion").val(null).trigger("change");
  //       //             $("#selectProduccion").append(
  //       //               '<option value="none" selected disabled>Seleccione produccion</option>'
  //       //             );
  //       //             $("#selectProductoCombo").prop("disabled", false);
  //       //             $("#selectProduccion").prop("disabled", false);
  //       //           }
  //       //         });
  //       //       } else {
  //       //         Swal.fire({
  //       //           icon: "error",
  //       //           title: "Oops...",
  //       //           text: "Duplicado!",
  //       //           confirmButtonText: "Aceptar",
  //       //         }).then((result) => {
  //       //           if (result.isConfirmed) {
  //       //             fetchTasks();
  //       //             $("#formularioRegistroEnvases").trigger("reset");
  //       //             $("#selectProductoCombo").val(null).trigger("change");
  //       //             $("#selectProductoCombo").append(
  //       //               '<option value="none" selected disabled>Seleccione producto</option>'
  //       //             );
  //       //             $("#selectProduccion").val(null).trigger("change");
  //       //             $("#selectProduccion").append(
  //       //               '<option value="none" selected disabled>Seleccione produccion</option>'
  //       //             );
  //       //           }
  //       //         });
  //       //       }
  //     },
  //   });
  // });
  //---------------------------------------------------------------//

  $("#botonCalcularProductosEnvases").click((e) => {
    e.preventDefault();

    const accion = "insertarProductoEnvase";
    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        selectProductoCombo: $("#selectProductoCombo").val(),
        cantidadTotal: $("#cantidadTotal").val(),
      },

      type: "POST",
      success: function (response) {
        // console.log(response);
        mostrarProductoEnvase();
        $("#cantidadTotal").val("");
      },
    });
  });

  $("#botonCalcularInsumos").click((e) => {
    e.preventDefault();

    const accion = "insertarInsumosProducto";
    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        selectProductoCombo: $("#selectProductoCombo").val(),
        selectInsumosCombo: $("#selectInsumosCombo").val(),
        cantidadInsumos: $("#cantidadInsumos").val(),

        // codRegistro: $("#taskId").val(),
      },

      type: "POST",
      success: function (response) {
        console.log(response);
      },
    });
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //

  function mostrarProductoEnvase() {
    const accion = "buscarenvaseproducto";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        selectProductoCombo: $("#selectProductoCombo").val(),
      },
      success: function (response) {
        console.log(response);
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
  function mostrarInsumosEnvases() {
    const accion = "buscarinsumoenvase";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        selectProductoCombo: $("#selectProductoCombo").val(),
      },
      success: function (response) {
        console.log(response);
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

  function fetchTasks() {
    const accion = "buscarregistroenvase";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscarregistro: search },
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_AVANCE_INSUMOS}">
  
                <!-- <td data-titulo="CODIGO" style="text-align:rigth;">${task.COD_AVANCE_INSUMOS}</td> -->
                <td data-titulo="FECHA" class="NOMBRE_T_ZONA_AREAS" style="text-align:rigth;">${task.FEC_GENERADO}</td>
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
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
});
