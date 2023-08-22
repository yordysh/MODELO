$(function () {
  // mostarRequerimientoProducto();
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

  $("#selectInsumoEnvase").select2();
  //------------- Busqueda con ajax infraestructura Accesorio----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      let search = $("#search").val();
      const accion = "buscarrequerimientoproducto";

      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarrequerimiento: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);

            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.COD_REQUERIMIENTO}">
      
                              <td data-titulo="CODIGO PRODUCTO" >${task.DES_PRODUCTO}</td>      
                              <td data-titulo="CANTIDAD" >${task.CANTIDAD}</td>
  
                          </tr>`;
            });

            $("#tablaRequerimientoProducto").html(template);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos de la tabla:", error);
        },
      });
    } else {
      mostarRequerimientoProducto();
    }
  });
  //-------------------------------------------------------------------------//

  //--------------------- Insertar los valores insumos y envases ------------//

  $("#botonCalcularInsumoEnvase").click(async (e) => {
    e.preventDefault();
    let selectInsumoEnvase = $("#selectInsumoEnvase").val();

    let cantidadInsumoEnvase = $("#cantidadInsumoEnvase").val();

    let selectInsEnvase = $("#selectInsumoEnvase").val();

    let cantidInsumoEnvase = $("#cantidadInsumoEnvase").val();

    const datos = [
      {
        codigo: "codProducto",
        titulo: "PRODUCTO",
      },
      {
        codigo: "codCantidad",
        titulo: "CANTIDAD TOTAL",
      },
    ];

    try {
      await executeAjax();
    } catch (error) {
      console.error("Error:", error);
    }

    async function executeAjax() {
      try {
        await ajaxInsumo();
        await ajaxEnvase();
      } catch (error) {
        console.error("Error executing AJAX:", error);
      }
    }
    /*---------------  Añade tabla de total de cada producto-------------------*/
    // datos.forEach((dato) => {
    //   let nuevaFila = $("<tr>");
    //   let celdaProducto = $("<td data-titulo='" + dato.titulo + "'>").text(
    //     selectInsumoEnvase
    //   );
    //   let celdaCantidadPro = $("<td data-titulo='" + dato.titulo + "'>").text(
    //     cantidadInsumoEnvase
    //   );
    //   nuevaFila.append(celdaProducto, celdaCantidadPro);
    //   $("#tablaTotalInsEnva tbody").append(nuevaFila);
    // });

    /*-------------------------------------------------------------------------*/
    async function ajaxInsumo() {
      console.log("insumo");
      return new Promise(function (resolve, reject) {
        const accion = "mostrardatosinsumos";
        $.ajax({
          url: "./c_almacen.php",
          data: {
            accion: accion,
            selectInsumoEnvase: selectInsumoEnvase,
            cantidadInsumoEnvase: cantidadInsumoEnvase,
          },
          type: "POST",
          success: function (responseData) {
            // console.log(responseData);
            if (!responseData.error) {
              const insumos = JSON.parse(responseData);
              // console.log(insumos);
              let template = $("#tablaInsumosDatos").html();
              const existingRow = $(
                `tr[taskId="${insumos[0]["COD_FORMULACION"]}"]`
              );

              if (existingRow.length > 0) {
                const capturaValoresTabla = existingRow.find("td:eq(1)");

                for (let i = 0; i < capturaValoresTabla.length; i++) {
                  // console.log(insumos[i].TOTAL);
                  const valorFormula = insumos[i].TOTAL;
                  // const valor =
                  //   (insumos.CAN_FORMULACION_INSUMOS * cantidadInsumoEnvase) /
                  //   insumos.CAN_FORMULACION;
                  // console.log(valor);
                  // console.log(capturaValoresTabla[i]);
                  const valorCelda = capturaValoresTabla[i];
                  const cambio = parseFloat($(valorCelda).html());
                  const suma = cambio + parseFloat(valorFormula);
                  $(valorCelda).html(suma);
                }
              } else {
                insumos.forEach((insumo) => {
                  template += `<tr taskId="${insumo.COD_FORMULACION}">
                                <td data-titulo="INSUMOS" id='${insumo.COD_PRODUCTO}'>${insumo.DES_PRODUCTO}</td>
                                <td data-titulo="CANTIDAD">${insumo.TOTAL}</td>
                             </tr>`;
                });
                $("#tablaInsumosDatos").html(template);
                $("#cantidadInsumoEnvase").val("");
              }
              resolve();
            } else {
              reject("Error in response data");
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error in ajaxInsumo AJAX:", textStatus, errorThrown);
            reject(errorThrown);
          },
        });
      });
    }

    async function ajaxEnvase() {
      console.log("envasesss");
      return new Promise(function (resolve, reject) {
        const accionEnvase = "mostrardatosenvases";
        $.ajax({
          url: "./c_almacen.php",
          data: {
            accion: accionEnvase,
            selectInsEnvase: selectInsEnvase,
            cantidInsumoEnvase: cantidInsumoEnvase,
          },
          type: "POST",
          success: function (response) {
            if (!response.error) {
              let envases = JSON.parse(response);
              // console.log(envases);
              let templateEnvase = $("#tablaenvase").html();
              // console.log(templateEnvase);
              const existeFila = $(
                `tr[taskid="${envases[0]["COD_FORMULACIONES"]}"]`
                // `tr[taskid="selectInsEnvase"]`
              );
              // console.log(existeFila);
              if (existeFila.length > 0) {
                const capturaTabla = existeFila.find("td:eq(1)");
                for (let i = 0; i < capturaTabla.length; i++) {
                  const valor = envases[i].TOTAL_ENVASE;
                  console.log(valor);
                  const valorCeldas = capturaTabla[i];
                  const cambios = parseFloat($(valorCeldas).html());
                  const sumar = cambios + parseFloat(valor);
                  $(valorCeldas).html(sumar);
                }
              } else {
                // console.log(valorCeldas);
                envases.forEach((envase) => {
                  templateEnvase += `<tr taskid="${envase.COD_FORMULACIONES}">
                                <td data-titulo="ENVASES" id='${envase.COD_PRODUCTO}'>${envase.DES_PRODUCTO}</td>
                                <td data-titulo="CANTIDAD">${envase.TOTAL_ENVASE}</td>
                             </tr>`;
                });
                $("#tablaenvase").html(templateEnvase);
                // // $("#cantidadInsumoEnvase").val("");
              }
              // resolve(envases);
            } else {
              reject("Error in response data");
            }
          },
          error: function (xhr, status, error) {
            console.error("Error in ajaxEnvase:", error);

            reject(error);
          },
        });
      });
    }
  });
  //-------------------------------------------------------------------------//

  //--------------------- Insertar cantidades ------------//
  $("#botonInsertValor").click((e) => {
    e.preventDefault();
    let cantidadInsert = $("#cantidadInsumoEnvase").val();

    let valoresCapturados = [];

    $("#tablaInsumosDatos tr").each(function () {
      // let valorCelda = $(this).find("td:eq(1)").text();
      // valoresCapturados.push(valorCelda);
      // find(":input");
      let valorProducto = $(this).find("td:eq(0)").attr("id");
      let valorCan = $(this).find("td:eq(1)").html();
      let cod_formula = $(this).attr("taskId");
      valoresCapturados.push(cod_formula, valorProducto, valorCan);
      // console.log(valorProducto + "hola" + valorCan + " cod " + cod_formula);
    });

    // console.log("Valores capturados:", valoresCapturados);
    let accion = "guardarvalorescapturadosinsumos";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: { accion: accion, union: valoresCapturados },
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
              $("#selectInsumoEnvase").val("none").trigger("change");
            }
          });
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
    });
  });
  //-------------------------------------------------------------------------//
});
