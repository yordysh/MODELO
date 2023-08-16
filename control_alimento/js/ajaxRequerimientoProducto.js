$(function () {
  mostarRequerimientoProducto();
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

  $("#selectProductoCombo").select2();
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
  $("#formularioRequerimientoProducto").submit((e) => {
    e.preventDefault();
    const accion = "insertarrequerimientoproducto";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        selectProductoCombo: $("#selectProductoCombo").val(),
        cantidadProducto: $("#cantidadProducto").val(),
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
              $("#selectProductoCombo").val("none").trigger("change");
              $("#formularioRequerimientoProducto").trigger("reset");

              mostarRequerimientoProducto();
            }
          });
        }
        // } else {
        //   Swal.fire({
        //     icon: "error",
        //     title: "Oops...",
        //     text: "Duplicado!",
        //     confirmButtonText: "Aceptar",
        //   }).then((result) => {
        //     if (result.isConfirmed) {
        //       fetchTasks();
        //       $("#formularioControl").trigger("reset");
        //     }
        //   });
        // }
      },
    });
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //
  // Cargar registros requerimiento producto

  function mostarRequerimientoProducto() {
    const accion = "buscarrequerimientoproducto";
    const search = "";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, buscarrequerimiento: search },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          let tasks = JSON.parse(response);

          let template = ``;
          tasks.forEach((task) => {
            template += `<tr taskId="${task.COD_REQUERIMIENTO}">
    
                            <td data-titulo="CODIGO PRODUCTO" >${task.DES_PRODUCTO}</td>      
                            <td data-titulo="CANTIDAD" >${task.CANTIDAD}</td>

                        </tr>`;
          });

          $("#tablaRequerimientoProducto").html(template);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar los datos de la tabla:", error);
      },
    });
  }
});
