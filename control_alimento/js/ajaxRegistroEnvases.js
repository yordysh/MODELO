$(function () {
  fetchTasks();
  cargarCombo();

  let fechaLabel = document.getElementById("labelFecha");
  fechaLabel.style.display = "none";
  let fechaInput = document.getElementById("fecha");
  fechaInput.style.display = "none";

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
  // $("#formularioRegistroEnvases").submit((e) => {
  //   e.preventDefault();

  //   const accion = edit === false ? "insertarRegistro" : "actualizarRegistro";

  //   // var fecha = $("#fecha").val();

  //   // console.log("fecha " + fecha);

  //   $.ajax({
  //     url: "./c_almacen.php",
  //     data: {
  //       accion: accion,
  //       selectProduccion: $("#selectProduccion").val(),
  //       selectProductoCombo: $("#selectProductoCombo").val(),
  //       cantidad: $("#cantidad").val(),
  //       fecha: $("#fecha").val(),
  //       codRegistro: $("#taskId").val(),
  //     },

  //     type: "POST",
  //     success: function (response) {
  //       console.log(response);
  //       if (response.toLowerCase() === "ok") {
  //         Swal.fire({
  //           title: "¡Guardado exitoso!",
  //           text: "Los datos se han guardado correctamente.",
  //           icon: "success",
  //           confirmButtonText: "Aceptar",
  //         }).then((result) => {
  //           if (result.isConfirmed) {
  //             fetchTasks();
  //             $("#formularioRegistroEnvases").trigger("reset");
  //             $("#selectProductoCombo").val(null).trigger("change");
  //             $("#selectProductoCombo").append(
  //               '<option value="none" selected disabled>Seleccione producto</option>'
  //             );
  //             $("#selectProduccion").val(null).trigger("change");
  //             $("#selectProduccion").append(
  //               '<option value="none" selected disabled>Seleccione produccion</option>'
  //             );
  //             $("#selectProductoCombo").prop("disabled", false);
  //             $("#selectProduccion").prop("disabled", false);
  //           }
  //         });
  //       } else {
  //         Swal.fire({
  //           icon: "error",
  //           title: "Oops...",
  //           text: "Duplicado!",
  //           confirmButtonText: "Aceptar",
  //         }).then((result) => {
  //           if (result.isConfirmed) {
  //             fetchTasks();
  //             $("#formularioRegistroEnvases").trigger("reset");
  //             $("#selectProductoCombo").val(null).trigger("change");
  //             $("#selectProductoCombo").append(
  //               '<option value="none" selected disabled>Seleccione producto</option>'
  //             );
  //             $("#selectProduccion").val(null).trigger("change");
  //             $("#selectProduccion").append(
  //               '<option value="none" selected disabled>Seleccione produccion</option>'
  //             );
  //           }
  //         });
  //       }
  //     },
  //   });
  // });

  //------------- Añadiendo con ajax registro envases----------------//
  $("#formularioRegistroEnvases").submit((e) => {
    const datos = [
      {
        codigo: "codEnvase",
        titulo: "ENVASE",
      },
      {
        codigo: "codTapa",
        titulo: "TAPA",
      },
    ];

    const selectorProducto = $("#selectProductoCombo").val();
    const selectorProduccion = $("#selectProduccion").val();

    let cont = 0;
    datos.forEach((dato) => {
      cont++;
      let cantidad;
      if (dato.codigo === "codCajas") {
        cantidad = 123;
      } else if (dato.codigo === "codBolsas") {
        cantidad = 21321;
      } else {
        cantidad = $("#cantidad").val();
      }
      let nuevaFila = $("<tr>");
      let celdaProducto = $("<td data-titulo='CODIGO PRODUCTO'>").text(
        selectorProducto
      );
      let celdaProduccion = $("<td data-titulo='CODIGO PRODUCCION'>").text(
        selectorProduccion
      );
      let celdaCantidadEnvases = $(
        "<td data-titulo='" + dato.titulo + "'>"
      ).text(cantidad);
      let celdaCantidadlote = $("<td data-titulo='LOTE'>").html(
        "<input type='text' class='inputValor' name='lote" +
          cont +
          "' />" +
          "<input type='hidden' class='inputValor' name='cant" +
          cont +
          "' />"
      );
      // Agregar las celdas a la fila
      nuevaFilaEnvases.append(
        celdaProducto,
        celdaProduccion,
        celdaCantidadEnvases,
        celdaCantidadlote
      );
      $("#tablaRE tbody").append(nuevaFila);
    });
    e.preventDefault();
  });
  //---------------------------------------------------------------//
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //
  // Cargar registros ZONA AREA

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

  function cargarCombo() {
    const produccion = $("#selectProduccion");
    const accion = "seleccionarProduccion";

    console.log(produccion);
    $("#selectProductoCombo").change(function () {
      var codProducto = $(this).val();
      console.log(codProducto);
      $.ajax({
        data: {
          codProducto: codProducto,
          accion: accion,
        },
        dataType: "html",
        type: "POST",
        url: "./c_almacen.php",
      }).done(function (data) {
        produccion.html(data);
      });
    });
  }

  // function mandarDatos(selectorProducto, selectorProduccion, cantidad) {
  //   const accion = "datoscapturadosregistroenvase";
  //   const selectorProducto = selectorProducto;
  //   const selectorProduccion = selectorProduccion;
  //   const cantidad = cantidad;
  //   // const search = "";
  //   $.ajax({
  //     url: "./c_almacen.php",
  //     type: "POST",
  //     data: {
  //       accion: accion,
  //       selectorProducto: selectorProducto,
  //       selectorProduccion: selectorProduccion,
  //       cantidad: cantidad,
  //     },
  //     success: function (response) {
  //       console.log(response);
  //       // if (!response.error) {
  //       //   let tasks = JSON.parse(response);

  //       //   let template = ``;
  //       //   tasks.forEach((task) => {
  //       //     template += `<tr taskId="${task.COD_AVANCE_INSUMOS}">

  //       //       <!-- <td data-titulo="CODIGO" style="text-align:rigth;">${task.COD_AVANCE_INSUMOS}</td> -->
  //       //       <td data-titulo="FECHA" class="NOMBRE_T_ZONA_AREAS" style="text-align:rigth;">${task.FEC_GENERADO}</td>
  //       //       <td data-titulo="N°BACHADA" style="text-align:rigth;">${task.N_BACHADA}</td>
  //       //       <td data-titulo="PRODUCTO" style="text-align:rigth;">${task.ABR_PRODUCTO}</td>
  //       //       <td data-titulo="PRESENTACION" style="text-align:rigth;">${task.PESO_NETO} ${task.UNI_MEDIDA}</td>
  //       //       <td data-titulo="CANTIDAD FRASCOS" style="text-align:rigth;">${task.CANTIDAD_ENVASES}</td>
  //       //       <td data-titulo="CANTIDAD TAPAS" style="text-align:rigth;">${task.CANTIDAD_TAPAS}</td>
  //       //       <td data-titulo="CANTIDAD SCOOPS" style="text-align:rigth;">${task.CANTIDAD_SCOOPS}</td>
  //       //       <td data-titulo="CANTIDAD ALUPOL" style="text-align:rigth;">${task.CANTIDAD_ALUPOL}</td>
  //       //       <td data-titulo="CANTIDAD CAJAS" style="text-align:rigth;">${task.CANTIDAD_CAJAS}</td>
  //       //       <td data-titulo="LOTE" style="text-align:rigth;">${task.FECHA}</td>

  //       //       <td  style="text-align:center;"><button class="btn btn-danger task-delete" data-COD_AVANCE_INSUMOS="${task.COD_AVANCE_INSUMOS}"><i class="icon-trash"></i></button></td>
  //       //       <td  style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_AVANCE_INSUMOS="${task.COD_AVANCE_INSUMOS}"><i class="icon-edit"></i></button></td>

  //       //   </tr>`;
  //       //   });

  //       //   $("#tablaRegistroEnvase").html(template);
  //       // }
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error al cargar los datos de la tabla:", error);
  //     },
  //   });
  // }

  //------------------------ Actualiza un dato de mi tabla ----------------- //

  $(document).on("click", ".task-update", () => {
    var element = $(this)[0].activeElement.parentElement.parentElement;

    var cod_registro = $(element).attr("taskId");

    fechaInput.style.display = "block";
    fechaLabel.style.display = "block";

    const accion = "editarRegistroEnvase";

    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, cod_registro_envase: cod_registro },
      type: "POST",
      success: function (response) {
        console.log(response);
        if (!response.error) {
          const task = JSON.parse(response);
          $("#selectProduccion").prop("disabled", true);
          $("#selectProduccion")
            .append(
              new Option(
                task.NUM_PRODUCION_LOTE,
                task.NUM_PRODUCION_LOTE,
                true,
                true
              )
            )
            .trigger("change");
          $("#selectProductoCombo").prop("disabled", true);
          $("#selectProductoCombo")
            .append(
              new Option(task.ABR_PRODUCTO, task.ABR_PRODUCTO, true, true)
            )
            .trigger("change");
          $("#cantidad").val(task.CANTIDAD).prop("disabled", true);
          $("#fecha").val(task.FECHA);
          $("#taskId").val(task.COD_AVANCE_INSUMOS);
          edit = true;
        }
      },
    });
  });

  //------------------------ Elimina un dato de mi tabla ----------------- //

  $(document).on("click", ".task-delete", function (e) {
    e.preventDefault();
    // var COD_ZONA = $(this).data("COD_ZONA");

    var cod_registro_envase = $(this).attr("data-COD_AVANCE_INSUMOS");
    const accion = "eliminarregistroenvases";

    Swal.fire({
      title: "¿Está seguro de eliminar este registro?",
      text: "Esta acción no se puede deshacer.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "./c_almacen.php",
          data: { accion: accion, codregistro: cod_registro_envase },
          type: "POST",
          success: function (response) {
            fetchTasks();
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Registro eliminado correctamente.",
              showConfirmButton: false,
              timer: 1500,
            });
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });
      }
    });
  });
});
