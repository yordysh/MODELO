$(function () {
  fetchTasks();
  let edit = false;

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

  $("#selectControl").select2();
  //------------- Busqueda con ajax infraestructura Accesorio----------------//

  $("#search").keyup(() => {
    if ($("#search").val()) {
      let search = $("#search").val();
      const accion = "buscarcontrol";

      $.ajax({
        url: "./c_almacen.php",
        data: { accion: accion, buscarcontrol: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let tasks = JSON.parse(response);

            let template = ``;
            tasks.forEach((task) => {
              let frecuencia;
              if (task.N_DIAS_CONTROL == 1) {
                frecuencia = "Diario";
              } else if (task.N_DIAS_CONTROL == 2) {
                frecuencia = "InterDiario";
              } else if (task.N_DIAS_CONTROL == 7) {
                frecuencia = "Semanal";
              } else if (task.N_DIAS_CONTROL == 15) {
                frecuencia = "Quincenal";
              } else if (task.N_DIAS_CONTROL == 30) {
                frecuencia = "Mensual";
              }

              template += `<tr taskId="${task.COD_CONTROL_MAQUINA}">
    
                <!-- <td data-titulo="CODIGO" >${task.COD_CONTROL_MAQUINA}</td> -->
                <td data-titulo="ZONA" >${task.NOMBRE_T_ZONA_AREAS}</td>
                <td data-titulo="CONTROL DE MAQUINAS" class='NOMBRE_CONTROL_MAQUINA' >${task.NOMBRE_CONTROL_MAQUINA}</td>
                <td data-titulo="FRECUENCIA">${frecuencia}</td>
                <td data-titulo="FECHA" >${task.FECHA}</td>
    
                <td style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_CONTROL_MAQUINA="${task.COD_CONTROL_MAQUINA}"><i class="icon-edit"></i></button></td>
    
              </tr>`;
            });

            $("#tablaControl").html(template);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos de la tabla:", error);
        },
      });
    } else {
      fetchTasks();
    }
  });

  //------------- Añadiendo con ajax InfraestructuraAccesorios----------------//
  $("#formularioControl").submit((e) => {
    e.preventDefault();

    var selectControl = document.getElementById("selectControl");
    selectControl.disabled = false;

    const accion = edit === false ? "insertarcontrol" : "actualizarcontrol";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        nombrecontrol: $("#NOMBRE_CONTROL_MAQUINA").val(),
        // ndiascontrol: $("#N_DIAS_CONTROL").val(),
        ndiascontrol: $("#selectFrecuencia").val(),
        codcontrol: $("#taskId").val(),
        valorSeleccionado: $("#selectControl").val(),
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
              $("#formularioControl").trigger("reset");
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
              $("#formularioControl").trigger("reset");
            }
          });
        }
      },
    });
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //
  // Cargar registros ZONA AREA

  function fetchTasks() {
    const accion = "buscarcontrol";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, buscarcontrol: search },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            let frecuencia;
            if (task.N_DIAS_CONTROL == 1) {
              frecuencia = "Diario";
            } else if (task.N_DIAS_CONTROL == 2) {
              frecuencia = "InterDiario";
            } else if (task.N_DIAS_CONTROL == 7) {
              frecuencia = "Semanal";
            } else if (task.N_DIAS_CONTROL == 15) {
              frecuencia = "Quincenal";
            } else if (task.N_DIAS_CONTROL == 30) {
              frecuencia = "Mensual";
            }

            template += `<tr taskId="${task.COD_CONTROL_MAQUINA}">
  
              <!-- <td data-titulo="CODIGO" >${task.COD_CONTROL_MAQUINA}</td> -->
              <td data-titulo="ZONA" >${task.NOMBRE_T_ZONA_AREAS}</td>
              <td data-titulo="CONTROL DE MAQUINAS" class='NOMBRE_CONTROL_MAQUINA' >${task.NOMBRE_CONTROL_MAQUINA}</td>
              <td data-titulo="FRECUENCIA">${frecuencia}</td>
              <td data-titulo="FECHA" >${task.FECHA}</td>
  
              <td style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_CONTROL_MAQUINA="${task.COD_CONTROL_MAQUINA}"><i class="icon-edit"></i></button></td>
  
            </tr>`;
          });

          $("#tablaControl").html(template);
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
    var cod_control_maquina = $(element).attr("taskId");
    const accion = "editarcontrolmaquina";

    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, codcontrolmaquina: cod_control_maquina },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          const task = JSON.parse(response);

          $("#selectControl").prop("disabled", true);

          // if (task.NOMBRE_T_ZONA_AREAS) {
          //   selectControl.val(
          //     selectControl
          //       .find("option:contains('" + task.NOMBRE_T_ZONA_AREAS + "')")
          //       .val()
          //   );
          // }
          $("#selectControl").append(
            new Option(
              task.NOMBRE_T_ZONA_AREAS,
              task.NOMBRE_T_ZONA_AREAS,
              true,
              true
            )
          );

          $("#NOMBRE_CONTROL_MAQUINA").val(task.NOMBRE_CONTROL_MAQUINA);
          $("#N_DIAS_CONTROL").val(task.N_DIAS_CONTROL);
          $("#taskId").val(task.COD_CONTROL_MAQUINA);

          edit = true;
        }
      },
    });
  });

  //------------------------ Elimina un dato de mi tabla ----------------- //

  $(document).on("click", ".task-delete", function (e) {
    e.preventDefault();
    var COD_CONTROL_MAQUINA = $(this).attr("data-COD_CONTROL_MAQUINA");
    const accion = "eliminarcontrolmaquina";

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
          data: { accion: accion, codcontrolmaquina: COD_CONTROL_MAQUINA },
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
