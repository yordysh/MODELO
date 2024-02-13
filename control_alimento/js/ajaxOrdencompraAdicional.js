$(function () {
  //===== Prealoder

  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //----------------------------------------------------------------//

  cargarordencompraadicional();
  /*------------------Cargar los datos---------------------------- */
  function cargarordencompraadicional() {
    const accion = "mostrarordencompraadicional";
    const buscar = "";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, buscar: buscar },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr codigorequerimientototal="${
              task.COD_REQUERIMIENTO_TEMP
            }" codigoordencompra="${task.COD_ORDEN_COMPRA}">
              <td data-titulo="PROVEEDOR"  style="text-align:center;" codigo_proveedor='${
                task.COD_PROVEEDOR_TEMP
              }'>${task.NOM_PROVEEDOR_TEMP}</td>
                            <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${
                              task.COD_PRODUCTO_TEMP
                            }'>${task.DES_PRODUCTO_TEMP}</td>
                            <td data-titulo="CANTIDAD RECIBIDA"  style="text-align:center;"><input id="cantidadacomprar" value="${parseFloat(
                              task.CANTIDAD_LLEGADA
                            ).toFixed(2)}" disabled/></td>
                            <td data-titulo="CANTIDAD COMPRADA"  style="text-align:center;">${parseFloat(
                              task.CANTIDAD_INSUMO_ENVASE
                            ).toFixed(2)}</td>
                            <td data-titulo="CANTIDAD POR RECIBIR"  style="text-align:center;">${parseFloat(
                              task.CANTIDAD_INSUMO_ENVASE -
                                task.CANTIDAD_LLEGADA
                            ).toFixed(2)}</td>
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
                          </td>
                          </tr>`;
          });
          $("#tablainsumosenvasesadicional").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
  /*---------------------------------------------------------- */
  //------------- Busqueda de producto orden compra adicional ----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      const accion = "mostrarordencompraadicional";
      const buscar = $("#search").val();
      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscar: buscar },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);
            let template = ``;
            tasks.forEach((task) => {
              template += `<tr codigorequerimientototal="${
                task.COD_REQUERIMIENTO_TEMP
              }">
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
                                <td data-titulo='IMAGEN'><button id='imagensum' class="btn btn-success" disabled>Añadir imagen</button></td>
                                <td data-titulo="PRECIO" id_proveedor='${
                                  task.COD_PROVEEDOR_TEMP
                                }' style="text-align:center;">${parseFloat(
                task.PRECIO_MINIMO
              ).toFixed(2)}</td>
     
                              <td data-titulo="OTRAS CANTIDADES">
                              <button id='modalotrascantidades' class="btn btn-success"><i class="icon-circle-with-plus"></i></button>
                              </td>
                              </tr>`;
            });
            $("#tablainsumosenvasesadicional").html(template);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos de la tabla:", error);
        },
      });
    } else {
      cargarordencompraadicional();
    }
  });
  //-------------------------------------------------------------------------//

  /*-------------------------- Dar click el boton y añade fila-------- */
  $(document).on("click", "#modalotrascantidades", function () {
    var currentRow = $(this).closest("tr");
    var codigoRequerimiento = currentRow.attr("codigorequerimientototal");
    var desProducto = currentRow.find('td[data-titulo="PRODUCTO"]').text();
    var cancomprada = currentRow.find("td:eq(3)").text();
    var canrecibir = currentRow.find("td:eq(4)").text();
    var codProducto = currentRow
      .find('td[data-titulo="PRODUCTO"]')
      .attr("id_producto");
    var comprarcantidadexacta = currentRow
      .find('td[data-titulo="CANTIDAD POR COMPRA"]')
      .attr("valor_comprar_cantidad");

    const fechaahora = new Date().toISOString().split("T")[0];

    var newRow = `
        <tr codigorequerimientototal=${codigoRequerimiento}>
      
        <td data-titulo="PROVEEDOR" style="text-align:center;"> 
        <select id="selectproveedorescanmin" class="form-select">
        <option value="none" selected disabled>Seleccione proveedor</option>
        </select>
        </td>
        <td data-titulo="PRODUCTO"  style="text-align:center;" id_producto='${codProducto}'>${desProducto}</td>
        <td data-titulo="CANTIDAD POR COMPRA" cantidadcomprarexacto='${comprarcantidadexacta}'><input id="cantidadacomprar"/></td>
        <td cancomprada='${cancomprada}'></td>
        <td canrecibir='${canrecibir}'></td>
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

  /*--------------Verifica la cantidad y precio total al cambiar------ */
  $(document).on("keyup", "#cantidadacomprar", function () {
    let filaescr = $(this).closest("tr");
    var valorcan = filaescr.find("td:eq(2) input").val();
    var valorproveedor = filaescr
      .find('td[data-titulo="PROVEEDOR"]')
      .attr("codigo_proveedor");

    var valorproducto = filaescr
      .find('td[data-titulo="PRODUCTO"]')
      .attr("id_producto");

    var codigoproveedor = filaescr.find("td:eq(0) select").val();

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
    // $("#tablainsumosenvasesadicional tr").each(function () {
    //   let proveedorcantidad = $(this).find("td:eq(0)").attr("codigo_proveedor");
    //   let producto = $(this).find("td:eq(1)").attr("id_producto");
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

          let valorcambiadoprecio = filaescr
            .find("td:eq(5)")
            .text(task[0].PRECIO_PAGAR);

          let valorpreciomin = filaescr
            .find("td:eq(9)")
            .text(task[0].PRECIO_PRODUCTO);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  });
  /*------------------------------------------------------------------ */

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
    var codigorequerimiento = fila.attr("codigorequerimientototal");
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
      var codigoproveedorinput = $("<input>")
        .attr("type", "hidden")
        .attr("id", "idproveedor")
        .val(codigoProveedor1);
    }
    var codigorequer = $("<input>")
      .attr("type", "hidden")
      .attr("id", "codigorequerimiento")
      .val(codigorequerimiento);

    var nuevaFila = $("<tr id='filaTabla'>").append(
      $("<td>").addClass("text-center").append(imagenBotonDelete),
      $("<td>").addClass("text-center").append(codigoproveedornombre),
      $("<td>").addClass("text-center").append(imagenBoton),
      $("<td>")
        .addClass("text-center archivosubido")
        .append("<img src='" + imagenPredeterminadaURL + "' alt='imgcompra'>"),
      $("<td>").addClass("text-center").append(codigo),
      $("<td>").addClass("text-center").append(codigoproveedorinput),
      $("<td>").addClass("text-center").append(codigorequer)
    );

    $("#tablaimagenes").append(nuevaFila);
  });

  /*------ Al darle click en el tacho de la iamgen eliminara fila */
  $(document).on("click", ".delete", function () {
    var filaAEliminar = $(this).closest("#filaTabla");
    filaAEliminar.remove();
  });
  /*------------------------------------------------------------ */

  /*------------------- Proceso de la orden de compra------------ */
  $("#guardarordencompraadional").click((e) => {
    e.preventDefault();
    let valoresCapturadosAdicional = [];

    let tablatotal = $("#tablainsumosenvasesadicional");

    let codpersonal = $("#codpersonal").val();
    let fechaentregaalert = [];
    let mostrarAlerta = false;
    $("#tablainsumosenvasesadicional tr").each(function () {
      let canrecibir = $(this).find("td:eq(4)").attr("canrecibir");
      let cantidad_producto_insumo = $(this).find("td:eq(2) input").val();

      if (parseFloat(cantidad_producto_insumo) < parseFloat(canrecibir)) {
        mostrarAlerta = true;
        return false;
      }
    });
    if (mostrarAlerta) {
      Swal.fire({
        title: "¡Error!",
        text: "Añadir la cantidad mayor o igual a la cantidad recibir",
        icon: "info",
        confirmButtonText: "Aceptar",
      });
      return;
    }
    $("#tablainsumosenvasesadicional tr").each(function () {
      let codigorequerimiento = $(this).attr("codigorequerimientototal");
      let codigoorden = $(this).attr("codigoordencompra");
      let id_proveedor;
      let codigoordencompra;
      let proveedor = $(this).find("td:eq(0)").attr("codigo_proveedor");

      if (proveedor != undefined) {
        id_proveedor = proveedor;
      } else {
        id_proveedor = $(this).find("td:eq(0) select").val();
      }
      if (codigoorden != undefined) {
        codigoordencompra = codigoorden;
      } else {
        codigoordencompra = null;
      }

      let id_producto_insumo = $(this).find("td:eq(1)").attr("id_producto");
      let nombreproducto = $(this).find("td:eq(1)").text();
      let cantidad_producto_insumo = $(this).find("td:eq(2) input").val();
      let monto = $(this).find("td:eq(5)").text();
      let fechaentrega = $(this).find("td:eq(6) input").val();
      let formapago = $(this).find("td:eq(7)").find("select").val();
      let preciomin = $(this).find("td:eq(9)").text();

      let canrecibir = $(this).find("td:eq(4)").text();

      fechaentregaalert.push(fechaentrega);
      valoresCapturadosAdicional.push({
        codigorequerimiento: codigorequerimiento,
        codigoordencompra: codigoordencompra,
        id_proveedor: id_proveedor,
        id_producto_insumo: id_producto_insumo,
        nombreproducto: nombreproducto,
        cantidad_producto_insumo: cantidad_producto_insumo,
        monto: monto,
        formapago: formapago,
        fechaentrega: fechaentrega,
        preciomin: preciomin,
        canrecibir: canrecibir,
      });
    });

    // let paresUnicos = {};

    // for (let i = 0; i < valoresCapturadosAdicional.length; i++) {
    //   let codigoproducto = valoresCapturadosAdicional[i]["id_producto_insumo"];
    //   let id_proveedor = valoresCapturadosAdicional[i]["id_proveedor"];
    //   let nombreproducto = valoresCapturadosAdicional[i]["nombreproducto"];

    //   let claveUnica = codigoproducto + "_" + id_proveedor;
    //   if (paresUnicos[claveUnica]) {
    //     Swal.fire({
    //       title: "Se encontro duplicado de proveedor y producto",
    //       text: "El producto duplicado " + nombreproducto,
    //       icon: "info",
    //       confirmButtonText: "Aceptar",
    //     });

    //     return;
    //   } else {
    //     paresUnicos[claveUnica] = true;
    //   }
    // }

    // if (valoresCapturadosAdicional.length === 0) {
    //   Swal.fire({
    //     title: "¡Error!",
    //     text: "No hay pendientes",
    //     icon: "info",
    //     confirmButtonText: "Aceptar",
    //   });
    //   return;
    // }

    for (let i = 0; i < fechaentregaalert.length; i++) {
      if (fechaentregaalert[i] === "") {
        Swal.fire({
          title: "¡Error!",
          text: "Añadir una fecha de entrega",
          icon: "info",
          confirmButtonText: "Aceptar",
        });
        return;
      }
    }
    const dataimagenes = [];
    const codigoproveedorimagenes = [];

    $("#tablaimagenes tr").each(function () {
      const filaimagen = $(this);
      const fileInput = filaimagen.find("td:eq(2) input[type=file]")[0];
      const codigoproveedor = filaimagen.find("td:eq(5) input").val();
      const codigorequerimiento = filaimagen.find("td:eq(6) input").val();
      if (fileInput && fileInput.files.length > 0) {
        const file = fileInput.files[0];
        dataimagenes.push(file);
        codigoproveedorimagenes.push({
          codigoproveedor: codigoproveedor,
          codigorequerimiento: codigorequerimiento,
        });
      }
    });

    const formData = new FormData();
    formData.append("accion", "insertarordencompraitemadicional");

    for (let j = 0; j < valoresCapturadosAdicional.length; j++) {
      const objetoInsumotemp = valoresCapturadosAdicional[j];
      const objetoInsumoStringTemp = JSON.stringify(objetoInsumotemp);
      formData.append("valorcapturadoadicional[]", objetoInsumoStringTemp);
    }

    for (let i = 0; i < dataimagenes.length; i++) {
      formData.append("file[]", dataimagenes[i]);
    }
    for (let l = 0; l < codigoproveedorimagenes.length; l++) {
      const objetoproveedor = codigoproveedorimagenes[l];
      const proveedor = JSON.stringify(objetoproveedor);
      formData.append("codigoproveedorimagenes[]", proveedor);
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
              cargarordencompraadicional();
              $("#tablaimagenes").empty();
            }
          });
        } else if (respuesta.estado === "error") {
          Swal.fire({
            title: "¡Error al guradar!",
            text: "Los datos son incorrectos",
            icon: "error",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              cargarordencompraadicional();
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
