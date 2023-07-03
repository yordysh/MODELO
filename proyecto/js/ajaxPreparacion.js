$(function () {
  $("#task-result").hide();
  fetchTasks();
  cargarSelect();
  function fetchTasks() {
    $.ajax({
      url: "./tablaPreparacion.php",
      type: "GET",
      success: function (data) {
        $("#tabla").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  function cargarSelect() {
    const preparacion = $("#selectPreparaciones");
    const cantidad = $("#selectCantidad");
    const mililitros = $("#selectML");
    const litros = $("#selectL");
    const accion = "seleccionarPreparacion";
    const accionPreparacion = "seleccionarCantidad";
    const accionCantidad = "seleccionarML";
    const accionMililitros = "seleccionarL";

    $("#selectInsumos").change(function () {
      var idSolucion = $(this).val();
      $.ajax({
        data: {
          idSolucion: idSolucion,
          accion: accion,
        },
        dataType: "html",
        type: "POST",
        url: "./c_almacen.php",
      }).done(function (data) {
        preparacion.html(data);
        // console.log(data);
      });
    });

    $("#selectPreparaciones").change(function () {
      var idPreparacion = $(this).val();
      $.ajax({
        data: {
          idPreparacion: idPreparacion,
          accion: accionPreparacion,
        },
        dataType: "html",
        type: "POST",
        url: "./c_almacen.php",
      }).done(function (data) {
        cantidad.html(data);
        // console.log(data);
      });
    });

    $("#selectCantidad").change(function () {
      var idCantidad = $(this).val();
      $.ajax({
        data: {
          idCantidad: idCantidad,
          accion: accionCantidad,
        },
        dataType: "html",
        type: "POST",
        url: "./c_almacen.php",
      }).done(function (data) {
        mililitros.html(data);
      });
    });

    $("#selectML").change(function () {
      var idMililitros = $(this).val();

      $.ajax({
        data: {
          idMililitros: idMililitros,
          accion: accionMililitros,
        },
        dataType: "html",
        type: "POST",
        url: "./c_almacen.php",
      }).done(function (data) {
        litros.html(data);
      });
    });
  }

  $("#formularioSoluciones").submit(function (e) {
    e.preventDefault();
    var selectSolucion = $("#selectInsumos option:selected").text();
    var selectPreparacion = $("#selectPreparaciones option:selected").text();
    var selectCantidad = $("#selectCantidad option:selected").text();
    var selectML = $("#selectML option:selected").text();
    var selectL = $("#selectL option:selected").text();

    enviarCombos(
      selectSolucion,
      selectPreparacion,
      selectCantidad,
      selectML,
      selectL
    );
    $("#formularioSoluciones").trigger("reset");
  });

  function enviarCombos(
    selectSolucion,
    selectPreparacion,
    selectCantidad,
    selectML,
    selectL
  ) {
    var accion = "enviarSelectCombo";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: {
        selectSolucion: selectSolucion,
        selectPreparacion: selectPreparacion,
        selectCantidad: selectCantidad,
        selectML: selectML,
        selectL: selectL,
        accion: accion,
      },
      success: function (response) {
        fetchTasks();
        alert(response);
      },
    });
  }
});
