$(function () {
  fetchTasks();
  // select();

  let edit = false;

  $("#selectInfra").select2();

  //   $("#selectInfra").autocomplete({
  //     source: function (request, response) {
  //       const accion = "buscarZonaCombo";

  //       $.ajax({
  //         url: "./c_almacen.php",
  //         method: "POST",
  //         dataType: "json",
  //         data: {
  //           accion: accion,
  //           term: request.term,
  //         },
  //         success: function (data) {
  //           if (!data) {
  //             $("#task_zona").val("");
  //           }
  //           response(data);
  //         },
  //       });
  //     },
  //     select: function (event, ui) {
  //       console.log(ui.item.id);
  //       $("#task_zona").val(ui.item.id);
  //     },
  //     close: function () {
  //       const searchTerm = $("#selectInfra").val().trim();

  //       if (searchTerm === "") {
  //         $("#task_zona").val("");
  //       }
  //     },
  //   });
  // });

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
  $("#formularioInfra").submit((e) => {
    e.preventDefault();

    var selectInfra = document.getElementById("selectInfra");

    selectInfra.disabled = false;

    const accion = edit === false ? "insertarinfra" : "actualizarinfra";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        nombreinfraestructura: $("#NOMBRE_INFRAESTRUCTURA").val(),
        ndias: $("#selectFrecuencia").val(),
        // ndias: $("#NDIAS").val(),
        codinfra: $("#taskId").val(),
        valorSeleccionado: $("#selectInfra").val(),
        // valorSeleccionado: $("#task_zona").val(),
      },
      type: "POST",
      success: function (response) {
        console.log(response);
        if (response == "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              fetchTasks();
              $("#formularioInfra").trigger("reset");
              $("#selectInfra").val("none").trigger("change");
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
    });
  });
  //-----------------------------------------------------------------------------//

  //------------- Añadiendo con ajax ZonaAreas----------------//
  $("#formularioZona").submit((e) => {
    e.preventDefault();

    const accion = edit === false ? "insertar" : "actualizar";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        nombrezonaArea: $("#NOMBRE_T_ZONA_AREAS").val(),
        codzona: $("#taskId").val(),
      },

      type: "POST",
      success: function (response) {
        if (response.toLowerCase() === "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#formularioZona").trigger("reset");
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
              fetchTasks();
              $("#formularioZona").trigger("reset");
            }
          });
        }
      },
    });
  });

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
  //-----------------------------------------------------------------------------//

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
