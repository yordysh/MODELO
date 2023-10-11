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
  $("#selectproveedor").select2();

  $("#selectproveedor").select2({
    dropdownParent: $("#mostrarproveedor .modal-body"),
  });
  /*---------Cargar la orden de compra aprobada------------------- */
  function cargarOrdenCompraAprobada() {
    const accion = "mostrarordencompraaprobada";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr id_orden_compra_aprobada='${task.COD_ORDEN_COMPRA}'>
                            <td data-titulo='CODIGO REQUERIMIENTO' style='text-align: center;'>${task.COD_REQUERIMIENTO}</td>
                            <td data-titulo='FECHA' style='text-align: center;'>${task.FECHA}</td>
                            <td data-titulo='PERSONAL' style='text-align: center;'>${task.NOM_PERSONAL}</td>
                           
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

    $("#mostrarproveedor").modal("hide");
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
                            <td data-titulo='PRECIO' style='text-align: center;'><input type='number' step='any' /></td>
                            <td data-titulo='SELECCIONAR' style='text-align: center;'><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked></td>
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

  /*--------- insertar orden de compra de los insumos con precio-----*/

  $("#insertarOrdenCompraInsumos").on("click", (e) => {
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
    let observacion = $("#observacion").val();
    let idcompraaprobada = $("#tmostrarordencompraaprobado tr:eq(1)").attr(
      "id_orden_compra_aprobada"
    );

    const datosSeleccionadosInsumos = [];
    $("#tablainsumoscomprar tr").each(function () {
      const fila = $(this);

      const checkbox = fila.find("input[type='checkbox']");

      if (checkbox.prop("checked")) {
        const material = fila
          .find("td[data-titulo='MATERIAL']")
          .attr("codigo_producto");
        const cantidad = fila.find("td[data-titulo='CANTIDAD']").text();
        const precio = fila.find("td[data-titulo='PRECIO'] input").val();

        const datosFila = {
          material: material,
          cantidad: cantidad,
          precio: precio,
        };
        datosSeleccionadosInsumos.push(datosFila);
      }
    });

    if (!personal) {
      Swal.fire({
        icon: "info",
        text: "Dar check en listado de documentos aprobados.",
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

    const accion = "guardarinsumoscompras";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        fecha: fecha,
        empresa: empresa,
        personalcod: personalcod,
        oficina: oficina,
        proveedor: proveedor,
        proveedordireccion: proveedordireccion,
        proveedorruc: proveedorruc,
        proveedordni: proveedordni,
        formapago: formapago,
        moneda: moneda,
        observacion: observacion,
        datosSeleccionadosInsumos: datosSeleccionadosInsumos,
        idcompraaprobada: idcompraaprobada,
      },
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
              $("#observacion").val("");
              $("#selectformapago").val("E").trigger("change");
              $("#selectmoneda").val("S").trigger("change");
              $("#tablainsumoscomprar").empty();

              $("#nombreproveedor").val("");
              $("#direccionproveedor").val("");
              $("#ruc").val("");
              $("#dniproveedor").val("");
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
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
