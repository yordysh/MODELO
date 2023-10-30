$(function () {
  fetchTasks();
  // select();

  let edit = false;

  //===== Prealoder

  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  //-------------------------------------------//
  $("#selectInfra").select2();
  //------------- Busqueda con ajax infraestructura Accesorio----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      let search = $("#search").val();
      const accion = "buscarinfra";

      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarinfra: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);
            // console.log(tasks);
            let template = ``;
            tasks.forEach((task) => {
              let frecuencia;
              if (task.NDIAS == 1) {
                frecuencia = "Diario";
              } else if (task.NDIAS == 2) {
                frecuencia = "InterDiario";
              } else if (task.NDIAS == 7) {
                frecuencia = "Semanal";
              } else if (task.NDIAS == 15) {
                frecuencia = "Quincenal";
              } else if (task.NDIAS == 30) {
                frecuencia = "Mensual";
              }
              template += `<tr taskId="${task.COD_INFRAESTRUCTURA}">
             
              <!-- <td data-titulo="CODIGO" >${task.COD_INFRAESTRUCTURA}</td> -->
              <td data-titulo="ZONA" >${task.NOMBRE_T_ZONA_AREAS}</td>
              <td data-titulo="INFRAESTRUCTURA" class='NOMBRE_INFRAESTRUCTURA' >${task.NOMBRE_INFRAESTRUCTURA}</td>
              <td data-titulo="FRECUENCIA">${frecuencia}</td>
              <td data-titulo="FECHA" >${task.FECHA}</td>
  
  
              <td style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_INFRAESTRUCTURA="${task.COD_INFRAESTRUCTURA}"><i class="icon-edit"></i></button></td>
  
            </tr>`;
            });

            $("#tablaInfraestructura").html(template);
          }
        },
      });
    } else {
      fetchTasks();
    }
  });

  //------------- Añadiendo con ajax InfraestructuraAccesorios----------------//
  // $("#formularioInfra").submit((e) => {
  $("#boton").on("click", (e) => {
    e.preventDefault();

    var selectInfra = document.getElementById("selectInfra");

    // selectInfra.disabled = false;

    let accion = edit === false ? "insertarinfra" : "actualizarinfra";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        // nombreinfraestructura: $("#NOMBRE_INFRAESTRUCTURA").val(),
        nombreinfraestructura: $("#seleccionzonainfraestructura").val(),
        ndias: $("#selectFrecuencia").val(),
        // ndias: $("#NDIAS").val(),
        codinfra: $("#taskId").val(),
        valorSeleccionado: $("#selectInfra").val(),
        codpersonal: $("#codpersonal").val(),
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: function (response) {
        console.log(response);
        if (response === "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              // $("#formularioInfra").trigger("reset");
              $("#taskId").val("");
              $("#selectFrecuencia").val("0").trigger("change");
              $("#NOMBRE_INFRAESTRUCTURA").val("");
              $("#selectInfra").val("none").trigger("change");
              fetchTasks();
            }
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Duplicado!",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#formularioInfra").trigger("reset");
              $("#selectInfra").val("none").trigger("change");
            }
          });
        }
        // console.log(data);
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  //-----------------------------------------------------------------------------//

  //------------- Añadiendo con ajax ZonaAreas----------------//
  // $("#formularioZona").submit((e) => {
  $("#ponerzona").on("click", (e) => {
    const accion = edit === false ? "insertar" : "actualizar";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        nombrezonaArea: $("#nombrezona").val(),
        codzona: $("#taskId").val(),
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
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
              $("#nombrezona").val("");
              // $("#mostrarzonas").modal("hide");
              actualizarCombo();
            }
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Duplicado!",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#nombrezona").val("");
              fetchTasks();
              // $("#formularioZona").trigger("reset");
            }
          });
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  //----------------------------------------------------------//

  /*--------------- Poner el value de zona------------------- */

  $("#selectInfra").change(function () {
    let selectinfra = $("#selectInfra").val();
    $("#valordezonahidden").val(selectinfra);
  });
  /*----------------------------------------------------------- */
  //------------- Añadiendo con ajax infraestrutura----------------//
  // $("#guardarinfra").on("click", (e) => {
  $(document).on("click", "#guardarinfra", (e) => {
    e.preventDefault();

    let nombrezonain = $("#valordezonahidden").val();
    let accion = "guardarinfraestructura";
    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        nombreinfraestructuraz: $("#nombreinfraestructura").val(),
        nombrezonain: nombrezonain,
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: function (response) {
        console.log("respuesta" + response);

        if (response === "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#nombreinfraestructura").val("");
              actualizarComboInfraestructura(nombrezonain);
            }
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Duplicado!",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#nombreinfraestructura").val("");
              // fetchTasks();
              // $("#formularioZona").trigger("reset");
            }
          });
        }
      },
      error: function (error) {
        console.log("ERROR " + error);
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });

  //--------------------------------------------------------------//
  function actualizarCombo() {
    const accion = "actualizarcombozona";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion },
      type: "POST",
      success: function (response) {
        let data = JSON.parse(response);
        $("#selectInfra").empty();
        $("#selectInfra").append(
          $("<option>", {
            value: "none",
            text: "Seleccione Zona/Areas",
            disabled: true,
            selected: true,
          })
        );
        data.forEach((item) => {
          $("#selectInfra").append(
            $("<option>", {
              value: item.COD_ZONA,
              text: item.NOMBRE_T_ZONA_AREAS,
            })
          );
        });
      },
      error: function (error) {
        console.error("Error fetching data:", error);
      },
    });
  }

  function actualizarComboInfraestructura(nombrezonain) {
    const accion = "actualizarcomboinfraestructura";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, nombrezonain: nombrezonain },
      type: "POST",
      success: function (response) {
        let data = JSON.parse(response);
        $("#seleccionzonainfraestructura").empty();
        $("#seleccionzonainfraestructura").append(
          $("<option>", {
            value: "none",
            text: "Seleccione infraestructura",
            disabled: true,
            selected: true,
          })
        );
        data.forEach((item) => {
          $("#seleccionzonainfraestructura").append(
            $("<option>", {
              value: item.COD_INFRAESTRUCTURA,
              text: item.NOMBRE_INFRAESTRUCTURA,
            })
          );
        });
      },
      error: function (error) {
        console.error("Error fetching data:", error);
      },
    });
  }

  //-----------------------------------------------------------------------------//

  /*---------- Al seleccionar un combo zona me muestre contenido en combo infraestructura---- */
  let seleccionzonainfraestructura = $("#seleccionzonainfraestructura");
  const accion = "seleccionarzonainfra";
  $("#selectInfra").change(function () {
    let idzona = $("#selectInfra").val();

    $.ajax({
      data: {
        idzona: idzona,
        accion: accion,
      },
      dataType: "html",
      type: "POST",
      url: "./c_almacen.php",
    }).done(function (data) {
      seleccionzonainfraestructura.html(data);
    });
  });
  /*-------------------------------------------------------------------------------------- */

  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //
  // Cargar registros INFRAESTRUCTURA

  function fetchTasks() {
    const accion = "buscarinfra";
    const search = "";
    $.ajax({
      // url: "./tablaInfraestructura.php",
      url: "./c_almacen.php",
      data: { accion: accion, buscarinfra: search },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            let frecuencia;
            if (task.NDIAS == 1) {
              frecuencia = "Diario";
            } else if (task.NDIAS == 2) {
              frecuencia = "InterDiario";
            } else if (task.NDIAS == 7) {
              frecuencia = "Semanal";
            } else if (task.NDIAS == 15) {
              frecuencia = "Quincenal";
            } else if (task.NDIAS == 30) {
              frecuencia = "Mensual";
            }
            template += `<tr taskId="${task.COD_INFRAESTRUCTURA}">
           
            <!-- <td data-titulo="CODIGO" >${task.COD_INFRAESTRUCTURA}</td> -->
            <td data-titulo="ZONA" >${task.NOMBRE_T_ZONA_AREAS}</td>
            <td data-titulo="INFRAESTRUCTURA" class='NOMBRE_INFRAESTRUCTURA' >${task.NOMBRE_INFRAESTRUCTURA}</td>
            <td data-titulo="FRECUENCIA">${frecuencia}</td>
            <td data-titulo="FECHA" >${task.FECHA}</td>


            <td style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_INFRAESTRUCTURA="${task.COD_INFRAESTRUCTURA}"><i class="icon-edit"></i></button></td>

          </tr>`;
          });

          $("#tablaInfraestructura").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }

  //------------------------ Actualiza un dato de mi tabla ----------------- //

  $(document).on("click", ".task-update", () => {
    var element = $(this)[0].activeElement.parentElement.parentElement;

    // var selectInfra = document.getElementById("selectInfra");
    // selectInfra.disabled = true;

    var COD_INFRAESTRUCTURA = $(element).attr("taskId");
    const accion = "editarinfra";

    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, codinfra: COD_INFRAESTRUCTURA },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Se añadio correctamente.",
          }).then((result) => {
            if (result.isConfirmed) {
              const task = JSON.parse(response);

              $("#selectInfra").prop("disabled", true);
              $("#selectInfra")
                .append(
                  new Option(
                    task.NOMBRE_T_ZONA_AREAS,
                    task.NOMBRE_T_ZONA_AREAS,
                    true,
                    true
                  )
                )
                .trigger("change");
              $("#NOMBRE_INFRAESTRUCTURA").val(task.NOMBRE_INFRAESTRUCTURA);
              $("#NDIAS").val(task.NDIAS);
              $("#taskId").val(task.COD_INFRAESTRUCTURA);

              edit = true;
            }
          });
        }
      },
    });
  });

  //------------------------ Elimina un dato de mi tabla ----------------- //

  $(document).on("click", ".task-delete", function (e) {
    e.preventDefault();
    var COD_INFRAESTRUCTURA = $(this).attr("data-COD_INFRAESTRUCTURA");
    const accion = "eliminarinfra";

    Swal.fire({
      title: "¿Está seguro de eliminar este registro?",
      text: "Esta acción no se puede deshacer.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "./c_almacen.php",
          type: "POST",
          data: { accion: accion, codinfra: COD_INFRAESTRUCTURA },
          success: function (response) {
            fetchTasks();
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Registro eliminado correctamente.",
              showConfirmButton: false,
              timer: 1500,
            });
            console.log(response);
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });
      }
    });
  });
});
