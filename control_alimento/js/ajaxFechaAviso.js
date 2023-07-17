$(function () {
  alertaMensaje()
    .then(function () {
      alerta();
    })
    .catch(function (error) {
      // console.error(error);
      alerta();
    });

  function alertaMensaje() {
    return new Promise(function (resolve, reject) {
      function mostrarMensaje(data, index) {
        if (index >= data.length) {
          resolve();
          return;
        }

        const task = data[index];
        var fecha = task.FECHA_TOTAL;
        var partesFecha = fecha.split("/");
        var fechaTotal = new Date(
          partesFecha[2],
          partesFecha[1] - 1,
          partesFecha[0]
        );

        var fechaActual = new Date();

        var diferenciaMilisegundos = fechaTotal - fechaActual;
        var milisegundosEnUnDia = 24 * 60 * 60 * 1000;
        var diferenciaDias = Math.floor(
          diferenciaMilisegundos / milisegundosEnUnDia + 1
        );
        console.log("FECHA_TOTAL: " + fecha);
        console.log("FECHA_ACTUAL: " + fechaTotal);
        Swal.fire({
          title: "Mensaje recordatorio",
          html: `
            <div><h2 class="nombre_area">Nombre del área:</h2> <p>${task.NOMBRE_AREA}</p></div>
            <div><h2 class="nombre_infra">Nombre de la infraestructura:</h2> <p>${task.NOMBRE_INFRAESTRUCTURA}</p></div>
            <div><h2 class="nombre_infra">Faltan </h2> <p>${diferenciaDias} días</p></div>
          `,
          icon: "info",
          confirmButtonText: "Aceptar",
          allowOutsideClick: false,
        }).then(function () {
          mostrarMensaje(data, index + 1);
        });
      }
      const accion = "fechaalertamensaje";
      $.ajax({
        // url: "php/fecha-alerta-mensaje.php",
        url: "c_almacen.php",
        method: "POST",
        dataType: "json",
        data: { accion: accion },
        success: function (data) {
          if (data.length > 0) {
            mostrarMensaje(data, 0);
          } else {
            resolve();
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          reject(errorThrown);
        },
      });
    });
  }

  function alerta() {
    return new Promise(function (resolve, reject) {
      function mostrarAlertas(data, index) {
        if (index >= data.length) {
          return;
        }

        const task = data[index];

        let accionCorrectiva;
        let selectVerificacion;

        Swal.fire({
          title: "Información",
          html: `
              <div><h2 class="nombre_area">Nombre del área:</h2> <p>${task.NOMBRE_AREA}</p></div>
              <div><h2 class="nombre_infra">Nombre de la infraestructura:</h2> <p>${task.NOMBRE_INFRAESTRUCTURA}</p></div>
              <div>
              <h3>Accion correctiva:</h3> 
              <textarea class="form-control" id="accionCorrectiva" rows='3' "></textarea>
              </div>
              <div>
              <h3>Verificacion realizada:</h3> 
               <select id="selectVerificacion" class="form-select selectVerif" style="width:250px; margin-left:140px;" aria-label="Default select example">
                  <option selected>Seleccione una verificacion</option>
                  <option value="1">Conforme</option>
                  <option value="2">No conforme</option>
                </select>
              </div>
              <label>
                <input type="radio" name="estado-${task.COD_ALERTA}" value="R"> Realizado
              </label>
              <label>
                <input type="radio" name="estado-${task.COD_ALERTA}" value="NR"> No Realizado
              </label>
              <label>
              <input type="radio" name="estado-${task.COD_ALERTA}" value="OB"> Observación
            </label>
              <label id="postergacion">
              <input type="radio" name="estado-${task.COD_ALERTA}" value="PO"> Postergación
              </label>
              <textarea class="form-control" id="observacion-${task.COD_ALERTA}" rows="3" style="display: none;"></textarea>
               `,
          icon: "info",
          width: 600,
          allowOutsideClick: false,
          confirmButtonText: "Aceptar",
          preConfirm: () => {
            const realizadoRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="R"]`
            );
            const noRealizadoRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="NR"]`
            );
            const observacionButtonRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="OB"]`
            );
            const postergacionRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="PO"]`
            );

            if (
              realizadoRadio.checked ||
              noRealizadoRadio.checked ||
              observacionButtonRadio.checked ||
              postergacionRadio.checked
            ) {
              const estado = realizadoRadio.checked
                ? "R"
                : noRealizadoRadio.checked
                ? "NR"
                : observacionButtonRadio.checked
                ? "OB"
                : "PO";

              const postergacion = postergacionRadio.checked
                ? document.querySelector(`#observacion-${task.COD_ALERTA}`)
                    .value
                : "";
              const observacionTextArea = observacionTextarea.value;

              accionCorrectiva =
                document.getElementById("accionCorrectiva").value;

              selectVerificacion = $(
                "#selectVerificacion option:selected"
              ).text();

              if (postergacionRadio.checked) {
                // Abrir modal
                $("#myModalExito").modal("show");

                return Promise.resolve();
              }
              const accion = "actualizaalerta";
              return $.ajax({
                // url: "./php/checkbox-confirma.php",
                url: "c_almacen.php",
                method: "POST",
                data: {
                  accion: accion,
                  estado: estado,
                  taskId: task.COD_ALERTA,
                  taskFecha: task.FECHA_TOTAL,
                  observacionTextArea: observacionTextArea,
                  accionCorrectiva: accionCorrectiva,
                  selectVerificacion: selectVerificacion,
                },
                dataType: "json",
              })
                .done(function (response) {
                  console.log(response);
                  mostrarAlertas(data, index + 1);

                  // Crea una nueva alerta con la fecha total
                  const nuevaFechaTotal = new Date();
                  const accion = "insertaralertamix";
                  return $.ajax({
                    // url: "./php/insertar-alertamix.php",
                    url: "c_almacen.php",
                    method: "POST",
                    data: {
                      accion: accion,
                      fechaCreacion: nuevaFechaTotal.toISOString(),
                      codInfraestructura: task.COD_INFRAESTRUCTURA,
                      taskNdias: task.NDIAS,
                    },
                    dataType: "json",
                  });
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                  console.error(textStatus, errorThrown);
                });
            } else {
              Swal.showValidationMessage(
                "Selecciona si la tarea se realizó o no."
              );
              return false;
            }
          },
        }).then((result) => {
          if (result.isConfirmed) {
            // Comprobar si el botón de radio de observación está seleccionado
            const postergacionRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="PO"]`
            );
            const observacionTextarea = document.querySelector(
              `#observacion-${task.COD_ALERTA}`
            );

            if (postergacionRadio.checked) {
              // Abrir modal
              $("#myModalExito").modal("show");
              // Resolves the promise to confirm the action
              Promise.resolve().then(() => {
                observacionTextarea.style.display = "block";
                const realizadoRadio = document.querySelector(
                  `input[name="estado-${task.COD_ALERTA}"][value="R"]`
                );
                const noRealizadoRadio = document.querySelector(
                  `input[name="estado-${task.COD_ALERTA}"][value="NR"]`
                );

                realizadoRadio.checked = false;
                noRealizadoRadio.checked = false;

                // Agregar evento de clic al botón de confirmación dentro del modal
                const modalConfirmButton = document.querySelector(
                  "#myModalExito .confirm-button"
                );
                modalConfirmButton.addEventListener("click", function () {
                  const fechaPostergacion = document.querySelector(
                    "input[name='fecha_postergacion']"
                  ).value;

                  console.log("accionCorrectiva: " + accionCorrectiva);
                  console.log("selectVerificacion: " + selectVerificacion);

                  const observacion = observacionTextarea.value;
                  const accion = "actualizaalerta";

                  // Realizar la actualización del estado con "PO" utilizando una solicitud AJAX
                  $.ajax({
                    url: "c_almacen.php",
                    // url: "./php/checkbox-confirma.php",
                    method: "POST",
                    data: {
                      accion: accion,
                      estado: "PO",
                      taskId: task.COD_ALERTA,
                      taskFecha: task.FECHA_TOTAL,
                      observacion: observacion,
                      fechaPostergacion: fechaPostergacion,
                      accionCorrectiva: accionCorrectiva,
                      selectVerificacion: selectVerificacion,
                    },
                    dataType: "json",
                  })
                    .done(function (response) {
                      console.log(response);
                      $("#myModalExito").modal("hide");
                      mostrarAlertas(data, index + 1);

                      // Crea una nueva alerta con la fecha total
                      const nuevaFechaTotal = new Date();
                      const accion = "insertaralertamix";
                      // Insertar nueva alerta con la fecha total utilizando una solicitud AJAX
                      $.ajax({
                        url: "c_almacen.php",
                        method: "POST",
                        data: {
                          accion: accion,
                          fechaCreacion: nuevaFechaTotal.toISOString(),
                          codInfraestructura: task.COD_INFRAESTRUCTURA,
                          taskNdias: task.NDIAS,
                          fechaPostergacion: fechaPostergacion,
                          accionCorrectiva: accionCorrectiva,
                          selectVerificacion: selectVerificacion,
                        },
                        dataType: "json",
                      });
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                      console.error(textStatus, errorThrown);
                    });
                });
              });
            } else {
              observacionTextarea.style.display = "none";
              mostrarAlertas(data, index + 1);
            }
          }
        });
        const postergacionRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA}"][value="PO"]`
        );
        const observacionTextarea = document.querySelector(
          `#observacion-${task.COD_ALERTA}`
        );

        postergacionRadio.addEventListener("change", function () {
          observacionTextarea.style.display = this.checked ? "block" : "none";
        });

        const observacionButtonRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA}"][value="OB"]`
        );
        observacionButtonRadio.addEventListener("change", function () {
          observacionTextarea.style.display = this.checked ? "block" : "none";
        });

        const noRealizadoRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA}"][value="NR"]`
        );
        noRealizadoRadio.addEventListener("change", function () {
          observacionTextarea.style.display = this.checked ? "block" : "none";
        });

        const realizadoRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA}"][value="R"]`
        );
        realizadoRadio.addEventListener("change", function () {
          observacionTextarea.style.display = this.checked ? "block" : "none";
        });
        const obs = document.getElementById("postergacion");

        if (task.NDIAS > 6 && task.POSTERGACION == "NO") {
          postergacionRadio.style.display = "block";
          realizadoRadio.addEventListener("change", function () {
            observacionTextarea.style.display = "block";
          });
          noRealizadoRadio.addEventListener("change", function () {
            observacionTextarea.style.display = "block";
          });
          console.log(task.POSTERGACION);
        } else {
          if (task.POSTERGACION == "SI") {
            realizadoRadio.addEventListener("change", function () {
              observacionTextarea.style.display = "block";
            });
            noRealizadoRadio.addEventListener("change", function () {
              observacionTextarea.style.display = "block";
            });
          }
          postergacionRadio.style.display = "none";
          obs.style.visibility = "hidden";
        }
      }
      const accion = "fechaalerta";
      $.ajax({
        url: "c_almacen.php",
        method: "POST",
        dataType: "json",
        data: { accion: accion },
        success: function (data) {
          mostrarAlertas(data, 0);
        },
      });
    });
  }
});
