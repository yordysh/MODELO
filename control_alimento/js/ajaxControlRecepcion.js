$(function () {
  $("#selectrequerimiento").change(function () {
    let selectrequerimiento = $("#selectrequerimiento").val();

    const accion = "mostrarvaloresporcodigorequerimiento";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, selectrequerimiento: selectrequerimiento },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);
          let template = ``;
          tasks.forEach((task) => {
            template += `<tr">
                            <td data-titulo="CODIGO">${task.DES_PRODUCTO}</td>
                            <td data-titulo="NOMBRE">${task.CANTIDAD}</td>
                         </tr>`;
          });
          $("#tablaproductoscantidades").html(template);
        }
      },
    });
  });
});
