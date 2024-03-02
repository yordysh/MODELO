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
  // mostrarRequerimientoTotal();

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
            if (restainsumopedir >= 0) {
              restainsumopedir;
            } else {
              restainsumopedir = "SUFICIENTE";
            }

            // let newColumnContent =
            //   restainsumopedir >= 0
            //     ? `<td><input type="text" placeholder="Nuevo Valor"></td>`
            //     : "";

            template += `<tr codigorequerimiento="${task.COD_REQUERIMIENTO}">
                          <td data-titulo="INSUMOS"  style="text-align:center;" id_producto='${
                            task.COD_PRODUCTO
                          }'>${task.DES_PRODUCTO}</td>
                          <td data-titulo="CANTIDAD TOTAL"  style="text-align:center;">${parseFloat(
                            task.CANTIDAD
                          ).toFixed(2)}</td>
                          <td data-titulo="CANTIDAD FALTANTE"  style="text-align:center;">${restainsumopedir}</td>
                            <td data-titulo="STOCK ACTUAL"  style="text-align:center;">${parseFloat(
                              task.STOCK_ACTUAL
                            ).toFixed(2)}</td>`;
            // <td data-titulo="NUEVA COLUMNA" style="text-align:center;">${newColumnContent}</td>
            if (restainsumopedir == "SUFICIENTE") {
              template += `<td data-titulo="AGREGAR"><button id='insertarfilaorden' class="btn btn-success"><i class="icon-circle-with-plus"></i></button></td> `;
            }
            template += `</tr>`;
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
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          console.log(tasks);
          let template = ``;
          let i = 1;
          tasks.forEach((task) => {
            if (task.COD_ORDEN_COMPRA) {
              template += `<tr codigorequerimientototal="${
                task.COD_REQUERIMIENTO_TEMP
              }">
              <td data-titulo="ITEM"  style="text-align:center;">${i}</td>
              <td data-titulo="PROVEEDOR"  style="text-align:center;" codigo_proveedor='${
                task.COD_PROVEEDOR_TEMP
              }'>${task.NOM_PROVEEDOR_TEMP}</td>
                            <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${
                              task.COD_PRODUCTO_TEMP
                            }'>${task.DES_PRODUCTO_TEMP}</td>
                            <td data-titulo="CANTIDAD POR COMPRA"  style="text-align:center;"><input id="cantidadacomprar" value="${
                              task.CANTIDAD_INSUMO_ENVASE
                            }" /></td>
                            <td data-titulo="PRECIO TOTAL"  style="text-align:center;">${
                              task.MONTO
                            }</td>
                            <td data-titulo="FECHA ENTREGA"  style="text-align:center;"><input class="fecha-entrega" id="fechaentrega" type="date" value="${
                              task.FECHA_REALIZADA
                            }"/></td>
                            <td data-titulo='F.PAGO' style='text-align: center;'>
                            <select id="selectformapago" class="form-select" aria-label="Default select example">
                            <option value="E" ${
                              task.F_PAGO === "E" ? "selected" : ""
                            }>EFECTIVO</option>
                            <option value="D" ${
                              task.F_PAGO === "D" ? "selected" : ""
                            }>DEPOSITO</option>
                            <option value="C" ${
                              task.F_PAGO === "C" ? "selected" : ""
                            }>CREDITO</option>
                            </select>
                            </td>
                            <td data-titulo='IMAGEN'><button id='imagensum' class="btn btn-success" disabled><i class="icon-camera"></i></button></td>
                            <td data-titulo="PRECIO" id_proveedor='${
                              task.COD_PROVEEDOR_TEMP
                            }' style="text-align:center;">${parseFloat(
                task.PRECIO_MINIMO
              ).toFixed(2)}</td>
 
                          <td data-titulo="OTRAS CANTIDADES">
                          <button id='modalotrascantidades' class="btn btn-success"><i class="icon-circle-with-plus"></i></button>
                          <button id='eliminarfilaorden' class="btn btn-danger"><i class="icon-trash"></i></button>
                          </td>
                          </tr>`;
              i++;
            } else {
              let insumo_pedir = (task.CANTIDAD - task.STOCK_ACTUAL).toFixed(3);
              let total_comprar = Math.ceil(
                insumo_pedir / task.CANTIDAD_MINIMA
              );
              let cantidadtotalminima = total_comprar * task.CANTIDAD_MINIMA;
              let preciototal =
                (cantidadtotalminima * task.PRECIO_PRODUCTO) /
                task.CANTIDAD_MINIMA;
              preciototal = preciototal.toFixed(2);
              preciototal = parseFloat(preciototal);

              if (insumo_pedir > 0) {
                if (task.CANTIDAD_MINIMA == 0) {
                  Swal.fire({
                    icon: "error",
                    title: "Añadir cantidad minima",
                    text: "Producto no tiene cantidad minima a comprar, verificar en la tabla cantidades a comprar.",
                  });
                }
                const fechaActual = new Date().toISOString().split("T")[0];
                template += `<tr codigorequerimientototal="${
                  task.COD_REQUERIMIENTO
                }">
                <td data-titulo="ITEM"  style="text-align:center;">${i}</td>
                <td data-titulo="PROVEEDOR"  style="text-align:center;" codigo_proveedor='${
                  task.COD_PROVEEDOR
                }'>${task.NOM_PROVEEDOR}</td>
                              <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${
                                task.COD_PRODUCTO
                              }'>${task.DES_PRODUCTO}</td>
                              <td data-titulo="CANTIDAD POR COMPRA"  style="text-align:center;" valor_comprar_cantidad="${insumo_pedir}"><input id="cantidadacomprar" value="${
                  isNaN(cantidadtotalminima)
                    ? "Falta cantidad minina"
                    : cantidadtotalminima
                }"/></td>
                              <td data-titulo="PRECIO TOTAL"  style="text-align:center;">${
                                isNaN(preciototal)
                                  ? "Falta cantidad minina"
                                  : preciototal
                              }</td>
                              <td data-titulo="FECHA ENTREGA"  style="text-align:center;"><input class="fecha-entrega" id="fechaentrega" type="date" value="${fechaActual}"/></td>
                              <td data-titulo='F.PAGO' style='text-align: center;'>
                              <select id="selectformapago" class="form-select" aria-label="Default select example">
                              <option value="E" selected>EFECTIVO</option>
                              <option value="D">DEPOSITO</option>
                              <option value="C">CREDITO</option>
                              </select>
                              </td>
                              <td data-titulo='IMAGEN'><button id='imagensum' class="btn btn-success" disabled><i class="icon-camera"></i></button></td>
                              <td data-titulo="PRECIO" id_proveedor='${
                                task.COD_PROVEEDOR
                              }' style="text-align:center;">${
                  task.PRECIO_PRODUCTO == 0
                    ? "Falta cantidad minina"
                    : parseFloat(task.PRECIO_PRODUCTO).toFixed(3)
                }</td>
                <td data-titulo="OTRAS CANTIDADES"><button id='modalotrascantidades' class="btn btn-success"><i class="icon-circle-with-plus"></i></button></td>        
                </tr>`;
                i++;
              }
              /*--------------- VERIFICA SI ES EL MISMO PROVEEDOR PONER FECHA ------ */
              $("body").on("change", ".fecha-entrega", function () {
                var fechaentrega = $(this).val();
                var fila = $(this).closest("tr");

                let codigoproveedor = fila
                  .find("td:eq(1)")
                  .attr("codigo_proveedor");
                $("#tablatotalinsumosrequeridoscomprar tr").each(function () {
                  let id_proveedor = $(this)
                    .find("td:eq(1)")
                    .attr("codigo_proveedor");

                  if (codigoproveedor === id_proveedor) {
                    let fechita = $(this)
                      .find("td:eq(5) input")
                      .val(fechaentrega);
                  }
                });
              });
              /*-----------------------------------------------------------*/
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

  /*--------------------------------------- ELIMINA LAFILA CUAANDO HAY COD_ORDEN_COMPRA--- */
  $(document).on("click", "#eliminarfilaorden", function () {
    var filas = $(this).closest("tr");
    filas.remove();
  });
  /*------------------------------------------------------------------------------------- */

  /*--------------------------------------------------------- */
  /*------------------ Activa si es Deposito bloquea los demas de mismo proveedor------------ */
  $("body").on("change", "#selectformapago", function () {
    var fpago = $(this).val();
    var filapago = $(this).closest("tr");

    let codigoproveedorpago = filapago
      .find("td:eq(1)")
      .attr("codigo_proveedor");

    $("#tablatotalinsumosrequeridoscomprar tr").each(function () {
      if ($(this).is(filapago)) {
      } else {
        let id_proveedor = $(this).find("td:eq(1)").attr("codigo_proveedor");
        let comboFechas = $(this).find("td:eq(6) select");

        if (codigoproveedorpago === id_proveedor) {
          comboFechas.prop("disabled", true).val(fpago);
        }
        // else {
        //   comboFechas.prop("disabled", false);
        // }
      }
    });
  });
  /*---------------------------------------------------------------------------------------- */

  /*---------------------------------- INSERTAR NUEVA FILA DE SUFICIENTE -------------- */
  $(document).on("click", "#insertarfilaorden", function (e) {
    e.preventDefault();

    var filaactual = $(this).closest("tr");

    var descripProducto = filaactual.find('td[data-titulo="INSUMOS"]').text();
    var codigoProducto = filaactual
      .find('td[data-titulo="INSUMOS"]')
      .attr("id_producto");

    var comprarcantidadexactatotal = filaactual
      .find('td[data-titulo="CANTIDAD TOTAL"]')
      .text();
    const fechaahoraactual = new Date().toISOString().split("T")[0];

    var nuevafila = `
    <tr>
    <td></td>
    <td data-titulo="PROVEEDOR" style="text-align:center;"> 
    <select id="selectproveedorescanmin" class="form-select">
    <option value="none" selected disabled>Seleccione proveedor</option>
    </select>
    </td>
    <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${codigoProducto}'>${descripProducto}</td>
    <td data-titulo="CANTIDAD POR COMPRA" cantidadcomprarexacto='${comprarcantidadexactatotal}'><input id="cantidadacomprar"/></td>
    <td data-titulo="PRECIO TOTAL"></td>
    <td data-titulo="FECHA ENTREGA"><input class="fecha-entrega" id="fechaentrega" type="date" value="${fechaahoraactual}"/></td>
    <td data-titulo="F.PAGO">
    <select id="selectformapago" class="form-select" aria-label="Default select example">
    <option value="E" selected>EFECTIVO</option>
    <option value="D">DEPOSITO</option>
    <option value="C">CREDITO</option>
    </select>
    </td>
    <td data-titulo='IMAGEN'><button id='imagensum' class="btn btn-success" disabled>Añadir imagen</button></td>
    <td data-titulo="PRECIO" id_proveedor='' style="text-align:center;"></td>
    <td data-titulo="ELIMINAR"><button id="deletef" class="btn btn-danger icon-trash eliminarfila"></button></td>
    </tr>
`;
    const accion = "mostrarproveedorescanmin";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, cod_producto_fila: codigoProducto },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);

          // var selectElement = nuevafila.find("#selectproveedorescanmin");
          // selectElement.empty();
          // selectElement.append(
          //   $("<option>", {
          //     value: "none",
          //     text: "Seleccione proveedor",
          //     disabled: true,
          //     selected: true,
          //   })
          // );

          tasks.forEach((item) => {
            $("#selectproveedorescanmin").append(
              $("<option>", {
                value: item.COD_PROVEEDOR,
                text: item.NOM_PROVEEDOR,
              })
            );
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
    var tabla = $(this).closest("body").find("#tTotalinsumoscomprar");
    tabla.find("#tablatotalinsumosrequeridoscomprar").prepend(nuevafila);
  });
  /*---------------------------------------------------------------------------------- */

  /*-------------------------- Dar click el boton y añade fila-------- */
  $(document).on("click", "#modalotrascantidades", function () {
    var currentRow = $(this).closest("tr");
    var desProducto = currentRow.find('td[data-titulo="PRODUCTO"]').text();
    var codProducto = currentRow
      .find('td[data-titulo="PRODUCTO"]')
      .attr("id_producto");
    var comprarcantidadexacta = currentRow
      .find('td[data-titulo="CANTIDAD POR COMPRA"]')
      .attr("valor_comprar_cantidad");

    const fechaahora = new Date().toISOString().split("T")[0];

    var newRow = `
        <tr>
        <td></td>
        <td data-titulo="PROVEEDOR" style="text-align:center;"> 
        <select id="selectproveedorescanmin" class="form-select">
        <option value="none" selected disabled>Seleccione proveedor</option>
        </select>
        </td>
        <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${codProducto}'>${desProducto}</td>
        <td data-titulo="CANTIDAD POR COMPRA" cantidadcomprarexacto='${comprarcantidadexacta}'><input id="cantidadacomprar"/></td>
        <td data-titulo="PRECIO TOTAL"></td>
        <td data-titulo="FECHA ENTREGA"><input class="fecha-entrega" id="fechaentrega" type="date" value="${fechaahora}"/></td>
        <td data-titulo="F.PAGO">
        <select id="selectformapago" class="form-select" aria-label="Default select example">
        <option value="E" selected>EFECTIVO</option>
        <option value="D">DEPOSITO</option>
        <option value="C">CREDITO</option>
        </select>
        </td>
        <td data-titulo='IMAGEN'><button id='imagensum' class="btn btn-success" disabled><i class="icon-camera"></i></button></td>
        <td data-titulo="PRECIO" id_proveedor='' style="text-align:center;"></td>
        <td data-titulo="ELIMINAR"><button id="deletef" class="btn btn-danger icon-trash eliminarfila"></button></td>
        </tr>
    `;
    const accion = "mostrarproveedorescanmin";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, cod_producto_fila: codProducto },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          var selectElement = currentRow
            .next()
            .find("#selectproveedorescanmin");
          selectElement.empty();
          selectElement.append(
            $("<option>", {
              value: "none",
              text: "Seleccione proveedor",
              disabled: true,
              selected: true,
            })
          );

          tasks.forEach((item) => {
            selectElement.append(
              $("<option>", {
                value: item.COD_PROVEEDOR,
                text: item.NOM_PROVEEDOR,
              })
            );
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
    currentRow.after(newRow);
  });
  /*----------------------------------------------------------------- */

  /*---------------------Eliminar fila añadida de proveedor---------------- */

  // Asigna un controlador de eventos al botón con id "deletef"
  $(document).on("click", "#deletef", function () {
    var fila = $(this).closest("tr");
    fila.remove();
  });

  /*---------------------------------------------------------------------- */

  /*---------------------------------Insertar los valores de proceso --------- */

  $("#insertarCompraInsumos").click((e) => {
    e.preventDefault();

    let valoresCapturadosVenta = [];
    let valoresdeinsumos = [];
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
      let proveedorcantidad = $(this).find("td:eq(0)").attr("codigo_proveedor");

      if (proveedorcantidad != undefined) {
        id_proveedor = proveedorcantidad;
      } else {
        id_proveedor = $(this).find("td:eq(0) select").val();
      }

      let valorcantidad = $(this)
        .find('td[data-titulo="CANTIDAD POR COMPRA"] input')
        .val();

      let codigoproducto = $(this)
        .find('td[data-titulo="PRODUCTO"]')
        .attr("id_producto");
      let productonombre = $(this).find('td[data-titulo="PRODUCTO"]').text();

      let codigoproveedorcant = $(this).find("td:eq(0) select").val();
      if (codigoproveedorcant == "none") {
        Swal.fire({
          // title: "¡Guardado exitoso!",
          text:
            "Necesita seleccionar un proveedor del producto " +
            productonombre +
            ".",
          icon: "info",
        });
      }

      const accion = "mostrarcantidadpreciocalculo";
      $.ajax({
        url: "./c_almacen.php",
        type: "POST",
        data: {
          accion: accion,
          valorcan: valorcantidad,
          valorproveedor: proveedorcantidad,
          valorproducto: codigoproducto,
          codigoproveedor: codigoproveedorcant,
        },
        success: function (response) {
          if (isJSON(response)) {
            let task = JSON.parse(response);
            // console.log(task);
            let valorcambiadoprecio = $(this)
              .find("td:eq(3)")
              .text(task[0].PRECIO_PAGAR);

            let valorpreciomin = $(this)
              .find("td:eq(7)")
              .text(task[0].PRECIO_PRODUCTO);

            let valorcantidadx = parseFloat(task[0].CANTIDAD_MINIMA);
            if (parseFloat(valorcantidad) < valorcantidadx) {
              Swal.fire({
                text:
                  "Necesita poner la cantidad minima que brinda el proveedor " +
                  task[0].NOM_PROVEEDOR +
                  " del producto " +
                  task[0].DES_PRODUCTO +
                  ".",
                icon: "info",
                confirmButtonText: "Aceptar",
              });
              return;
            }
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos de la tabla:", error);
        },
      });
    });

    $("#tablatotalinsumosrequeridoscomprar tr").each(function () {
      let id_proveedor;
      let proveedor = $(this).find("td:eq(1)").attr("codigo_proveedor");

      if (proveedor != undefined) {
        id_proveedor = proveedor;
      } else {
        id_proveedor = $(this).find("td:eq(1) select").val();
      }

      let id_producto_insumo = $(this).find("td:eq(2)").attr("id_producto");
      let cantidad_producto_insumo = $(this).find("td:eq(3) input").val();
      // let cantidad_total_minima = $(this).find("td:eq(2)").text();
      let monto = $(this).find("td:eq(4)").text();
      let fechaentrega = $(this).find("td:eq(5) input").val();
      let formapago = $(this).find("td:eq(6)").find("select").val();
      let preciomin = $(this).find("td:eq(8)").text();

      fechaentregaalert.push(fechaentrega);
      valoresCapturadosVenta.push({
        id_proveedor: id_proveedor,
        id_producto_insumo: id_producto_insumo,
        cantidad_producto_insumo: cantidad_producto_insumo,
        monto: monto,
        formapago: formapago,
        fechaentrega: fechaentrega,
        preciomin: preciomin,
      });
    });

    $("#tablainsumorequerido tr").each(function () {
      let nombreproducto = $(this).find("td:eq(0)").text();
      let productocod = $(this).find("td:eq(0)").attr("id_producto");
      let valorpedir = $(this).find("td:eq(2)").text();
      if (valorpedir == "SUFICIENTE") {
        valorpedir = 0;
      } else {
        valorpedir;
      }
      valoresdeinsumos.push({
        nombreproducto: nombreproducto,
        productocod: productocod,
        valorpedir: valorpedir,
      });
    });

    let paresUnicos = {};

    for (let i = 0; i < valoresCapturadosVenta.length; i++) {
      let codigoproducto = valoresCapturadosVenta[i]["id_producto_insumo"];
      let id_proveedor = valoresCapturadosVenta[i]["id_proveedor"];
      let nombreproducto = valoresCapturadosVenta[i]["nombreproducto"];

      let claveUnica = codigoproducto + "_" + id_proveedor;
      if (paresUnicos[claveUnica]) {
        Swal.fire({
          title: "Se encontro duplicado de proveedor y producto",
          text: "El producto duplicado " + nombreproducto,
          icon: "info",
          confirmButtonText: "Aceptar",
        });

        return;
      } else {
        paresUnicos[claveUnica] = true;
      }
    }

    const dataimagenes = [];
    const codigoproveedorimagenes = [];

    $("#tablaimagenes tr").each(function () {
      const filaimagen = $(this);
      const fileInput = filaimagen.find("td:eq(2) input[type=file]")[0];
      const codigoproveedor = filaimagen.find("td:eq(5) input").val();

      if (fileInput && fileInput.files.length > 0) {
        const file = fileInput.files[0];
        dataimagenes.push(file);
        codigoproveedorimagenes.push({ codigoproveedor });
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

    const formData = new FormData();
    formData.append("accion", "insertarordencompraitem");
    formData.append("idRequerimiento", taskcodrequhiddenvalidar);
    formData.append("codpersonal", codpersonal);

    for (let j = 0; j < valoresCapturadosVenta.length; j++) {
      const objetoInsumo = valoresCapturadosVenta[j];
      const objetoInsumoString = JSON.stringify(objetoInsumo);
      formData.append("union[]", objetoInsumoString);
    }

    for (let i = 0; i < dataimagenes.length; i++) {
      formData.append("file[]", dataimagenes[i]);
    }
    for (let l = 0; l < codigoproveedorimagenes.length; l++) {
      const objetoproveedor = codigoproveedorimagenes[l];
      const proveedor = JSON.stringify(objetoproveedor);
      formData.append("codigoproveedorimagenes[]", proveedor);

      //formData.append("codigoproveedorimagenes[]", codigoproveedorimagenes[i]);
    }
    for (let r = 0; r < valoresdeinsumos.length; r++) {
      const objetotemp = valoresdeinsumos[r];
      const Temp = JSON.stringify(objetotemp);
      formData.append("valoresdeinsumos[]", Temp);
    }

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: async function (response) {
        let respuesta = JSON.parse(response);
        if (respuesta.estado === "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos estan en el proceso.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              tablainsumorequerido.empty();
              tablainsumos.empty();
              $("#tablaimagenes").empty();
              tablatotal.empty();
              mostrarPendientes();
              $("body").off("change", ".fecha-entrega");
            }
          });
          // Manejar el error o ajustar la lógica según sea necesario
          return;
        } else if (respuesta.estado === "error") {
          Swal.fire({
            title: "¡Error al guardar!",
            text: "Necesita llenar datos en el proceso",
            icon: "error",
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
        } else if (respuesta.estado === "errorduplicado") {
          Swal.fire({
            title: "¡Error al guardar!",
            text: "Ya se inserto en el guardado",
            icon: "error",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              tablainsumorequerido.empty();
              tablainsumos.empty();
              $("#tablaimagenes").empty();
              tablatotal.empty();
              mostrarPendientes();
            }
          });
        }
        // for (const element of respuesta) {
        //   if (element.estado == "errorcantidad") {
        //     await Swal.fire({
        //       text:
        //         "En el producto " +
        //         element.nombreproducto +
        //         " necesita poner la suma de cantidades mayor a " +
        //         element.cantidad,
        //       icon: "info",
        //       confirmButtonText: "Aceptar",
        //     });
        //   }
        // }
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
  /*-------------------------------------------------------------------------- */
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
    let codigoprod = fila.find("td:eq(2)").attr("id_producto");

    // Verifica la forma de pago y habilita/deshabilita el botón de imagen
    if (formaPago === "D") {
      // Si la forma de pago es DEPOSITO, habilita el botón de imagen
      botonImagen.prop("disabled", false);
    } else if (formaPago == "C" || formaPago == "E") {
      botonImagen.prop("disabled", true);

      $("#tablaimagenes tr").each(function () {
        const filaimagen = $(this);
        const fileInput = filaimagen.find("td:eq(4) input").val();
        if (fileInput == codigoprod) {
          filaimagen.remove();
        }
      });
      // También puedes hacer otras cosas aquí, como vaciar un contenedor de imágenes
      fila.find("#tablaimagenes").empty();
    }
  });
  /*------------------------------------------------------------- */
  /*--------------Verifica la cantidad y precio total al cambiar------ */
  $(document).on("keyup", "#cantidadacomprar", function () {
    let filaescr = $(this).closest("tr");
    var valorcan = filaescr
      .find('td[data-titulo="CANTIDAD POR COMPRA"] input')
      .val();
    var valorproveedor = filaescr
      .find('td[data-titulo="PROVEEDOR"]')
      .attr("codigo_proveedor");

    var valorproducto = filaescr
      .find('td[data-titulo="PRODUCTO"]')
      .attr("id_producto");

    var codigoproveedor = filaescr.find("td:eq(1) select").val();
    // console.log(valorproveedor + "valor");
    // console.log(codigoproveedor);
    if (valorproveedor == null) {
      if (codigoproveedor == null) {
        Swal.fire({
          // title: "¡Guardado exitoso!",
          text: "Necesita seleccionar un proveedor.",
          icon: "info",
        });
        return;
      }
    }
    // var duplicado = false;
    // $("#tablatotalinsumosrequeridoscomprar tr").each(function () {
    //   let proveedorcantidad = $(this).find("td:eq(1)").attr("codigo_proveedor");
    //   let producto = $(this).find("td:eq(2)").attr("id_producto");
    //   console.log(proveedorcantidad + "producto " + producto);

    //   if (codigoproveedor == proveedorcantidad && valorproducto == producto) {
    //     duplicado = true;
    //     return false;
    //   }
    // });

    // if (duplicado) {
    //   Swal.fire({
    //     text: "El proveedor seleccionado ya existe en la tabla.",
    //     icon: "warning",
    //   });
    // }
    const accion = "mostrarcantidadpreciocalculo";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        valorcan: valorcan,
        valorproveedor: valorproveedor,
        valorproducto: valorproducto,
        codigoproveedor: codigoproveedor,
      },
      success: function (response) {
        if (isJSON(response)) {
          let task = JSON.parse(response);
          // console.log(task);
          let valorcambiadoprecio = filaescr
            .find("td:eq(4)")
            .text(task[0].PRECIO_PAGAR);

          let valorpreciomin = filaescr
            .find("td:eq(8)")
            .text(task[0].PRECIO_PRODUCTO);

          // let valorcantidad = parseFloat(task[0].CANTIDAD_MINIMA);
          // if (parseFloat(valorcan) < valorcantidad) {
          //   Swal.fire({
          //     text: "Necesita poner la cantidad minima que brinda el proveedor.",
          //     icon: "info",
          //     confirmButtonText: "Aceptar",
          //   });
          // }
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  });
  /*------------------------------------------------------------------ */
  /**---------------click en input imagen-- */
  // Función para manejar las mutaciones en la tabla
  function handleTableMutations(mutationsList, observer) {
    mutationsList.forEach((mutation) => {
      if (mutation.addedNodes.length > 0) {
        // Al menos un nodo ha sido agregado a la tabla
        mutation.addedNodes.forEach((node) => {
          if (
            node.nodeType === 1 &&
            node.tagName === "TR" &&
            $(node).closest("#tablaimagenes").length > 0
          ) {
            // Mostrar la alerta indicando que se añadió una nueva fila
            Swal.fire({
              icon: "success",
              title: "Se añadio una nueva fila",
              showConfirmButton: false,
              timer: 900,
            });
          }
        });
      }
    });
  }
  // Crear un nuevo objeto MutationObserver con la función de manejo
  const observer = new MutationObserver(handleTableMutations);

  // Configurar el observer para observar cambios en la tabla y sus descendientes
  const config = { childList: true, subtree: true };
  observer.observe(document.getElementById("tablaimagenes"), config);
  /*-------------------------------------------------------------------------- */

  $("#tablaimagenes").on("change", ".idimagenorden", function () {
    var archivoSeleccionado = $(this).prop("files")[0];
    var urlArchivo = URL.createObjectURL(archivoSeleccionado);
    var imagenSeleccionada = $("<img>")
      .attr({
        src: urlArchivo,
        id: "imgcompra",
      })
      .css({
        width: "200px",
        height: "150px",
        borderRadius: "80px",
      });

    $(this)
      .closest("tr")
      .find(".archivosubido")
      .empty()
      .append(imagenSeleccionada);

    console.log("Archivo seleccionado:", archivoSeleccionado);
  });

  $(document).on("click", "#imagensum", function (e) {
    e.preventDefault();
    var fila = $(this).closest("tr");
    var codigoProductoImagen = fila
      .find('td[data-titulo="PRODUCTO"]')
      .attr("id_producto");
    var codigoproductonombre = fila.find('td[data-titulo="PRODUCTO"]').text();
    var codigoproveedorcell = fila.find('td[data-titulo="PROVEEDOR"]');
    var codigoproveedornombre = codigoproveedorcell.text();

    var selectedOption = codigoproveedorcell.find("select").val();
    if (selectedOption && selectedOption !== "none") {
      codigoproveedornombre = codigoproveedorcell
        .find("select option:selected")
        .text();
    }

    var codigoProveedor = fila
      .find('td[data-titulo="PROVEEDOR"]')
      .attr("codigo_proveedor");
    var codigoProveedor1 = fila
      .find('td[data-titulo="PROVEEDOR"] select')
      .val();

    var imagenBoton = $("<input>")
      .attr("type", "file")
      .attr("id", "fotoimagen")
      .attr("name", "inputimagensubir")
      .addClass("idimagenorden");

    var imagenBotonDelete = $("<button>")
      .addClass("btn btn-danger text-center delete")
      .css("margin-right", "5px")
      .append(
        $("<i>").addClass("icon-trash text-white").css("font-size", "1.em")
      );

    var imagenPredeterminadaURL = "./images/camara.png";
    var codigo = $("<input>")
      .attr("type", "hidden")
      .attr("id", "idproducto")
      .val(codigoProductoImagen);
    if (codigoProveedor) {
      var codigoproveedorinput = $("<input>")
        .attr("type", "hidden")
        .attr("id", "idproveedor")
        .val(codigoProveedor);
    } else {
      {
        var codigoproveedorinput = $("<input>")
          .attr("type", "hidden")
          .attr("id", "idproveedor")
          .val(codigoProveedor1);
      }
    }

    var nuevaFila = $("<tr id='filaTabla'>").append(
      $("<td>").addClass("text-center").append(imagenBotonDelete),
      $("<td>").addClass("text-center").append(codigoproveedornombre),
      $("<td>").addClass("text-center").append(imagenBoton),
      $("<td>")
        .addClass("text-center archivosubido")
        .append("<img src='" + imagenPredeterminadaURL + "' alt='imgcompra'>"),
      $("<td>").addClass("text-center").append(codigo),
      $("<td>").addClass("text-center").append(codigoproveedorinput)
    );

    $("#tablaimagenes").append(nuevaFila);
  });
  /*---------------------------------------------- */
  /*------ Al darle click en el tacho de la iamgen eliminara fila */
  $(document).on("click", ".delete", function () {
    var filaAEliminar = $(this).closest("#filaTabla");
    filaAEliminar.remove();
  });
  /*------------------------------------------------------------ */

  /*------------------- Proceso de la orden de compra------------ */
  $("#procesoordencompra").click((e) => {
    e.preventDefault();
    let valoresCapturadosVentaTemp = [];
    let valoresdeinsumos = [];
    let taskcodrequhiddenvalidar = $("#taskcodrequhiddenvalidar").val();

    let tablainsumorequerido = $("#tablaproductorequerido");
    let tablainsumos = $("#tablainsumorequerido");
    let tablatotal = $("#tablatotalinsumosrequeridoscomprar");

    let codpersonal = $("#codpersonal").val();
    let fechaentregaalert = [];

    $("#tablatotalinsumosrequeridoscomprar tr").each(function () {
      let proveedorcantidad = $(this).find("td:eq(1)").attr("codigo_proveedor");
      let nombrepro = $(this).find("td:eq(1)").text();

      if (proveedorcantidad != undefined) {
        id_proveedor = proveedorcantidad;
      } else {
        id_proveedor = $(this).find("td:eq(1) select").val();
      }

      let valorcantidad = $(this)
        .find('td[data-titulo="CANTIDAD POR COMPRA"] input')
        .val();

      let codigoproducto = $(this)
        .find('td[data-titulo="PRODUCTO"]')
        .attr("id_producto");
      let nomproducto = $(this).find('td[data-titulo="PRODUCTO"]').text();

      let codigoproveedorcant = $(this).find("td:eq(1) select").val();

      if (!valorcantidad) {
        Swal.fire({
          text:
            "Necesita añadir una cantidad " +
            nombrepro +
            " y el producto " +
            nomproducto +
            ".",
          icon: "info",
          confirmButtonText: "Aceptar",
        });
        return;
      }
      if (!codigoproveedorcant) {
        Swal.fire({
          text:
            "Necesita seleccionar un proveedor del producto " +
            nomproducto +
            ".",
          icon: "info",
          confirmButtonText: "Aceptar",
        });
        return;
      }

      const accionz = "mostrarcantidadpreciocalculo";
      $.ajax({
        url: "./c_almacen.php",
        type: "POST",
        data: {
          accion: accionz,
          valorcan: valorcantidad,
          valorproveedor: proveedorcantidad,
          valorproducto: codigoproducto,
          codigoproveedor: codigoproveedorcant,
        },
        success: function (response) {
          // console.log("object");
          if (isJSON(response)) {
            console.log("object");
            let task = JSON.parse(response);
            console.log(task);
            let valorcambiadoprecio = $(this)
              .find("td:eq(3)")
              .text(task[0].PRECIO_PAGAR);
            let valorpreciomin = $(this)
              .find("td:eq(7)")
              .text(task[0].PRECIO_PRODUCTO);
            let valorcantidadx = parseFloat(task[0].CANTIDAD_MINIMA);
            if (parseFloat(valorcantidad) < valorcantidadx) {
              Swal.fire({
                text:
                  "Necesita poner la cantidad minima que brinda el proveedor " +
                  task[0].NOM_PROVEEDOR +
                  " del producto " +
                  task[0].DES_PRODUCTO +
                  ".",
                icon: "info",
                confirmButtonText: "Aceptar",
              });
              return;
            }
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos de la tabla:", error);
        },
      });
    });

    $("#tablatotalinsumosrequeridoscomprar tr").each(function () {
      let id_proveedor;
      let proveedor = $(this).find("td:eq(1)").attr("codigo_proveedor");

      if (proveedor != undefined) {
        id_proveedor = proveedor;
      } else {
        id_proveedor = $(this).find("td:eq(1) select").val();
      }

      let id_producto_insumo = $(this).find("td:eq(2)").attr("id_producto");
      let nombreproducto = $(this).find("td:eq(2)").text();
      let cantidad_producto_insumo = $(this).find("td:eq(3) input").val();
      // let cantidad_total_minima = $(this).find("td:eq(2)").text();
      let monto = $(this).find("td:eq(4)").text();
      let fechaentrega = $(this).find("td:eq(5) input").val();
      let formapago = $(this).find("td:eq(6)").find("select").val();
      let preciomin = $(this).find("td:eq(8)").text();

      fechaentregaalert.push(fechaentrega);
      valoresCapturadosVentaTemp.push({
        id_proveedor: id_proveedor,
        id_producto_insumo: id_producto_insumo,
        nombreproducto: nombreproducto,
        cantidad_producto_insumo: cantidad_producto_insumo,
        monto: monto,
        formapago: formapago,
        fechaentrega: fechaentrega,
        preciomin: preciomin,
      });
    });

    $("#tablainsumorequerido tr").each(function () {
      let nombreproducto = $(this).find("td:eq(0)").text();
      let productocod = $(this).find("td:eq(0)").attr("id_producto");
      let valorpedir = $(this).find("td:eq(2)").text();
      if (valorpedir == "SUFICIENTE") {
        valorpedir = 0;
      } else {
        valorpedir;
      }
      valoresdeinsumos.push({
        nombreproducto: nombreproducto,
        productocod: productocod,
        valorpedir: valorpedir,
      });
    });

    let paresUnicos = {};

    for (let i = 0; i < valoresCapturadosVentaTemp.length; i++) {
      let codigoproducto = valoresCapturadosVentaTemp[i]["id_producto_insumo"];
      let id_proveedor = valoresCapturadosVentaTemp[i]["id_proveedor"];
      let nombreproducto = valoresCapturadosVentaTemp[i]["nombreproducto"];

      let claveUnica = codigoproducto + "_" + id_proveedor;
      if (paresUnicos[claveUnica]) {
        Swal.fire({
          title: "Se encontro duplicado de proveedor y producto",
          text: "El producto duplicado " + nombreproducto,
          icon: "info",
          confirmButtonText: "Aceptar",
        });

        return;
      } else {
        paresUnicos[claveUnica] = true;
      }
    }
    // console.log(valoresCapturadosVentaTemp);
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
    const dataimagenes = [];
    const codigoproveedorimagenes = [];

    $("#tablaimagenes tr").each(function () {
      const filaimagen = $(this);
      const fileInput = filaimagen.find("td:eq(2) input[type=file]")[0];
      const codigoproveedor = filaimagen.find("td:eq(5) input").val();

      if (fileInput && fileInput.files.length > 0) {
        const file = fileInput.files[0];
        dataimagenes.push(file);
        codigoproveedorimagenes.push({ codigoproveedor });
      }
    });
    // const accionverificar="versihay";

    const formData = new FormData();
    formData.append("accion", "insertarordencompraitemtemporal");
    formData.append("idRequerimiento", taskcodrequhiddenvalidar);
    // formData.append("codpersonal", codpersonal);

    for (let j = 0; j < valoresCapturadosVentaTemp.length; j++) {
      const objetoInsumotemp = valoresCapturadosVentaTemp[j];
      const objetoInsumoStringTemp = JSON.stringify(objetoInsumotemp);
      formData.append("valorcapturado[]", objetoInsumoStringTemp);
    }

    for (let i = 0; i < dataimagenes.length; i++) {
      formData.append("file[]", dataimagenes[i]);
    }
    for (let l = 0; l < codigoproveedorimagenes.length; l++) {
      const objetoproveedor = codigoproveedorimagenes[l];
      const proveedor = JSON.stringify(objetoproveedor);
      formData.append("codigoproveedorimagenes[]", proveedor);
    }

    for (let r = 0; r < valoresdeinsumos.length; r++) {
      const objetotemp = valoresdeinsumos[r];
      const Temp = JSON.stringify(objetotemp);
      formData.append("valoresdeinsumos[]", Temp);
    }

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: async function (response) {
        let respuesta = JSON.parse(response);
        // console.log(respuesta);
        // if (!Array.isArray(respuesta)) {
        if (respuesta.estado === "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos estan en el proceso.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              tablainsumorequerido.empty();
              tablainsumos.empty();
              tablatotal.empty();
              $("#tablaimagenes").empty();
              mostrarPendientes();
              $("body").off("change", ".fecha-entrega");
            }
          });
          return;
        } else if (respuesta.estado === "error") {
          Swal.fire({
            title: "¡Error al guradar!",
            text: "Los datos son incorrectos",
            icon: "error",
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
        }
        for (const element of respuesta) {
          if (element.estado == "errorcantidad") {
            await Swal.fire({
              text:
                "En el producto " +
                element.nombreproducto +
                " necesita poner la suma de cantidades mayor a " +
                element.cantidad,
              icon: "info",
              confirmButtonText: "Aceptar",
            });
          }
        }
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
      error: function (error) {
        console.log("ERROR " + error);
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
