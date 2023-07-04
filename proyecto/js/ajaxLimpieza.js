$(function () {
  $("#task-result").hide();
  fetchTasks();

  function fetchTasks() {
    $.ajax({
      url: "./tablaLimpieza.php",
      type: "GET",
      success: function (data) {
        $("#tablalimpieza").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  $("#formularioLimpieza").submit(function (e) {
    e.preventDefault();
    var selectZona = $("#selectZona").val();
    var textfrecuencia = $("#nombreFrecuencia").val();
    console.log("click" + selectZona);
  });
});
