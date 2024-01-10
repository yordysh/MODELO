$(function () {
  //===== Prealoder

  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //-------------------------------------------//

  mostrarPendientes();
  mostrarRequerimientoTotal();

  //------------- MENU BAR JS ---------------//
  // let nav = document.querySelector(".nav"),
  //   searchIcon = document.querySelector("#searchIcon"),
  //   navOpenBtn = document.querySelector(".navOpenBtn"),
  //   navCloseBtn = document.querySelector(".navCloseBtn");

  // searchIcon.addEventListener("click", () => {
  //   nav.classList.toggle("openSearch");
  //   nav.classList.remove("openNav");
  //   if (nav.classList.contains("openSearch")) {
  //     return searchIcon.classList.replace(
  //       "icon-magnifying-glass",
  //       "icon-cross"
  //     );
  //   }
  //   searchIcon.classList.replace("icon-cross", "icon-magnifying-glass");
  // });

  // navOpenBtn.addEventListener("click", () => {
  //   nav.classList.add("openNav");
  //   nav.classList.remove("openSearch");
  // });

  // navCloseBtn.addEventListener("click", () => {
  //   nav.classList.remove("openNav");
  // });

  //----------------------------------------------------------------//

  function mostrarPendientes() {
    const accion = "buscarpendientesrequeridostotal";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_REQUERIMIENTO}">
                            <td data-titulo='CODIGO' style="text-align:center;">${task.COD_REQUERIMIENTO}</td>
                            <td data-titulo='FECHA' style="text-align:center;">${task.FECHA}</td>
                            <td data-titulo='PENDIENTE' style="text-align:center;"><button class="custom-icon" name="mostrarinsumos" id="mostrarInsumosRequerimiento"><i class="icon-circle-with-plus"></i></button></td>
                            <td data-titulo='RECHAZAR' style="text-align:center;"><button class="btn btn-danger" name="rechazarpedido" id="eliminarinsumorequerimiento"><i class="icon-circle-with-cross"></i></button></td>
                          </tr>`;
          });
          $("#tablamostartotalpendientes").html(template);
        } else {
          $("#tablamostartotalpendientes").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  $(document).on("click", "#mostrarInsumosRequerimiento", (e) => {
    e.preventDefault();
    /*----------Oculta el boton eliminar------------------ */
    const $fila = $(e.target).closest("tr");

    const $botonEliminar = $fila.find("#eliminarinsumorequerimiento");

    $botonEliminar.hide();
    /*---------------------------------------------------- */

    // eliminarInsumoButton.style.display = "none";

    let capturaTr = $(e.currentTarget).closest("tr");

    let cod_formulacion = capturaTr.attr("taskId");

    // if (capturaTr) {
    //   Swal.fire({
    //     title: "¡Correcto!",
    //     text: "Se añadio los registros a las tablas correspondientes.",
    //     icon: "success",
    //     confirmButtonText: "Aceptar",
    //   });
    // }

    const accionproductorequerimiento = "mostrarproductoporrequerimiento";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accionproductorequerimiento,
        cod_formulacion: cod_formulacion,
      },
      success: function (response) {
        // console.log(JSON.parse(response));
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          // console.log(tasks);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr codigorequerimiento="${task.COD_REQUERIMIENTO}">
                            <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CANTIDAD"  style="text-align:center;">${task.CANTIDAD}</td>
                            </tr>`;
          });
          $("#tablaproductorequerido").html(template);
        } else {
          $("#tablaproductorequerido").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });

    const accionproductoinsumo = "mostrarproductoinsumorequerimiento";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accionproductoinsumo,
        cod_formulacion: cod_formulacion,
      },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          // console.log(tasks);
          let template = ``;

          tasks.forEach((task) => {
            let restainsumopedir = (task.CANTIDAD - task.STOCK_ACTUAL).toFixed(
              3
            );
            // let total_comprar = Math.ceil(
            //   restainsumopedir / task.CANTIDAD_MINIMA
            // );
            // let cantidadtotalminima = total_comprar * task.CANTIDAD_MINIMA;

            template += `<tr codigorequerimiento="${task.COD_REQUERIMIENTO}">
                          <td data-titulo="INSUMOS"  style="text-align:center;" id_producto='${
                            task.COD_PRODUCTO
                          }'>${task.DES_PRODUCTO}</td>
                          <td data-titulo="CANTIDAD TOTAL"  style="text-align:center;">${parseFloat(
                            task.CANTIDAD
                          ).toFixed(2)}</td>
                          <!-- <td data-titulo="CANTIDAD FALTANTE"  style="text-align:center;">${restainsumopedir}</td> -->
                            <td data-titulo="STOCK ACTUAL"  style="text-align:center;">${
                              task.STOCK_ACTUAL
                            }</td>
                          </tr>`;
          });
          $("#tablainsumorequerido").html(template);
        } else {
          $("#tablainsumorequerido").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });

    $("#taskcodrequhiddenvalidar").val(cod_formulacion);
    const accionsihaycompra = "mostrarsihaycompra";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accionsihaycompra,
        cod_formulacion: cod_formulacion,
      },
      success: function (response) {
        // console.log(JSON.parse(response));
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          let template = ``;

          tasks.forEach((task) => {
            let insumo_pedir = (task.CANTIDAD - task.STOCK_ACTUAL).toFixed(3);
            let total_comprar = Math.ceil(insumo_pedir / task.CANTIDAD_MINIMA);
            let cantidadtotalminima = total_comprar * task.CANTIDAD_MINIMA;

            let preciototal =
              (cantidadtotalminima * task.PRECIO_PRODUCTO) /
              task.CANTIDAD_MINIMA;

            // Limitar a dos decimales usando toFixed
            preciototal = preciototal.toFixed(2);

            // Convertir de nuevo a número para realizar el redondeo manual
            preciototal = parseFloat(preciototal);

            // Redondear según tu criterio
            // const segundoDecimal = Math.floor((preciototal * 100) % 10);
            // if (segundoDecimal > 4) {
            //   preciototal = Math.ceil(preciototal * 10) / 10;
            // } else {
            //   preciototal = Math.round(preciototal * 10) / 10;
            // }

            if (insumo_pedir > 0) {
              if (task.CANTIDAD_MINIMA == 0) {
                Swal.fire({
                  icon: "error",
                  title: "Añadir cantidad minima",
                  text: "Producto no tiene cantidad minima a comprar, verificar en la tabla cantidades a comprar.",
                });
              }

              template += `<tr codigorequerimientototal="${
                task.COD_REQUERIMIENTO
              }">
              <td data-titulo="PROVEEDOR"  style="text-align:center;" codigo_proveedor='${
                task.COD_PROVEEDOR
              }'>${task.NOM_PROVEEDOR}</td>
                            <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${
                              task.COD_PRODUCTO
                            }'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CANTIDAD POR COMPRA"  style="text-align:center;">${
                              isNaN(cantidadtotalminima)
                                ? "Falta cantidad minina"
                                : cantidadtotalminima
                            }</td>
                            <td data-titulo="PRECIO TOTAL"  style="text-align:center;">${
                              isNaN(preciototal)
                                ? "Falta cantidad minina"
                                : preciototal
                            }</td>
                            <td data-titulo="FECHA ENTREGA"  style="text-align:center;"><input id="fechaentrega" type="date" /></td>
                            <td data-titulo='F.PAGO' style='text-align: center;'>
                            <select id="selectformapago" class="form-select" aria-label="Default select example">
                            <option value="E" selected>EFECTIVO</option>
                            <option value="D">DEPOSITO</option>
                            <option value="C">CREDITO</option>
                            </select>
                            </td>
                            <td data-titulo='IMAGEN'><button id='imagensum' class="btn btn-success" disabled>Añadir imagen</button></td>                         
                            <td data-titulo="PRECIO" id_proveedor='${
                              task.COD_PROVEEDOR
                            }' style="text-align:center;">${
                task.PRECIO_PRODUCTO == 0
                  ? "Falta cantidad minina"
                  : task.PRECIO_PRODUCTO
              }</td>
                          </tr>`;
            }
          });

          if (template === "") {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Insumos completos en el almacen",
              showConfirmButton: false,
              timer: 2500,
            });
            $("#tablainsumorequerido").hide();
            $("#mensajecompleto").css("display", "block");
          } else {
            Swal.fire({
              title: "¡Productos por comprar!",
              text: "Se necesita hacer una orden de compra.",
              icon: "info",
              confirmButtonText: "Aceptar",
            });
            $("#mensajecompleto").css("display", "none");
            $("#tablainsumorequerido").show();
            $("#tablatotalinsumosrequeridoscomprar").html(template);
          }
        } else {
          $("#tablatotalinsumosrequeridoscomprar").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
    $("#tablatotalinsumosrequeridoscomprar").empty();
  });
  /*--------------- VERIFICA SI LA FECHA ES DEL PROVEEODR------ */
  // $(document).on("click", "#fechaentrega", (e) => {

  // });
  /*-----------------------------------------------------------*/
  $("#insertarCompraInsumos").click((e) => {
    e.preventDefault();

    let valoresCapturadosVenta = [];

    // let idRequerimiento = $("#tablaproductorequerido tr").attr(
    //   "codigorequerimiento"
    // );

    let idRequerimiento = $("#tablamostartotalpendientes tr").attr("taskId");

    let tablainsumorequerido = $("#tablaproductorequerido");
    let tablainsumos = $("#tablainsumorequerido");
    let tablatotal = $("#tablatotalinsumosrequeridoscomprar");
    let taskcodrequhiddenvalidar = $("#taskcodrequhiddenvalidar").val();
    let codpersonal = $("#codpersonal").val();
    let cantidadesTotalesMinimas = [];

    $("#tablatotalinsumosrequeridoscomprar tr").each(function () {
      let id_proveedor = $(this).find("td:eq(0)").attr("codigo_proveedor");
      let id_producto_insumo = $(this).find("td:eq(1)").attr("id_producto");
      let cantidad_producto_insumo = $(this).find("td:eq(1)").text();
      // let cantidad_total_minima = $(this).find("td:eq(2)").text();
      let cantidad_total_minima = $(this).find("td:eq(4)").text();

      cantidadesTotalesMinimas.push(cantidad_total_minima);
      valoresCapturadosVenta.push({
        id_proveedor: id_proveedor,
        id_producto_insumo: id_producto_insumo,
        cantidad_producto_insumo: cantidad_producto_insumo,
        cantidad_total_minima: cantidad_total_minima,
      });
    });

    const dataimagenes = [];

    $("#tablaimagenes tr").each(function () {
      const filaimagen = $(this);
      const fileInput = filaimagen.find("td:eq(1) input[type=file]")[0];

      if (fileInput && fileInput.files.length > 0) {
        const file = fileInput.files[0];
        dataimagenes.push(file);
      }
    });

    if (taskcodrequhiddenvalidar === "") {
      Swal.fire({
        title: "¡Error!",
        text: "Añadir los pendientes para guardar.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return;
    }

    for (let i = 0; i < cantidadesTotalesMinimas.length; i++) {
      if (cantidadesTotalesMinimas[i] === "Falta cantidad minina") {
        Swal.fire({
          title: "¡Error!",
          text: "Añadir un valor de cantidad minima del producto",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        // break;
        return;
      }
    }

    const accion = "insertarordencompraitem";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        union: valoresCapturadosVenta,
        idRequerimiento: idRequerimiento,
        codpersonal: codpersonal,
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
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
              $("#taskcodrequerimiento").val("");
              $("#taskcodrequhiddenvalidar").val("");
              $("#mensajecompleto").css("display", "none");
              tablainsumorequerido.empty();
              tablainsumos.empty();
              tablatotal.empty();
              mostrarRequerimientoTotal();
              mostrarPendientes();
            }
          });
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });

  $(document).on("click", "#eliminarinsumorequerimiento", (e) => {
    e.preventDefault();

    let capturaTrEliminar = $(e.currentTarget).closest("tr");

    let cod_requerimiento_pedido = capturaTrEliminar.attr("taskId");
    let codpersonal = $("#codpersonal").val();
    // console.log(cod_requerimiento);
    const accioneliminar = "rechazarpendienterequerimiento";

    Swal.fire({
      title: "¿Está seguro de rechazar este registro?",
      text: "Este pediente contiene varios productos.",
      html: `<div>
                <h3>Observación:</h3> 
                <textarea class="form-control" id="observacion" rows='3' "></textarea>
              </div>`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        let observacion = $("#observacion").val();
        $.ajax({
          url: "./c_almacen.php",
          type: "POST",
          data: {
            accion: accioneliminar,
            cod_requerimiento_pedido: cod_requerimiento_pedido,
            codpersonal: codpersonal,
            observacion: observacion,
          },
          success: function (response) {
            mostrarPendientes();
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Registro rechazado correctamente.",
              showConfirmButton: false,
              timer: 1500,
            });
          },
          error: function (xhr, status, error) {
            console.error("Error al cargar los datos de la tabla:", error);
          },
        });
      }
    });
  });
  function mostrarRequerimientoTotal() {
    const accion = "mostrarRquerimientoTotal";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscartotal: search },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            $resultado = Math.ceil(
              task.STOCK_RESULTANTE / task.CANTIDAD_MINIMA
            );
            $resultadototalinsu = task.CANTIDAD_MINIMA * $resultado;

            template += `<tr taskId="${task.COD_REQUERIMIENTO}">
                  <td data-titulo="INSUMOS">${task.DES_PRODUCTO}</td>
                  <td data-titulo="CANTIDAD">${task.STOCK_RESULTANTE}</td>
                  <td data-titulo="CANTIDAD COMPRA">${resultadototalinsu}</td>                    
               </tr>`;
          });
          $("#tablatotalinsumosrequeridos").html(template);
        } else {
          $("#tablatotalinsumosrequeridos").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  /*--------- Cuando doy click en deposito me activa ------------- */
  $("body").on("change", "#selectformapago", function () {
    // Obtén el valor seleccionado
    var formaPago = $(this).val();

    // Obtén el botón de imagen dentro de la fila actual
    var fila = $(this).closest("tr");
    var botonImagen = fila.find("#imagensum");
    let codigoprod = fila.find("td:eq(1)").attr("id_producto");

    // Verifica la forma de pago y habilita/deshabilita el botón de imagen
    if (formaPago === "D") {
      // Si la forma de pago es DEPOSITO, habilita el botón de imagen
      botonImagen.prop("disabled", false);
    } else if (formaPago == "C" || formaPago == "E") {
      // En otros casos, deshabilita el botón de imagen y realiza cualquier otra lógica necesaria
      botonImagen.prop("disabled", true);

      $("#tablaimagenes tr").each(function () {
        const filaimagen = $(this);
        const fileInput = filaimagen.find("td:eq(3) input").val();
        if (fileInput == codigoprod) {
          filaimagen.remove();
        }
      });
      // También puedes hacer otras cosas aquí, como vaciar un contenedor de imágenes
      fila.find("#tablaimagenes").empty();
    }
  });
  /*------------------------------------------------------------- */
  /*------------------- Proceso de la orden de compra------------ */
  $("#procesoordencompra").click((e) => {
    e.preventDefault();
    let valoresCapturadosVentaTemp = [];

    // let idRequerimiento = $("#tablaproductorequerido tr").attr(
    //   "codigorequerimiento"
    // );

    let idRequerimiento = $("#tablamostartotalpendientes tr").attr("taskId");

    let tablainsumorequerido = $("#tablaproductorequerido");
    let tablainsumos = $("#tablainsumorequerido");
    let tablatotal = $("#tablatotalinsumosrequeridoscomprar");
    let taskcodrequhiddenvalidar = $("#taskcodrequhiddenvalidar").val();
    let codpersonal = $("#codpersonal").val();
    let fechaentregaalert = [];

    $("#tablatotalinsumosrequeridoscomprar tr").each(function () {
      let id_proveedor = $(this).find("td:eq(0)").attr("codigo_proveedor");
      let id_producto_insumo = $(this).find("td:eq(1)").attr("id_producto");
      let cantidad_producto_insumo = $(this).find("td:eq(2)").text();
      // let cantidad_total_minima = $(this).find("td:eq(2)").text();
      let monto = $(this).find("td:eq(3)").text();
      let fechaentrega = $(this).find("td:eq(4) input").val();
      let formapago = $(this).find("td:eq(5)").find("select").val();

      fechaentregaalert.push(fechaentrega);
      valoresCapturadosVentaTemp.push({
        id_proveedor: id_proveedor,
        id_producto_insumo: id_producto_insumo,
        cantidad_producto_insumo: cantidad_producto_insumo,
        monto: monto,
        formapago: formapago,
        fechaentrega: fechaentrega,
      });
    });

    // if (taskcodrequhiddenvalidar === "") {
    //   Swal.fire({
    //     title: "¡Error!",
    //     text: "Añadir los pendientes para guardar.",
    //     icon: "error",
    //     confirmButtonText: "Aceptar",
    //   });
    //   return;
    // }
    if (valoresCapturadosVentaTemp.length === 0) {
      Swal.fire({
        title: "¡Error!",
        text: "Añadir los pendientes para el proceso.",
        icon: "info",
        confirmButtonText: "Aceptar",
      });
      return;
    }

    for (let i = 0; i < fechaentregaalert.length; i++) {
      if (fechaentregaalert[i] === "") {
        Swal.fire({
          title: "¡Error!",
          text: "Añadir una fecha de entrega",
          icon: "info",
          confirmButtonText: "Aceptar",
        });
        // break;
        return;
      }
    }

    const accion = "insertarordencompraitemtemporal";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        valorcapturado: valoresCapturadosVentaTemp,
        idRequerimiento: idRequerimiento,
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: function (response) {
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos estan en el proceso.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              // $("#taskcodrequerimiento").val("");
              // $("#taskcodrequhiddenvalidar").val("");
              // $("#mensajecompleto").css("display", "none");
              // tablainsumorequerido.empty();
              // tablainsumos.empty();
              // tablatotal.empty();
              // mostrarRequerimientoTotal();
              mostrarPendientes();
            }
          });
        } else {
          alert("eerorr");
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  /*------------------------------------------------------------ */
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
