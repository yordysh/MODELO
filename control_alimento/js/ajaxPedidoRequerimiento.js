$(function () {
  mostrarPendientes();

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
       
            <td data-titulo="PRODUCTO">${task.DES_PRODUCTO}</td>
            <td data-titulo="CANTIDAD">${task.CANTIDAD_ITEM}</td>
            <td  style="text-align:center;"><button class="custom-icon" name="mostrarinsumos" id="mostrarinsumos"><i class="icon-circle-with-plus"></i></button></td>
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
});
