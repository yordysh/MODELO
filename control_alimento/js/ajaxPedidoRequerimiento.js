$(function () {
  mostrarPendientes();

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

  $("#search").keyup(() => {
    if ($("#search").val()) {
      var search = $("#search").val();
      const accion = "buscarpendientestotal";
      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarpendiente: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);
            let template = ``;
            tasks.forEach((task) => {
              template += `<tr taskId="${task.COD_REQUERIMIENTO}">
         
              <td data-titulo="PRODUCTO">${task.DES_PRODUCTO}</td>
              <td data-titulo="CANTIDAD">${task.CANTIDAD_ITEM}</td>
              <td  style="text-align:center;"><button class="custom-icon" name="mostrarinsumos" id="mostrarinsumos"><i class="icon-circle-with-plus"></i></button></td>
          </tr>`;
            });
            $("#tablaPedidoRequerimiento").html(template);
          }
        },
      });
    } else {
      mostrarPendientes();
    }
  });

  function mostrarPendientes() {
    const accion = "buscarpendientestotal";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, buscarpendiente: search },
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_REQUERIMIENTO}">
       
                            <td data-titulo="PRODUCTO" idprod='${task.COD_PRODUCTO}'>${task.DES_PRODUCTO}</td>
                            <td data-titulo="CANTIDAD">${task.CANTIDAD_ITEM}</td>
                            <td  style="text-align:center;"><button class="custom-icon" name="mostrarinsumos" id="mostrarInsumosRequerimiento"><i class="icon-circle-with-plus"></i></button></td>
                        </tr>`;
          });
          $("#tablaPedidoRequerimiento").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  $(document).on("click", "#mostrarInsumosRequerimiento", (e) => {
    e.preventDefault();
    let element = $(this)[0].activeElement.parentElement.parentElement;
    // let cod_fomulacion = $(element).attr("taskId");
    // console.log(cod_fomulacion);
    // console.log("object");
    // let element = $(this).closest("tr"); // Encuentra el elemento <tr> padre más cercano
    let cod_fomulacion = element.attr("taskId");
    let idprod = element.find("td[data-titulo='PRODUCTO']").attr("idprod");

    console.log(cod_fomulacion);
    console.log(idprod);
  });
});
