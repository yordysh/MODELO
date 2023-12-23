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
  $("#ponerproveedor").on("click", (e) => {
    e.preventDefault();

    let nombreProveedor = $("#nombreproveedor").val();
    let direccionProveedor = $("#direccionproveedor").val();
    let ruc = $("#ruc").val();
    let dniProveedor = $("#dniproveedor").val();

    $("#proveedor").val(nombreProveedor);
    $("#direccion").val(direccionProveedor);
    $("#ruc_principal").val(ruc);
    $("#dni_principal").val(dniProveedor);

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
                            <td data-titulo='CANTIDAD' style='text-align: center;'>${task.CANTIDAD_MINIMA}</td>
                            <!-- <td data-titulo='PRECIO' style='text-align: center;'><input type='number'/></td> -->
                            <td data-titulo='SELECCIONAR' style='text-align: center;'><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" ></td>
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
  $(document).on("click", "#flexCheckDefault", (e) => {
    let filaActual = $(e.target).closest("tr");
    let producto = filaActual.find("td:eq(0)").text();
    let codproducto = filaActual.find("td:eq(0)").attr("codigo_producto");
    let cantidad = filaActual.find("td:eq(1)").text();

    let tisumos = $("#tinsumoscomprarprecio tbody");

    if (e.target.checked) {
      tisumos.append(
        "<tr><td data-titulo='MATERIAL' codigo_prod='" +
          codproducto +
          "' style='text-align:center;'>" +
          producto +
          "</td><td data-titulo='CANTIDAD' style='text-align:center;'>" +
          cantidad +
          "</td><td data-titulo='PRECIO'><input type='number' /></td></tr>"
      );
    } else {
      tisumos.find("tr").each(function () {
        if ($(this).find("td:eq(0)").attr("codigo_prod") === codproducto) {
          $(this).remove();
        }
      });
    }
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
      const precio = fila.find("td:eq(2) input").val();
      const datosFila = {
        codproducto: codproducto,
        // desproducto: desproducto,
        cantidad: cantidad,
        precio: precio,
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
    console.log(dataimagenes);
    if (!personal) {
      Swal.fire({
        icon: "info",
        text: "Dar check en listado de documentos aprobados.",
      });
      return;
    }
    if (!$("input[type=checkbox]:checked").length) {
      Swal.fire({
        icon: "info",
        text: "Por favor, marca al menos un producto antes de guardar.",
      });
      return;
    }
    if (!fecha) {
      Swal.fire({
        icon: "info",
        text: "Insertar una fecha.",
      });
      return;
    }
    if (!empresa) {
      Swal.fire({
        icon: "info",
        text: "Seleccione una empresa",
      });
      return;
    }
    if (!oficina) {
      Swal.fire({
        icon: "info",
        text: "Seleccione una oficina",
      });
      return;
    }
    if (!proveedor) {
      Swal.fire({
        icon: "info",
        text: "Añada un proveedor.",
      });
      return;
    }
    if (!formapago) {
      Swal.fire({
        icon: "info",
        text: "Seleccione una forma de pago.",
      });
      return;
    }
    if (!moneda) {
      Swal.fire({
        icon: "info",
        text: "Seleccione tipo de moneda.",
      });
      return;
    }
    if (!observacion) {
      Swal.fire({
        icon: "info",
        text: "Escriba una observación.",
      });
      return;
    }

    var inputVacioEncontrado = false;
    $("#tinsumoscomprarprecio tbody input").each(function () {
      if ($(this).val() === "") {
        inputVacioEncontrado = true;
      }
    });
    if (inputVacioEncontrado) {
      Swal.fire({
        icon: "info",
        text: "Debes ingresar el precio antes de guardar la orden de compra.",
      });
      return;
    }
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
    formData.append("datosSeleccionadosInsumos", datosSeleccionadosInsumos);
    // formData.append("dataimagenes", JSON.stringify(dataimagenes));
    for (let i = 0; i < dataimagenes.length; i++) {
      formData.append("file[]", dataimagenes[i]);
    }
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      // data: {
      //   accion: accion,
      //   fecha: fecha,
      //   empresa: empresa,
      //   personalcod: personalcod,
      //   oficina: oficina,
      //   proveedor: proveedor,
      //   proveedordireccion: proveedordireccion,
      //   proveedorruc: proveedorruc,
      //   proveedordni: proveedordni,
      //   formapago: formapago,
      //   moneda: moneda,
      //   observacion: observacion,
      //   datosSeleccionadosInsumos: datosSeleccionadosInsumos,
      //   idcompraaprobada: idcompraaprobada,
      //   dataimagenes: dataimagenes,
      // },
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
  $("#selectformapago").click((e) => {
    let pago = $("#selectformapago").val();
    if (pago == "D") {
      $("#imagensum").prop("disabled", false);
    } else {
      $("#imagensum").prop("disabled", true);
      $("#tablaimagenes").empty();
    }
  });
  /*------------------------------------------------------------- */

  /*------------ Cuando doy click en el boton añadir una imagen ----- */
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

  $("#imagensum").click((e) => {
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
