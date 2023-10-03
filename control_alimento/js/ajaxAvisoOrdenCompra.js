$(function () {
  const accion = "mostrarordencompraalmacen";

  $.ajax({
    url: "./c_almacen.php",
    type: "POST",
    data: { accion: accion },
    success: function (response) {
      Swal.fire({
        title: "Compra de insumos",
        icon: "question",
        html: ``,
        confirmButtonText: "Ok",
        showCloseButton: true,
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al cargar los datos de la tabla:", error);
    },
  });
});
