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
  $("#selectProduccion").select2();

  //------------- Busqueda con ajax registro envases----------------//

  //------------- Añadiendo con ajax registro envases----------------//

  //------------- Añadiendo con ajax registro envases----------------//
  $("#botonCalcularregistros").click((e) => {
    e.preventDefault();
    let seleccionarproductoregistro = $("#selectProductoCombo").val();
    let cantidad = $("#cantidad").val();

    const accion = "mostrarcalculoderegistro";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        seleccionarproductoregistro: seleccionarproductoregistro,
        cantidad: cantidad,
      },
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr codcalculoregistro="${task.COD_FORMULACIONES}">

                            <td data-titulo="ENVASES" cod_producto_registro='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CANTIDAD" >${task.TOTAL_ENVASE}</td>
                            <td data-titulo="LOTE" ><input /></td>
                        </tr>`;
          });

          $("#tablacalculoregistroenvase").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  });
  $("#botonguardarregistro").click((e) => {
    e.preventDefault();

    let valorescapturadosregistroenvase = [];
    $("#tablacalculoregistroenvase tr").each(function () {
      let id_producto_registro = $(this)
        .find("td:eq(0)")
        .attr("cod_producto_registro");
      let cantidad_producto_registro = $(this).find("td:eq(1)").text();
      let lote = $(this).find("td:eq(2) input").val();

      valorescapturadosregistroenvase.push(
        id_producto_registro,
        cantidad_producto_registro,
        lote
      );
    });
    console.log(valorescapturadosregistroenvase);
  });
  //---------------------------------------------------------------//
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //
  // Cargar registros ZONA AREA

  function fetchTasks() {
    const accion = "mostrarregistrosenvases";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscarregistroenvase: search },
      success: function (response) {
        console.log(response);
        // if (!response.error) {
        //   let tasks = JSON.parse(response);

        //   let template = ``;
        //   tasks.forEach((task) => {
        //     template += `<tr taskId="${task.COD_AVANCE_INSUMOS}">

        //         <!-- <td data-titulo="CODIGO" style="text-align:rigth;">${task.COD_AVANCE_INSUMOS}</td> -->
        //         <td data-titulo="FECHA" class="NOMBRE_T_ZONA_AREAS" style="text-align:rigth;">${task.FEC_GENERADO}</td>
        //         <td data-titulo="N°BACHADA" style="text-align:rigth;">${task.N_BACHADA}</td>
        //         <td data-titulo="PRODUCTO" style="text-align:rigth;">${task.ABR_PRODUCTO}</td>
        //         <td data-titulo="PRESENTACION" style="text-align:rigth;">${task.PESO_NETO} ${task.UNI_MEDIDA}</td>
        //         <td data-titulo="CANTIDAD FRASCOS" style="text-align:rigth;">${task.CANTIDAD_ENVASES}</td>
        //         <td data-titulo="CANTIDAD TAPAS" style="text-align:rigth;">${task.CANTIDAD_TAPAS}</td>
        //         <td data-titulo="CANTIDAD SCOOPS" style="text-align:rigth;">${task.CANTIDAD_SCOOPS}</td>
        //         <td data-titulo="CANTIDAD ALUPOL" style="text-align:rigth;">${task.CANTIDAD_ALUPOL}</td>
        //         <td data-titulo="CANTIDAD CAJAS" style="text-align:rigth;">${task.CANTIDAD_CAJAS}</td>
        //         <td data-titulo="LOTE" style="text-align:rigth;">${task.FECHA}</td>

        //         <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_AVANCE_INSUMOS="${task.COD_AVANCE_INSUMOS}"><i class="icon-trash"></i></button></td>
        //         <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_AVANCE_INSUMOS="${task.COD_AVANCE_INSUMOS}"><i class="icon-edit"></i></button></td>

        //     </tr>`;
        //   });

        //   $("#tablaRegistroEnvase").html(template);
        // }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
});
