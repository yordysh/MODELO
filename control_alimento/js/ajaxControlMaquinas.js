$(function () {
  fetchTasks();
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

  //------------- Añadiendo alerta control maquina ----------------//
  // $("#formularioControl").submit((e) => {
  $(document).on("click", "#botoncontrolmaquina", (e) => {
    e.preventDefault();

    let selectControl = $("#selectControl").val();
    let selectFrecuencia = $("#selectFrecuencia").val();
    const accion = edit === false ? "insertarcontrol" : "actualizarcontrol";
    // const accion = "insertarcontrol";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        nombrecontrol: selectControl,
        ndiascontrol: selectFrecuencia,
        codcontrol: $("#taskId").val(),
      },
      type: "POST",
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
              fetchTasks();
              $("#selectControl").val("none").trigger("change");
              $("#selectFrecuencia").val("0").trigger("change");
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
              $("#selectControl").val("none").trigger("change");
              $("#selectFrecuencia").val("0").trigger("change");
              $("#formularioControl").trigger("reset");
            }
          });
        }
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  /*------------------- Insertar un nueva maquina control------------------- */
  $(document).on("click", "#guardarcontrol", (e) => {
    e.preventDefault();
    let nombrecontrolmaquina = $("#nombrecontrol").val();
    console.log(nombrecontrolmaquina);
    const accion = "insertarcontrolmaquina";

    $.ajax({
      url: "./c_almacen.php",
      data: {
        accion: accion,
        nombrecontrolmaquina: nombrecontrolmaquina,
      },
      type: "POST",
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
              $("#nombrecontrol").val("");
              // $("#mostrarinfraestructuracontrol").on(
              //   "hidden.bs.modal",
              //   function () {
              //     $("body").css("overflow", "auto");
              //   }
              // );
              // $("#mostrarinfraestructuracontrol").modal("hide");
              // $(".modal-backdrop").remove();
              actualizarcombocontrol();
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
              $("#nombrecontrol").val("");
            }
          });
        }
      },
      complete: function () {
        $(".preloader").css("opacity", "0");
        $(".preloader").css("display", "none");
      },
    });
  });
  //----------------- Muestra respuesta y añade a mi tabla lo añadido --------------- //

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
            if (task.N_DIAS_POS == 1) {
              frecuencia = "Diario";
            } else if (task.N_DIAS_POS == 2) {
              frecuencia = "InterDiario";
            } else if (task.N_DIAS_POS == 7) {
              frecuencia = "Semanal";
            } else if (task.N_DIAS_POS == 15) {
              frecuencia = "Quincenal";
            } else if (task.N_DIAS_POS == 30) {
              frecuencia = "Mensual";
            }

            template += `<tr taskId="${task.CODIGO}">
      
              <td data-titulo="CONTROL DE MAQUINAS" class='NOMBRE_CONTROL_MAQUINA' >${task.NOMBRE_CONTROL_MAQUINA}</td>
              <td data-titulo="FRECUENCIA">${frecuencia}</td>
              <td data-titulo="FECHA" >${task.FECHA_CREACION}</td>
  
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
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Se añadio correctamente.",
          }).then((result) => {
            if (result.isConfirmed) {
              const task = JSON.parse(response);
              // $("#selectControl").prop("disabled", true);

              // if (task.NOMBRE_T_ZONA_AREAS) {
              //   selectControl.val(
              //     selectControl
              //       .find("option:contains('" + task.NOMBRE_T_ZONA_AREAS + "')")
              //       .val()
              //   );
              // }
              // $("#selectControl").append(
              //   new Option(
              //     task.NOMBRE_T_ZONA_AREAS,
              //     task.NOMBRE_T_ZONA_AREAS,
              //     true,
              //     true
              //   )
              // );

              $("#selectControl").val(task.COD_CONTROL_MAQUINA);
              $("#select2-selectControl-container").text(
                task.NOMBRE_CONTROL_MAQUINA
              );
              $("#selectFrecuencia").val(task.N_DIAS_POS);
              $("#taskId").val(task.COD_CONTROL_MAQUINA);

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

  /*------------------------------ Crgar datos en combo------------------------- */
  function actualizarcombocontrol() {
    const accion = "actualizarcombocontrol";
    $.ajax({
      url: "./c_almacen.php",
      data: { accion: accion },
      type: "POST",
      success: function (response) {
        let data = JSON.parse(response);
        $("#selectControl").empty();
        $("#selectControl").append(
          $("<option>", {
            value: "none",
            text: "Seleccione máquina",
            disabled: true,
            selected: true,
          })
        );
        data.forEach((item) => {
          $("#selectControl").append(
            $("<option>", {
              value: item.COD_CONTROL_MAQUINA,
              text: item.NOMBRE_CONTROL_MAQUINA,
            })
          );
        });
      },
      error: function (error) {
        console.error("Error fetching data:", error);
      },
    });
  }
  /*--------------------------------------------------------------------------- */

  /*---------------- actualizar control maquinas el pdf ------------------------ */
  $("#guardarcontrolmaquinapdf").click((e) => {
    e.preventDefault();

    if ($(".inputcheck:checked").length === 0) {
      Swal.fire({
        icon: "info",
        title: "Activar máquina",
        text: "Debe de activar alguna máquina.",
      });

      return false;
    }
    // let alertobs = false;
    // let alertacc = false;
    // let alertvb = false;
    // let alertestado = false;

    // $("#tablaControlModal tr").each(function () {
    //   let frecuenciavalor = $(this)
    //     .find("td:eq(1)")
    //     .find("input[type='checkbox']")
    //     .prop("checked");
    //   let observacion = $(this).find("td:eq(2)").find(".observacion").val();
    //   let accioncorrectiva = $(this)
    //     .find("td:eq(3)")
    //     .find(".acccioncorrectiva")
    //     .val();
    //   let vb = $(this).find("td:eq(4)").find(".selectVerif").val();
    //   let estado = $(this).find("td:eq(5)").find(".selectEstado").val();

    //   if (!frecuenciavalor && observacion == "") {
    //     alertobs = true;
    //     return false;
    //   }
    //   if (!frecuenciavalor && accioncorrectiva == "") {
    //     alertacc = true;
    //     return false;
    //   }
    //   if (!frecuenciavalor && vb != "1" && vb != "2") {
    //     alertvb = true;
    //     return false;
    //   }
    //   if (
    //     frecuenciavalor &&
    //     estado != "R" &&
    //     estado != "PO" &&
    //     estado != "OB"
    //   ) {
    //     alertestado = true;
    //     return false;
    //   }
    // });
    // if (alertobs) {
    //   Swal.fire({
    //     icon: "info",
    //     title: "Observación vacia",
    //     text: "Debe de escribir una observación.",
    //   });
    //   return;
    // }
    // if (alertacc) {
    //   Swal.fire({
    //     icon: "info",
    //     title: "Accion correctiva vacia",
    //     text: "Debe de escribir una acción correctiva.",
    //   });
    //   return;
    // }
    // if (alertvb) {
    //   Swal.fire({
    //     icon: "info",
    //     title: "V°B vacio",
    //     text: "Seleccione una opcion de V°B°.",
    //   });
    //   return;
    // }
    // if (alertestado) {
    //   Swal.fire({
    //     icon: "info",
    //     title: "Proceso vacio",
    //     text: "Seleccione una opcion del proceso.",
    //   });
    //   return;
    // }

    let valorcapturadocontrol = [];
    $("#tablaControlModal tr").each(function () {
      let codigoalertacontrol = $(this).attr("idcontrol");
      let codcontrol = $(this).find("td:eq(0)").attr("idcontrolmaquina");

      let frecuenciavalor = $(this)
        .find("td:eq(1)")
        .find("input[type='checkbox']")
        .prop("checked");

      let observacion = $(this).find("td:eq(2)").find(".observacion").val();
      let accioncorrectiva = $(this)
        .find("td:eq(3)")
        .find(".acccioncorrectiva")
        .val();
      let vb = $(this).find("td:eq(4)").find(".selectVerif").val();
      let estado = $(this).find("td:eq(5)").find(".selectEstado").val();

      valorcapturadocontrol.push({
        codigoalertacontrol: codigoalertacontrol,
        codcontrol: codcontrol,
        frecuenciavalor: frecuenciavalor,
        observacion: observacion,
        accioncorrectiva: accioncorrectiva,
        vb: vb,
        estado: estado,
      });
    });
    console.log(valorcapturadocontrol);
    let accioncontrol = "actualizardatoscontrolpdf";
    $.ajax({
      type: "POST",
      url: "./c_almacen.php",
      data: {
        accion: accioncontrol,
        valorcapturadocontrol: valorcapturadocontrol,
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
            allowOutsideClick: false,
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#tablaControlModal tr").each(function () {
                let checkboxdesactiva = $(this).find("#frecuenciamarca");
                checkboxdesactiva.prop("checked", false);

                let observacion = $(this).find(".observacion");
                observacion.parent().remove();

                let accioncorrectiva = $(this).find(".acccioncorrectiva");
                accioncorrectiva.parent().remove();

                let vb = $(this).find(".selectVerif");
                vb.parent().remove();

                let estado = $(this).find(".selectEstado");
                estado.parent().remove();
              });
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
  /*--------------------------------------------------------------------------- */

  /*---------------- Darle click en switch y me añada textarea----------------- */

  $(".inputcheck").change(function () {
    var fila = $(this).closest("tr");
    let codigoactual = fila.find("td:eq(0)").attr("idcontrolmaquina");
    if ($(this).is(":checked")) {
      var estado = $(
        `<td>    <select id="selectEstado" class="form-select selectEstado" style="margin:5px 80px" >
                        <option selected>Seleccione proceso</option>
                        <option value="R">Realizado</option>
                        <option value="PO">Pendiente</option>
                         <option value="OB">Observado</option>
                </select>
        </td>`
      );
      var columnaobservacion = $(
        `<td><textarea class="form-control observacion" id="observacion" rows="2" style="margin:5px 80px"></textarea></td>`
      );
      var columnaaccioncorrectiva = $(
        `<td><textarea class="form-control acccioncorrectiva" id="acccioncorrectiva" rows="2" style="margin:5px 80px"></textarea></td>`
      );
      var vb = $(
        `<td>    <select id="selectVB" class="form-select selectVerif" style="margin:5px 80px" >
                        <option value="none" selected>Seleccione V°B°</option>
                        <option value="1">J.A.C</option>
                         <option value="2">A.A.C</option>
                </select>
        </td>`
      );

      /*----------------------------Al darle click en opcion realizado ------------*/
      estado.find("select").change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === "R") {
          columnaobservacion.find("textarea").prop("disabled", true).val("");
          columnaaccioncorrectiva
            .find("textarea")
            .prop("disabled", true)
            .val("");
          vb.find("select")
            .prop("disabled", true)
            .val("none")
            .trigger("change");
        }
        if (selectedValue === "PO") {
          columnaaccioncorrectiva
            .find("textarea")
            .prop("disabled", true)
            .val("");
          columnaobservacion.find("textarea").prop("disabled", false).val("");
          vb.find("select")
            .prop("disabled", false)
            .val("none")
            .trigger("change");
        }
        if (selectedValue === "OB") {
          columnaobservacion.find("textarea").prop("disabled", false).val("");
          columnaaccioncorrectiva
            .find("textarea")
            .prop("disabled", false)
            .val("");
          vb.find("select")
            .prop("disabled", false)
            .val("none")
            .trigger("change");
        }
      });

      /*------------------------------------------------------------------------- */
      fila.append(estado, columnaobservacion, columnaaccioncorrectiva, vb);

      $("#tablaControlModal tr").each(function () {
        let codigocontrolmaquina = $(this)
          .find("td:eq(0)")
          .attr("idcontrolmaquina");

        if (
          codigocontrolmaquina == "001" &&
          $(this).find(".inputcheck").prop("checked")
        ) {
          if (
            codigoactual == "002" &&
            $(this).find(".inputcheck").prop("checked")
          ) {
            $("#tablaControlModal tr").each(function () {
              let codigocontrolmaquina03 = $(this)
                .find("td:eq(0)")
                .attr("idcontrolmaquina");
              if (codigocontrolmaquina03 == "003") {
                $(this).find(".inputcheck").prop("checked", true);
              }
            });
          }
        } else if (
          codigocontrolmaquina == "002" &&
          $(this).find(".inputcheck").prop("checked")
        ) {
          if (
            codigoactual == "001" &&
            $(this).find(".inputcheck").prop("checked")
          ) {
            $("#tablaControlModal tr").each(function () {
              let codigocontrolifmaquina03 = $(this)
                .find("td:eq(0)")
                .attr("idcontrolmaquina");
              if (codigocontrolifmaquina03 == "003") {
                $(this).find(".inputcheck").prop("checked", true);
              }
            });
          }
        }
      });
    } else {
      $("#tablaControlModal tr").each(function () {
        let codigomaquina = $(this).find("td:eq(0)").attr("idcontrolmaquina");

        if (
          codigomaquina == "001" &&
          $(this).find(".inputcheck").prop("checked")
        ) {
          if (codigoactual == "002") {
            $("#tablaControlModal tr").each(function () {
              let codigomaquina03 = $(this)
                .find("td:eq(0)")
                .attr("idcontrolmaquina");
              if (codigomaquina03 == "003") {
                $(this).find(".inputcheck").prop("checked", false);
              }
            });
          }
        } else if (
          codigomaquina == "002" &&
          $(this).find(".inputcheck").prop("checked")
        ) {
          if (codigoactual == "001") {
            $("#tablaControlModal tr").each(function () {
              let codigomaquinaelse03 = $(this)
                .find("td:eq(0)")
                .attr("idcontrolmaquina");
              if (codigomaquinaelse03 == "003") {
                $(this).find(".inputcheck").prop("checked", false);
              }
            });
          }
        }
      });

      fila.find(".observacion").parent().remove();
      fila.find(".acccioncorrectiva").parent().remove();
      fila.find(".selectVerif").parent().remove();
      fila.find(".selectEstado").parent().remove();
    }
  });
  /*-------------------------------------------------------------------------- */
});
