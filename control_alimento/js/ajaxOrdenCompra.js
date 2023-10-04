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
                            <td data-titulo='CODIGO'>${task.COD_REQUERIMIENTO}</td>
                            <td data-titulo='FECHA'>${task.FECHA}</td>
                            <td data-titulo='PERSONAL'>${task.NOM_PERSONAL}</td>
                           
                            <td style="text-align:center;"><button class="custom-icon"  id="aprobarcompraaprobada"><i class="icon-check"></i></button></td>
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
  /*-------mostrar campos de orden de compra--------------------*/
  $(document).on("click", "#aprobarcompraaprobada", (e) => {
    e.preventDefault();
    console.log("object");
  });
  /*---------------------------------------------------------- */
  /*-------------------- Guardar datos modal----------------- */
  $("#ponerproveedor").on("click", (e) => {
    e.preventDefault();

    var nombreProveedor = $("#nombreproveedor").val();
    var direccionProveedor = $("#direccionproveedor").val();
    var ruc = $("#ruc").val();
    var dniProveedor = $("#dniproveedor").val();

    $("#proveedor").val(nombreProveedor);
    $("#direccion").val(direccionProveedor);
    $("#ruc_principal").val(ruc);
    $("#dni_principal").val(dniProveedor);

    $("#mostrarproveedor").modal("hide");
  });
  /*-------------------------------------------------------- */
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
