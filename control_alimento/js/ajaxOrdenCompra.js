$(function () {
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

  function cargarOrdenCompra() {
    const accion = "mostrarordencompra";

    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion },
      success: function (response) {
        // console.log(response);
        if (isJSON(response)) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskproduccionrequerimiento="${task.COD_REQUERIMIENTO}">
                            <td data-titulo='CODIGO' style="text-align:center;">${task.COD_REQUERIMIENTO}</td>
                            <td data-titulo='PRODUCTO' style="text-align:center;" codigoproducto='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                            <td data-titulo='CANTIDAD' style="text-align:center;">${task.CANTIDAD}</td>
                            <td  style="text-align:center;"><button class="custom-icon" name="mostrarproduccionrequerimiento" id="mostrarproduccionrequerimiento"><i class="icon-circle-with-plus"></i></button></td>
                          </tr>`;
          });
          $("#tablaproduccionrequerimiento").html(template);
        } else {
          $("#tablaproduccionrequerimiento").empty();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
});
function isJSON(str) {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}
