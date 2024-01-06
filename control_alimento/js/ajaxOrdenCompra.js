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

  cargarOrdenCompraAprobada();

  //----------------------------------------------------------------//
  $("#selectproveedor").select2({
    dropdownParent: $("#mostrarproveedor .modal-body"),
  });
  /*---------Cargar la orden de compra aprobada------------------- */
  function cargarOrdenCompraAprobada() {
    let oficina = $("#vroficina").val();
    let codigopersonal = $("#codpersonal").val();

    const accion = "mostrarordencompraaprobada";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        oficina: oficina,
        codigopersonal: codigopersonal,
      },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          // console.log(tasks);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr id_orden_compra_aprobada='${task.COD_ORDEN_COMPRA}'>
                            <td data-titulo='CODIGO REQUERIMIENTO' style='text-align: center;'>${task.COD_REQUERIMIENTO}</td>
                            <td data-titulo='FECHA' style='text-align: center;'>${task.FECHA}</td>
                             <td data-titulo='PERSONAL' style='text-align: center;'>${task.NOM_PERSONAL1}</td>

                            <td style="text-align:center;"><button class="custom-icon"  id="clickcompraaprobada"><i class="icon-check"></i></button></td>
                          </tr>`;
          });
          $("#tablamostarcomprasaprobadas").html(template);
        } else {
          $("#tablamostarcomprasaprobadas").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
  /*--------------------------------------------------------------*/

  /* -----------------------Bloquea las fechas marcadas------------------------- */

  let fechaActual = new Date().toISOString().split("T")[0];
  $("#fecha").val(fechaActual);
  $("#fecha").attr("min", fechaActual);
  $("#fecha").on("blur", function () {
    var fechaemision = $(this).val();

    if (fechaemision < fechaActual) {
      Swal.fire({
        icon: "error",
        title: "Error de fecha ingresada",
        allowOutsideClick: false,
        text: "La fecha es menor a la fecha actual.",
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById("fecha").value = fechaActual;
        }
      });
    }
  });

  /*--------------------------------------------------------------------------- */

  /*-----------CLICK DE PROVEEDOR Y PONER INPUTS------------------*/
  $("#selectproveedor").change((e) => {
    e.preventDefault();
    const idprovee = $("#selectproveedor").val();

    const accion = "mostrarlistaproveedores";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, idprovee: idprovee },
      success: function (response) {
        if (isJSON(response)) {
          let task = JSON.parse(response);
          $("#codigoproveedor").val(task[0].COD_PROVEEDOR);
          $("#nombreproveedor").val(task[0].NOM_PROVEEDOR);
          $("#direccionproveedor").val(task[0].DIR_PROVEEDOR);
          $("#ruc").val(task[0].RUC_PROVEEDOR);
          $("#dniproveedor").val(task[0].DNI_PROVEEDOR);
          $("#selectproveedor").val("none").trigger("change");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos :", error);
      },
    });
  });
  /*--------------------------------------------------------------*/
  /*-------mostrar campos de orden de compra--------------------*/
  $(document).on("click", "#clickcompraaprobada", (e) => {
    e.preventDefault();

    let personal = $("#tmostrarordencompraaprobado tr:eq(1) td:eq(2)").text();
    let idcompraaprobada = $("#tmostrarordencompraaprobado tr:eq(1)").attr(
      "id_orden_compra_aprobada"
    );

    let codigorequerimiento = $(
      "#tmostrarordencompraaprobado tr:eq(1) td:eq(0)"
    ).text();

    $("#idrequerimientotemp").val(codigorequerimiento);
    $("#personal").val(personal);
    mostrarinsumos(idcompraaprobada);
    Swal.fire({
      icon: "success",
      title: "Correcto",
      text: "Se añadio correctamente.",
    });
  });
  /*---------------------------------------------------------- */
  /*-------------------- Guardar datos modal----------------- */
  // $("#ponerproveedor").on("click", (e) => {
  //   e.preventDefault();
  //   let selectproveedor = $("#codigoproveedor").val();
  //   let nombreProveedor = $("#nombreproveedor").val();
  //   let direccionProveedor = $("#direccionproveedor").val();
  //   let ruc = $("#ruc").val();
  //   let dniProveedor = $("#dniproveedor").val();

  //   $("#codproveedor").val(selectproveedor);
  //   $("#proveedor").val(nombreProveedor);
  //   $("#proveedor").val(nombreProveedor);
  //   $("#direccion").val(direccionProveedor);
  //   $("#ruc_principal").val(ruc);
  //   $("#dni_principal").val(dniProveedor);

  //   if (!nombreProveedor) {
  //     Swal.fire({
  //       icon: "info",
  //       title: "Campo vacio",
  //       text: "Ingrese un nombre de proveedor.",
  //     });
  //     return;
  //   }
  //   if (!ruc && !dniProveedor) {
  //     Swal.fire({
  //       icon: "info",
  //       title: "Campo vacio",
  //       text: "Ingrese RUC o DNI.",
  //     });
  //     return;
  //   }
  //   if (dniProveedor && dniProveedor.length < 8) {
  //     Swal.fire({
  //       icon: "info",
  //       title: "Cantidad errónea",
  //       text: "Ingrese DNI mínimo 8 números.",
  //     });
  //     return;
  //   }

  //   if (ruc.length < 11) {
  //     Swal.fire({
  //       icon: "info",
  //       title: "Cantidad erronea",
  //       text: "Ingrese RUC minimo 11 numeros.",
  //     });
  //     return;
  //   }
  //   $("#mostrarproveedor").on("hidden.bs.modal", function () {
  //     $("body").css("overflow", "auto");
  //   });
  //   $("#mostrarproveedor").modal("hide");
  //   $(".modal-backdrop").remove();
  // });
  $("#ponerproveedor").on("click", (e) => {
    e.preventDefault();

    // Find the closest row to the clicked button
    let row = $(e.target).closest("tr");

    let selectproveedor = row.find("#codproveedor").val();
    let nombreProveedor = row.find("#proveedor").val();
    let direccionProveedor = row.find("#direccion").val();
    let ruc = row.find("#ruc_principal").val();
    let dniProveedor = row.find("#dni_principal").val();

    // Update the values in the current row
    row.find("#codproveedor").val(selectproveedor);
    row.find("#proveedor").val(nombreProveedor);
    row.find("#direccion").val(direccionProveedor);
    row.find("#ruc_principal").val(ruc);
    row.find("#dni_principal").val(dniProveedor);
    if (!nombreProveedor) {
      Swal.fire({
        icon: "info",
        title: "Campo vacio",
        text: "Ingrese un nombre de proveedor.",
      });
      return;
    }
    if (!ruc && !dniProveedor) {
      Swal.fire({
        icon: "info",
        title: "Campo vacio",
        text: "Ingrese RUC o DNI.",
      });
      return;
    }
    if (dniProveedor && dniProveedor.length < 8) {
      Swal.fire({
        icon: "info",
        title: "Cantidad errónea",
        text: "Ingrese DNI mínimo 8 números.",
      });
      return;
    }

    if (ruc.length < 11) {
      Swal.fire({
        icon: "info",
        title: "Cantidad erronea",
        text: "Ingrese RUC minimo 11 numeros.",
      });
      return;
    }
    $("#mostrarproveedor").on("hidden.bs.modal", function () {
      $("body").css("overflow", "auto");
    });
    $("#mostrarproveedor").modal("hide");
    $(".modal-backdrop").remove();
  });

  /*-------------------------------------------------------- */
  /*--------- mostrar insumos comprar ----------------------*/
  function mostrarinsumos(idcompraaprobada) {
    const accion = "mostrarinsumoscompras";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, idcompraaprobada: idcompraaprobada },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr id_orden_compra_item='${task.COD_ORDEN_COMPRA}'>
                            <td data-titulo='MATERIAL' codigo_producto='${task.COD_PRODUCTO}' style='text-align: center;'>${task.DES_PRODUCTO}</td>
                            <td data-titulo='CAN.COMPRA' style='text-align: center;'>${task.CANTIDAD_MINIMA}</td>
                            <td data-titulo='STOCK' style='text-align: center;'>${task.STOCK_ACTUAL}</td>
                             <td data-titulo='PROVEEDOR' style='text-align: center;'>
                             <input type="hidden" id="codproveedor" value="${task.COD_PROVEEDOR}" class="form-control">
                             <input type="hidden" id="direccion" class="form-control">
                             <input type="hidden" id="ruc_principal" class="form-control">
                             <input type="hidden" id="dni_principal" class="form-control">
                             <input type="text" id="proveedor" class="form-control" value="${task.NOM_PROVEEDOR}" disabled>
                             <button type='button' class="custom-icon btn-open-modal" data-bs-toggle="modal" data-bs-target="#mostrarproveedor"><i class="icon-add-user"></i></button>
                             </td>
                             <td data-titulo='F.PAGO' style='text-align: center;'>
                             <select id="selectformapago" class="form-select" aria-label="Default select example">
                             <option value="E" selected>EFECTIVO</option>
                             <option value="D">DEPOSITO</option>
                             </select>
                             </td>
                             <td data-titulo='IMAGEN'><button id='imagensum' class="btn btn-success" disabled>Añadir imagen</button></td>
                            <td data-titulo='SELECCIONAR' style='text-align: center;'><input class="form-check-input" type="checkbox" value="" id="checkbox" ></td>
                            </tr>`;
          });
          $("#tablainsumoscomprar").html(template);
        } else {
          $("#tablainsumoscomprar").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
  /*------------------------------------------------------ */

  /*------- Check mostrar los añadidos en tabla detalle----- */
  $(document).on("click", "#checkbox", (e) => {
    let filaActual = $(e.target).closest("tr");
    // let producto = filaActual.find("td:eq(0)").text();
    let codproducto = filaActual.find("td:eq(0)").attr("codigo_producto");
    let cantidad = filaActual.find("td:eq(1)").text();
    let codProveedor = filaActual.find("#codproveedor").val();
    let selectformapago = filaActual.find("#selectformapago").val();
    let codproveedor = filaActual.find("#codproveedor").val();
    let rucprovedores = filaActual.find("#ruc_principal").val();

    // let tisumos = $("#tinsumoscomprarprecio tbody");

    // if (e.target.checked) {
    //   tisumos.append(
    //     "<tr><td data-titulo='MATERIAL' codigo_prod='" +
    //       codproducto +
    //       "' style='text-align:center;'>" +
    //       producto +
    //       "</td><td data-titulo='CANTIDAD' style='text-align:center;'>" +
    //       cantidad +
    //       "</td><td data-titulo='PRECIO'><input type='number' /></td></tr>"
    //   );
    // } else {
    //   tisumos.find("tr").each(function () {
    //     if ($(this).find("td:eq(0)").attr("codigo_prod") === codproducto) {
    //       $(this).remove();
    //     }
    //   });
    // }
    const accion = "mostrarprecioporcantidad";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        codproducto: codproducto,
        cantidad: cantidad,
        codProveedor: codProveedor,
      },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          let tisumos = $("#tinsumoscomprarprecio tbody");
          if (e.target.checked) {
            let newRow = ``;
            tasks.forEach((task) => {
              let moneda = task.TIPO_MONEDA;
              if (moneda == "S") {
                moneda = "SOLES";
              } else {
                moneda = "DOLARES";
              }
              newRow = `<tr>
              <td data-titulo="MATERIAL" style="text-align:center;" codigo_prod="${task.COD_PRODUCTO}">${task.DES_PRODUCTO}</td>
              <td data-titulo="CANTIDAD COMPRA" style="text-align:center;">${cantidad}</td>
              <td data-titulo="PRECIO MINIMO" style="text-align:center;">${task.PRECIO_PRODUCTO}</td>
              <td data-titulo="PRECIO TOTAL" style="text-align:center;">${task.PRECIO_TOTAL}</td>
              <td data-titulo="MONEDA" style="text-align:center;" id_moneda="${task.TIPO_MONEDA}">${moneda}</td>
              <td><input id="formapago" type="hidden" value="${selectformapago}"></td>
              <td><input id="codigoproveedor" type="hidden" value="${codproveedor}"></td>
              <td><input id="rucpro" type="text" value="${rucprovedores}"></td>
              </tr>`;
            });
            $("#tablainsumoscomprarprecio").append(newRow);
          } else {
            tasks.forEach((task) => {
              tisumos.find("tr").each(function () {
                if (
                  $(this).find("td:eq(0)").attr("codigo_prod") ===
                  task.COD_PRODUCTO
                ) {
                  $(this).remove();
                }
              });
            });
          }
        } else {
          Swal.fire({
            icon: "info",
            text: "Por favor, cambie de proveedor o añada proveedor con su producto.",
          });
        }
      },
    });
  });

  /*------------------------------------------------------- */

  /*--------- insertar orden de compra de los insumos con precio-----*/

  $("#insertarOrdenCompraInsumos").on("click", (e) => {
    // $("#formulariocompraordend").submit((e) => {
    e.preventDefault();

    let fecha = $("#fecha").val();
    let empresa = $("#selectempresa").val();
    let personal = $("#personal").val();
    let personalcod = $("#codpersonal").val();
    let oficina = $("#selectoficina").val();
    let proveedor = $("#proveedor").val();
    let proveedordireccion = $("#direccion").val();
    let proveedorruc = $("#ruc_principal").val();
    let proveedordni = $("#dni_principal").val();
    let formapago = $("#selectformapago").val();
    let moneda = $("#selectmoneda").val();
    let observacion = $("#observacionorden").val();
    let idcompraaprobada = $("#tmostrarordencompraaprobado tr:eq(1)").attr(
      "id_orden_compra_aprobada"
    );

    const datosSeleccionadosInsumos = [];
    $("#tablainsumoscomprarprecio tr").each(function () {
      const fila = $(this);

      const codproducto = fila.find("td:eq(0)").attr("codigo_prod");
      const desproducto = fila.find("td:eq(0)").text();
      const cantidad = fila.find("td:eq(1)").text();
      const precio = fila.find("td:eq(3)").text();
      const id_moneda = fila.find("td:eq(4)").attr("id_moneda");
      const f_pago = fila.find("td:eq(5) input").val();
      const codigoproveedorselect = fila.find("td:eq(6) input").val();
      const datosFila = {
        codproducto: codproducto,
        // desproducto: desproducto,
        cantidad: cantidad,
        precio: precio,
        id_moneda: id_moneda,
        f_pago: f_pago,
        codigoproveedorselect: codigoproveedorselect,
      };
      datosSeleccionadosInsumos.push(datosFila);
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
    // if (!personal) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "Dar check en listado de documentos aprobados.",
    //   });
    //   return;
    // }
    // if (!$("input[type=checkbox]:checked").length) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "Por favor, marca al menos un producto antes de guardar.",
    //   });
    //   return;
    // }

    $("#tablainsumoscomprar tr").each(function () {
      const filacheck = $(this);
      const checkbox = filacheck.find("td:eq(6) input:checkbox");

      // Verificar si el checkbox está marcado
      if (!checkbox.prop("checked")) {
        Swal.fire({
          icon: "info",
          text: "Por favor, marca todos los productos antes de guardar.",
        });
        return false;
      }
    });
    // if (!fecha) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "Insertar una fecha.",
    //   });
    //   return;
    // }
    // if (!empresa) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "Seleccione una empresa",
    //   });
    //   return;
    // }
    // if (!oficina) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "Seleccione una oficina",
    //   });
    //   return;
    // }
    // if (!proveedor) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "Añada un proveedor.",
    //   });
    //   return;
    // }
    // if (!formapago) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "Seleccione una forma de pago.",
    //   });
    //   return;
    // }
    // if (!moneda) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "Seleccione tipo de moneda.",
    //   });
    //   return;
    // }
    // if (!observacion) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "Escriba una observación.",
    //   });
    //   return;
    // }

    // var inputVacioEncontrado = false;
    // $("#tinsumoscomprarprecio tbody input").each(function () {
    //   if ($(this).val() === "") {
    //     inputVacioEncontrado = true;
    //   }
    // });
    // if (inputVacioEncontrado) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "Debes ingresar el precio antes de guardar la orden de compra.",
    //   });
    //   return;
    // }

    // var inputfilevacio = false;
    // var tablaVacia = true;
    // $("#tbimagenes tbody input").each(function () {
    //   if ($(this).val() === "") {
    //     inputfilevacio = true;
    //   }
    // });
    // if (formapago === "D" && $("#tbimagenes tbody tr").length > 0) {
    //   tablaVacia = false;
    // }

    // // Mostrar la alerta solo si formapago es "D" y la tabla está vacía
    // if (formapago === "D" && tablaVacia) {
    //   Swal.fire({
    //     icon: "info",
    //     text: "La tabla está vacía. Debes añadir al menos una imagen.",
    //   });
    // } else if (inputfilevacio) {
    //   // Mostrar la alerta si hay algún campo de archivo vacío
    //   Swal.fire({
    //     icon: "info",
    //     text: "Debes seleccionar una imagen.",
    //   });
    // }
    // const accion = "guardarinsumoscompras";
    const formData = new FormData();
    formData.append("accion", "guardarinsumoscompras");
    formData.append("fecha", $("#fecha").val());
    formData.append("empresa", $("#selectempresa").val());
    formData.append(" personal", $("#personal").val());
    formData.append("personalcod", $("#codpersonal").val());
    formData.append("oficina", $("#selectoficina").val());
    formData.append("proveedor", $("#proveedor").val());
    formData.append("proveedordireccion", $("#direccion").val());
    formData.append("proveedorruc", $("#ruc_principal").val());
    formData.append("proveedordni", $("#dni_principal").val());
    formData.append("formapago", $("#selectformapago").val());
    formData.append("moneda", $("#selectmoneda").val());
    formData.append("observacion", $("#observacionorden").val());
    formData.append(
      "idcompraaprobada",
      $("#tmostrarordencompraaprobado tr:eq(1)").attr(
        "id_orden_compra_aprobada"
      )
    );
    for (let j = 0; j < datosSeleccionadosInsumos.length; j++) {
      const objetoInsumo = datosSeleccionadosInsumos[j];
      const objetoInsumoString = JSON.stringify(objetoInsumo);
      formData.append("datosSeleccionadosInsumos[]", objetoInsumoString);
    }

    for (let i = 0; i < dataimagenes.length; i++) {
      formData.append("file[]", dataimagenes[i]);
    }
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: function (response) {
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            allowOutsideClick: false,
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#fecha").val(fechaActual);
              $("#selectempresa").val("00003").trigger("change");
              $("#personal").val("");
              $("#selectoficina").val("00026").trigger("change");
              $("#proveedor").val("");
              $("#direccion").val("");
              $("#ruc_principal").val("");
              $("#dni_principal").val("");
              $("#observacionorden").val("");
              $("#selectformapago").val("E").trigger("change");
              $("#selectmoneda").val("S").trigger("change");
              $("#tablainsumoscomprar").empty();
              $("#tablaimagenes").empty();
              $("#imagensum").prop("disabled", true);

              $("#nombreproveedor").val("");
              $("#direccionproveedor").val("");
              $("#ruc").val("");
              $("#dniproveedor").val("");
              $("#tablainsumoscomprarprecio").empty();
              cargarOrdenCompraAprobada();
            }
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  /*--------------------------------------------------------------- */
  /*--------- Cuando doy click en deposito me activa ------------- */
  $("body").on("change", "#selectformapago", function () {
    // Obtén el valor seleccionado
    var formaPago = $(this).val();

    // Obtén el botón de imagen dentro de la fila actual
    var fila = $(this).closest("tr");
    var botonImagen = fila.find("#imagensum");

    // Verifica la forma de pago y habilita/deshabilita el botón de imagen
    if (formaPago === "D") {
      // Si la forma de pago es DEPOSITO, habilita el botón de imagen
      botonImagen.prop("disabled", false);
    } else {
      // En otros casos, deshabilita el botón de imagen y realiza cualquier otra lógica necesaria
      botonImagen.prop("disabled", true);
      // También puedes hacer otras cosas aquí, como vaciar un contenedor de imágenes
      fila.find("#tablaimagenes").empty();
    }
  });
  /*------------------------------------------------------------- */

  /*------------ Cuando doy click en el boton añadir una imagen ----- */
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

  // $("#imagensum").click((e) => {
  $(document).on("click", "#imagensum", function (e) {
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

    var nuevaFila = $("<tr id='filaTabla'>").append(
      $("<td>").addClass("text-center").append(imagenBotonDelete),
      $("<td>").addClass("text-center").append(imagenBoton),
      $("<td>")
        .addClass("text-center archivosubido")
        .append("<img src='" + imagenPredeterminadaURL + "' alt='imgcompra'>")
    );

    $("#tablaimagenes").append(nuevaFila);
  });

  /*---------------------------------------------------------------- */
  /*------ Al darle click en el tacho de la iamgen eliminara fila */
  $(document).on("click", ".delete", function () {
    var filaAEliminar = $(this).closest("#filaTabla");
    filaAEliminar.remove();
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
