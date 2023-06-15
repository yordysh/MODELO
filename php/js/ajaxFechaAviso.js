$(function () {
  alertaMensaje()
    .then(function () {
      alerta();
    })
    .catch(function (error) {
      console.error(error);
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
        // console.log(diferenciaDias);
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

      $.ajax({
        url: "php/fecha-alerta-mensaje.php",
        method: "GET",
        dataType: "json",
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

        Swal.fire({
          title: "Información",
          html: `
              <div><h2 class="nombre_area">Nombre del área:</h2> <p>${task.NOMBRE_AREA}</p></div>
              <div><h2 class="nombre_infra">Nombre de la infraestructura:</h2> <p>${task.NOMBRE_INFRAESTRUCTURA}</p></div>
              <div><h2 class="nombre_infra">COD_ALERTA1:</h2> <p>${task.COD_ALERTA}</p></div>
      
              <label>
                <input type="radio" name="estado-${task.COD_ALERTA}" value="R"> Realizado
              </label>
              <label>
                <input type="radio" name="estado-${task.COD_ALERTA}" value="T"> No Realizado
              </label>
              <label id="observacion">
              <input type="radio" name="estado-${task.COD_ALERTA}" value="O"> Postergación
              </label>
              <textarea class="form-control" id="observacion-${task.COD_ALERTA}" rows="3" style="display: none;"></textarea>
               `,
          icon: "info",
          confirmButtonText: "Aceptar",
          preConfirm: () => {
            const realizadoRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="R"]`
            );
            const noRealizadoRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="T"]`
            );
            const observacionRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="O"]`
            );

            if (
              realizadoRadio.checked ||
              noRealizadoRadio.checked ||
              observacionRadio.checked
            ) {
              const estado = realizadoRadio.checked
                ? "R"
                : noRealizadoRadio.checked
                ? "T"
                : "O";

              const observacion = observacionRadio.checked
                ? document.querySelector(`#observacion-${task.COD_ALERTA}`)
                    .value
                : "";
              const observacionTextArea = observacionTextarea.value;
              if (observacionRadio.checked) {
                // Abrir modal
                $("#myModalExito").modal("show");
                // Resuelve la promesa para confirmar la acción
                return Promise.resolve();
              }

              return $.ajax({
                url: "./php/checkbox-confirma.php",
                method: "POST",
                data: {
                  estado: estado,
                  taskId: task.COD_ALERTA,
                  observacionTextArea: observacionTextArea,
                },
                dataType: "json",
              })
                .done(function (response) {
                  console.log(response);
                  mostrarAlertas(data, index + 1);

                  // Crea una nueva alerta con la fecha total
                  const nuevaFechaTotal = new Date();

                  return $.ajax({
                    url: "./php/insertar-alertamix.php",
                    method: "POST",
                    data: {
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
            const observacionRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="O"]`
            );
            const observacionTextarea = document.querySelector(
              `#observacion-${task.COD_ALERTA}`
            );

            if (observacionRadio.checked) {
              // Abrir modal
              $("#myModalExito").modal("show");
              // Resolves the promise to confirm the action
              Promise.resolve().then(() => {
                observacionTextarea.style.display = "block";
                const realizadoRadio = document.querySelector(
                  `input[name="estado-${task.COD_ALERTA}"][value="R"]`
                );
                const noRealizadoRadio = document.querySelector(
                  `input[name="estado-${task.COD_ALERTA}"][value="T"]`
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
                  console.log(fechaPostergacion);
                  const observacion = observacionTextarea.value;

                  // Realizar la actualización del estado con "O" utilizando una solicitud AJAX
                  $.ajax({
                    url: "./php/checkbox-confirma.php",
                    method: "POST",
                    data: {
                      estado: "O",
                      taskId: task.COD_ALERTA,
                      observacion: observacion,
                      fechaPostergacion: fechaPostergacion,
                    },
                    dataType: "json",
                  })
                    .done(function (response) {
                      console.log(response);
                      $("#myModalExito").modal("hide");
                      mostrarAlertas(data, index + 1);

                      // Crea una nueva alerta con la fecha total
                      const nuevaFechaTotal = new Date();

                      // Insertar nueva alerta con la fecha total utilizando una solicitud AJAX
                      $.ajax({
                        url: "./php/insertar-alertamix.php",
                        method: "POST",
                        data: {
                          fechaCreacion: nuevaFechaTotal.toISOString(),
                          codInfraestructura: task.COD_INFRAESTRUCTURA,
                          taskNdias: task.NDIAS,
                          fechaPostergacion: fechaPostergacion,
                          // taskPostergacion:
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
        const observacionRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA}"][value="O"]`
        );
        const observacionTextarea = document.querySelector(
          `#observacion-${task.COD_ALERTA}`
        );

        observacionRadio.addEventListener("change", function () {
          observacionTextarea.style.display = this.checked ? "block" : "none";
        });

        const noRealizadoRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA}"][value="T"]`
        );
        noRealizadoRadio.addEventListener("change", function () {
          observacionTextarea.style.display = "none";
        });

        const realizadoRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA}"][value="R"]`
        );
        realizadoRadio.addEventListener("change", function () {
          observacionTextarea.style.display = "none";
        });
        const obs = document.getElementById("observacion");
        realizadoRadio.addEventListener("change", function () {
          observacionTextarea.style.display = "none";
        });

        if (task.NDIAS > 6 && task.POSTERGACION == "NO") {
          observacionRadio.style.display = "block";
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
          observacionRadio.style.display = "none";
          obs.style.visibility = "hidden";
        }
      }

      $.ajax({
        url: "php/fecha-alerta.php",
        method: "GET",
        dataType: "json",
        success: function (data) {
          mostrarAlertas(data, 0); // Iniciar la secuencia de alertas
        },
      });
    });
  }
});
