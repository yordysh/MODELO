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

  //------------- Añadiendo con ajax InfraestructuraAccesoriosAlerta----------------//
  // $("#formularioInfra").submit((e) => {
  /*------------Si llega a borrar ZONA AREAS verificar control maquina ya que se insertar valor estatico OTROS */
  $("#boton").on("click", (e) => {
    e.preventDefault();

    // var selectInfra = document.getElementById("selectInfra");
    let selectInfra = $("#selectInfra").val();
    let seleccionzonainfraestructura = $("#seleccionzonainfraestructura").val();
    let selectFrecuencia = $("#selectFrecuencia").val();
    console.log(selectInfra);
    // selectInfra.disabled = false;
    if (!selectInfra) {
      Swal.fire({
        title: "<strong>Seleccione una zona</strong>",
        icon: "info",
        allowOutsideClick: false,
        confirmButtonText: "Ok",
      });
      return;
    }
    if (!seleccionzonainfraestructura) {
      Swal.fire({
        title: "<strong>Seleccione una infraestructura</strong>",
        icon: "info",
        allowOutsideClick: false,
        confirmButtonText: "Ok",
      });
      return;
    }
    if (!selectFrecuencia) {
      Swal.fire({
        title: "<strong>Seleccione una frecuencia</strong>",
        icon: "info",
        allowOutsideClick: false,
        confirmButtonText: "Ok",
      });
      return;
    }

    let accion = edit === false ? "insertarinfra" : "actualizarinfra";

    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accion,
        nombreinfraestructura: $("#seleccionzonainfraestructura").val(),
        ndias: $("#selectFrecuencia").val(),
        codinfra: $("#taskId").val(),
        valorSeleccionado: selectInfra,
        codpersonal: $("#codpersonal").val(),
      },
      beforeSend: function () {
        $(".preloader").css("opacity", "1");
        $(".preloader").css("display", "block");
      },
      success: function (response) {
        if (response === "ok") {
          Swal.fire({
            title: "¡Guardado exitoso!",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
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
              // $("#mostrarzonas").on("hidden.bs.modal", function () {
              //   $("body").css("overflow", "auto");
              // });
              // $("#mostrarzonas").modal("hide");
              // $(".modal-backdrop").remove();
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

    const accion =
      edit === false ? "guardarinfraestructura" : "actualizarinfraestructura";
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
              // $("#mostrarinfraestructura").on("hidden.bs.modal", function () {
              //   $("body").css("overflow", "auto");
              // });
              // $("#mostrarinfraestructura").modal("hide");
              // $(".modal-backdrop").remove();
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
            template += `<tr taskId="${task.CODIGO}">
          
            <td data-titulo="ZONA" >${task.NOMBRE_T_ZONA_AREAS}</td>
            <td data-titulo="INFRAESTRUCTURA" class='NOMBRE_INFRAESTRUCTURA' >${task.NOMBRE_INFRAESTRUCTURA}</td>
            <td data-titulo="FRECUENCIA">${frecuencia}</td>
            <td data-titulo="FECHA" >${task.FECHA}</td>


            <td style="text-align:center;"><button class="btn btn-success task-update" name="editar" id="edit" data-COD_ZONA="${task.COD_INFRAESTRUCTURA}"><i class="icon-edit"></i></button></td>

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
              console.log(task);

              $("#selectInfra").val(task.COD_ZONA);

              $("#select2-selectInfra-container").text(
                task.NOMBRE_T_ZONA_AREAS
              );

              let select = $("#seleccionzonainfraestructura");
              select.text(
                select.find(
                  "option:contains('" + task.NOMBRE_INFRAESTRUCTURA + "')"
                )
              );
              let optionByValue = select.find(
                "option[value='" + task.COD_INFRAESTRUCTURA + "']"
              );
              console.log(optionByValue);
              // actualizarNombreCombo(task.CODIGO);
              actualizareditarcombo(task.COD_ZONA, task.COD_INFRAESTRUCTURA);

              $("#selectFrecuencia").prop("disabled", true);
              $("#selectFrecuencia").val(task.NDIAS);
              $("#taskId").val(task.CODIGO);

              edit = true;
            }
          });
        }
      },
    });
  });

  // function actualizarNombreCombo(codigoalerta) {
  //   const accion = "buscarporcodigoalertainf";
  //   $.ajax({
  //     url: "./c_almacen.php",
  //     data: { accion: accion, codigoalerta: codigoalerta },
  //     type: "POST",
  //     success: function (response) {
  //       if (!response.error) {
  //         const datas = JSON.parse(response);
  //         console.log(datas);
  //         const codigoInfraestructura = datas.COD_INFRAESTRUCTURA;
  //         const nombreInfraestructura = datas[0].NOMBRE_INFRAESTRUCTURA;

  //         // Establecer el valor del elemento <select>
  //         $("#seleccionzonainfraestructura").val(codigoInfraestructura);

  //         // Cambiar el texto solo si se selecciona una opción válida
  //         if (codigoInfraestructura !== "none") {
  //           $(
  //             "#seleccionzonainfraestructura option[value='" +
  //               codigoInfraestructura +
  //               "']"
  //           ).text(nombreInfraestructura);
  //         }
  //       }
  //     },
  //   });
  // }

  // ------------------------ Elimina un dato de mi tabla ----------------- //
  function actualizareditarcombo(codzonainfraes, codigoInfraestructura) {
    const accion = "buscarporcodzona";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion, codzonainfraes: codzonainfraes },
      type: "POST",
      success: function (response) {
        if (!response.error) {
          const data = JSON.parse(response);
          // let estado = false;
          $("#seleccionzonainfraestructura").empty();
          $.each(data, function (index, item) {
            $("#seleccionzonainfraestructura").append(
              new Option(
                (text = item.NOMBRE_INFRAESTRUCTURA),
                (value = item.COD_INFRAESTRUCTURA)
              )
            );
          });
          $(
            "#seleccionzonainfraestructura option[value='" +
              codigoInfraestructura +
              "']"
          ).attr("selected", "true");
        }
      },
    });
  }
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
