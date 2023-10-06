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

  cargarOrdenCompraComprobante();

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

  /*----------------------MOSTRAR LA ORDEN DE COMPRA--------------- */
  function cargarOrdenCompraComprobante() {
    const accion = "mostrarcompracomprobante";

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
            <td data-titulo='FECHA' style='text-align: center;'>${task.FECHA_REALIZADA}</td>
                            <td data-titulo='FECHA' style='text-align: center;'>${task.FECHA_REALIZADA}</td>
                            <td data-titulo='PROVEEDOR' style='text-align: center;'>${task.NOM_PROVEEDOR}</td>
                            <td data-titulo='EMPRESA' style='text-align: center;'>${task.NOMBRE}</td>
                            <td style="text-align:center;"><button class="custom-icon"  id="clickcompraaprobada"><i class="icon-check"></i></button></td>
                          </tr>`;
          });
          $("#tablamostarcomprobante").html(template);
        } else {
          $("#tablamostarcomprobante").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
  /*-------------------------------------------------------------- */
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
