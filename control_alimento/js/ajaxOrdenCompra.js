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

  cargarOrdenCompra();

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

  // function cargarOrdenCompra() {
  //   const accion = "mostrarordencompra";

  //   $.ajax({
  //     url: "./c_almacen.php",
  //     type: "POST",
  //     data: { accion: accion },
  //     success: function (response) {
  //       if (isJSON(response)) {
  //         let tasks = JSON.parse(response);
  //         let template = ``;
  //         tasks.forEach((task) => {
  //           template += `<tr id_orden_compra='${task.COD_ORDEN_COMPRA}'>
  //                           <td data-titulo='INSUMOS' id_producto_compra='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
  //                           <td data-titulo='CANTIDAD FALTANTE'>${task.CANTIDAD_INSUMO_ENVASE}</td>
  //                           <td data-titulo='CANTIDAD POR COMPRAR'>${task.CANTIDAD_MINIMA}</td>
  //                           <td data-titulo='APROBAR' style="text-align:center;"><button class="custom-icon" name="aprobarinsumos" id="aprobarcompra"><i class="icon-check"></i></button></td>
  //                        </tr>`;
  //         });
  //         $("#tablatotalordencompra").html(template);
  //       } else {
  //         $("#tablatotalordencompra").empty();
  //       }
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error al cargar los datos de la tabla:", error);
  //     },
  //   });
  // }
  function cargarOrdenCompra() {
    const accion = "mostrarordencompra";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr id_orden_compra='${task.COD_ORDEN_COMPRA}'>
                            <td data-titulo='CODIGO REQUERIMIENTO'>${task.COD_REQUERIMIENTO}</td>
                            <td data-titulo='FECHA'>${task.FECHA}</td>
                            <td data-titulo='VER' style="text-align:center;"><button class="custom-icon" name="mirarcompra" id="mirarcompra"><i class="icon-eye"></i></button></td>
                            <td data-titulo='APROBAR' style="text-align:center;"><button class="custom-icon" name="aprobarinsumos" id="aprobarcompra"><i class="icon-check"></i></button></td>
                          </tr>`;
          });
          $("#tablaordencomprarequerimiento").html(template);
        } else {
          $("#tablaordencomprarequerimiento").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
  /*-----------------------Mirar compra------------------------- */
  $(document).on("click", "#mirarcompra", (e) => {
    e.preventDefault();
    let idcodordencompra = $("#tablaordencomprarequerimiento tr").attr(
      "id_orden_compra"
    );
    const accion = "mirarordencompra";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, idcodordencompra: idcodordencompra },
      success: function (response) {
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          console.log(tasks);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr>
                            <td data-titulo='INSUMOS'>${task.DES_PRODUCTO}</td>
                            <td data-titulo='CANTIDAD  FALTANTE'>${task.CANTIDAD_INSUMO_ENVASE}</td>
                            <td data-titulo='CANTIDAD POR COMPRAR'>${task.CANTIDAD_MINIMA}</td>
                         </tr>`;
          });
          $("#tablatotalordencompra").html(template);
        } else {
          $("#tablatotalordencompra").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  });
  /*--------------------------------------------------------------*/
  /*-----------------------Aprobar compra------------------------- */
  $(document).on("click", "#aprobarcompra", (e) => {
    e.preventDefault();
    let idcodordencompra = $("#tablaordencomprarequerimiento tr").attr(
      "id_orden_compra"
    );
    let codpersonal = $("#codpersonal").val();
    const accion = "aprobarordencompra";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        accion: accion,
        idcodordencompra: idcodordencompra,
        codpersonal: codpersonal,
      },
      success: function (response) {
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              cargarOrdenCompra();
            }
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  });
  /*--------------------------------------------------------------*/
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
