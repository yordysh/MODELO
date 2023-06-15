$(function () {
  // alertaMensaje();
  //alerta();
  //modal();
  alertaModal();
  // $(function () {
  //   alertaMensaje()
  //     .then(function () {
  //       alerta();
  //     })
  //     .catch(function (error) {
  //       console.error(error);
  //       alerta();
  //     });

  //   function alertaMensaje() {
  //     return new Promise(function (resolve, reject) {
  //       function mostrarMensaje(data, index) {
  //         if (index >= data.length) {
  //           resolve();
  //           return;
  //         }

  //         const task = data[index];
  //         const fechaActual = new Date();
  //         const fechaTotal = new Date(task.FECHA_TOTAL);
  //         const diferenciaMilisegundos = fechaTotal - fechaActual;
  //         const milisegundosEnUnDia = 24 * 60 * 60 * 1000;
  //         const diferenciaDias = Math.floor(
  //           diferenciaMilisegundos / milisegundosEnUnDia
  //         );
  //         console.log(diferenciaDias);
  //         Swal.fire({
  //           title: "Mensaje recordatorio",
  //           html: `
  //             <div><h2 class="nombre_area">Nombre del área:</h2> <p>${task.NOMBRE_AREA}</p></div>
  //             <div><h2 class="nombre_infra">Nombre de la infraestructura:</h2> <p>${task.NOMBRE_INFRAESTRUCTURA}</p></div>
  //             <div><h2 class="nombre_infra">Faltan </h2> <p>${diferenciaDias} días</p></div>
  //           `,
  //           icon: "info",
  //           confirmButtonText: "Aceptar",
  //           allowOutsideClick: false,
  //         }).then(function () {
  //           mostrarMensaje(data, index + 1);
  //         });
  //       }

  //       $.ajax({
  //         url: "php/fecha-alerta-mensaje.php",
  //         method: "GET",
  //         dataType: "json",
  //         success: function (data) {
  //           if (data.length > 0) {
  //             mostrarMensaje(data, 0);
  //           } else {
  //             resolve();
  //           }
  //         },
  //         error: function (jqXHR, textStatus, errorThrown) {
  //           reject(errorThrown);
  //         },
  //       });
  //     });
  //   }

  //   function alerta() {
  //     Swal.fire({
  //       title: "Alerta",
  //       text: "Any fool can use a computer",
  //       icon: "info",
  //       confirmButtonText: "Aceptar",
  //       allowOutsideClick: false,
  //     });
  //   }
  // });

  //------------------------ Muestra Alerta en index.php ----------------- //

  function alertaDiaria() {
    // $.ajax({
    //   url: "php/fecha-alerta.php",
    //   method: "GET",
    //   dataType: "json",
    //   success: function (data) {
    //     let promise = Promise.resolve(); // Crear una promesa resuelta inicialmente
    //     data.forEach((task) => {
    //       promise = promise.then(() => {
    //         return Swal.fire({
    //           title: "Información",
    //           html: `<div class="cod-infraestructura">Nombre infraestructura: ${task.COD_INFRAESTRUCTURA}</div>
    //                  <div class="fecha-creacion">Fecha de creación: ${task.FECHA_CREACION}</div>
    //                  <div class="fecha-total">Fecha total: ${task.FECHA_TOTAL}</div>
    //                  <div class="fecha-acordar">Fecha acordar: ${task.FECHA_ACORDAR}</div>`,
    //           icon: "info",
    //           confirmButtonText: "Aceptar",
    //         });
    //       });
    //     });
    //   },
    // });
  }

  function alerta1Dia() {
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
              <input type="radio" name="estado-${task.COD_ALERTA}" value="P"> No Realizado
            </label>
             `,
        icon: "info",
        confirmButtonText: "Aceptar",
        preConfirm: () => {
          const realizadoRadio = document.querySelector(
            `input[name="estado-${task.COD_ALERTA}"][value="R"]`
          );
          const noRealizadoRadio = document.querySelector(
            `input[name="estado-${task.COD_ALERTA}"][value="P"]`
          );

          if (realizadoRadio.checked || noRealizadoRadio.checked) {
            const estado = realizadoRadio.checked ? "R" : "T";

            return $.ajax({
              url: "./php/checkbox-confirma.php",
              method: "POST",
              data: {
                estado: estado,
                taskId: task.COD_ALERTA,
              },
              dataType: "json",
            })

              .done(function (response) {
                console.log(response);
                mostrarAlertas(data, index + 1);

                // Crea una nueva alerta con la fecha total
                const nuevaFechaTotal = new Date();

                return $.ajax({
                  url: "./php/insertar-alerta.php",
                  method: "POST",
                  data: {
                    fechaCreacion: nuevaFechaTotal.toISOString(),
                    codInfraestructura: task.COD_INFRAESTRUCTURA,
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
      });
    }

    $.ajax({
      url: "php/fecha-alerta.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        mostrarAlertas(data, 0); // Iniciar la secuencia de alertas
      },
    });
  }

  function alertaSemanal() {
    // function mostrarAlertas(data, index) {
    //   if (index >= data.length) {
    //     return;
    //   }

    //   const task = data[index];

    //   Swal.fire({
    //     title: "Información",
    //     html: `
    //       <div><h2 class="nombre_area">Nombre del área:</h2> <p>${task.NOMBRE_AREA}</p></div>
    //       <div><h2 class="nombre_infra">Nombre de la infraestructura:</h2> <p>${task.NOMBRE_INFRAESTRUCTURA}</p></div>
    //       <label>
    //         <input type="radio" name="estado-${task.COD_ALERTA}" value="R"> Realizado
    //       </label>
    //       <label>
    //         <input type="radio" name="estado-${task.COD_ALERTA}" value="P"> No Realizado
    //       </label>
    //       <label>
    //       <input type="radio" name="estado-${task.COD_ALERTA}" value="O"> Observación
    //       </label>
    //       <textarea class="form-control" id="observacion-${task.COD_ALERTA}" rows="3" style="display: none;"></textarea>
    //     `,
    //     icon: "info",
    //     confirmButtonText: "Aceptar",
    //     preConfirm: () => {
    //       const realizadoRadio = document.querySelector(
    //         `input[name="estado-${task.COD_ALERTA}"][value="R"]`
    //       );
    //       const noRealizadoRadio = document.querySelector(
    //         `input[name="estado-${task.COD_ALERTA}"][value="P"]`
    //       );
    //       const observacionRadio = document.querySelector(
    //         `input[name="estado-${task.COD_ALERTA}"][value="O"]`
    //       );

    //       if (
    //         realizadoRadio.checked ||
    //         noRealizadoRadio.checked ||
    //         observacionRadio.checked
    //       ) {
    //         const estado = realizadoRadio.checked
    //           ? "R"
    //           : noRealizadoRadio.checked
    //           ? "P"
    //           : "O";

    //         const observacion = observacionRadio.checked
    //           ? document.querySelector(`#observacion-${task.COD_ALERTA}`).value
    //           : "";
    //         return $.ajax({
    //           url: "./php/checkbox-confirma.php",
    //           method: "POST",
    //           data: {
    //             estado: estado,
    //             observacion: observacion,
    //             taskId: task.COD_ALERTA,
    //           },
    //           dataType: "json",
    //         })
    //           .done(function (response) {
    //             console.log(response);

    //             if (estado === "P") {
    //               // Crea una nueva alerta con la fecha total
    //               const nuevaFechaTotal = new Date();
    //               // nuevaFechaTotal.setDate(nuevaFechaTotal.getDate() + 1);

    //               return $.ajax({
    //                 url: "./php/insertar-alertaInterDiario.php",
    //                 method: "POST",
    //                 data: {
    //                   fechaCreacion: nuevaFechaTotal.toISOString(),
    //                   codInfraestructura: task.COD_INFRAESTRUCTURA,
    //                 },
    //                 dataType: "json",
    //               })
    //                 .done(function (insertResponse) {
    //                   console.log(insertResponse);
    //                 })
    //                 .fail(function (insertError) {
    //                   console.error(insertError);
    //                 })
    //                 .always(function () {
    //                   mostrarAlertas(data, index + 1);
    //                 });
    //             } else {
    //               mostrarAlertas(data, index + 1);
    //             }
    //           })
    //           .fail(function (jqXHR, textStatus, errorThrown) {
    //             console.error(textStatus, errorThrown);
    //           });
    //       } else {
    //         Swal.showValidationMessage(
    //           "Selecciona si la tarea se realizó o no."
    //         );
    //         return false;
    //       }
    //     },
    //   });
    //   const observacionRadio = document.querySelector(
    //     `input[name="estado-${task.COD_ALERTA}"][value="O"]`
    //   );
    //   const observacionTextarea = document.querySelector(
    //     `#observacion-${task.COD_ALERTA}`
    //   );

    //   observacionRadio.addEventListener("change", function () {
    //     observacionTextarea.style.display = this.checked ? "block" : "none";
    //   });

    //   const noRealizadoRadio = document.querySelector(
    //     `input[name="estado-${task.COD_ALERTA}"][value="P"]`
    //   );
    //   noRealizadoRadio.addEventListener("change", function () {
    //     observacionTextarea.style.display = this.checked ? "none" : "none";
    //   });

    //   const realizadoRadio = document.querySelector(
    //     `input[name="estado-${task.COD_ALERTA}"][value="R"]`
    //   );
    //   realizadoRadio.addEventListener("change", function () {
    //     observacionTextarea.style.display = this.checked ? "none" : "none";
    //   });
    // }

    // $.ajax({
    //   url: "php/fecha-alertaSemanal.php",
    //   method: "GET",
    //   dataType: "json",
    //   success: function (data) {
    //     mostrarAlertas(data, 0); // Iniciar la secuencia de alertas
    //   },
    // });

    function mostrarAlertas(data, index) {
      if (index >= data.length) {
        console.log("¡Todas las alertas han sido mostradas!");
        return;
      }

      const task = data[index];

      Swal.fire({
        title: "Información",
        html: `
            <div><h2 class="nombre_area">Nombre del área:</h2> <p>${task.NOMBRE_AREA}</p></div>
            <div><h2 class="nombre_infra">Nombre de la infraestructura:</h2> <p>${task.NOMBRE_INFRAESTRUCTURA}</p></div>
            <label>
              <input type="radio" name="estado-${task.COD_ALERTA}" value="R"> Realizado
            </label>
            <label>
              <input type="radio" name="estado-${task.COD_ALERTA}" value="P"> No Realizado
            </label>
            <label>
              <input type="radio" name="estado-${task.COD_ALERTA}" value="O"> Observación
            </label>
            <textarea class="form-control" id="observacion-${task.COD_ALERTA}" rows="3" style="display: none;"></textarea>
            <button type="button" id="openNestedModalButton" class="btn btn-primary">Postergar</button>
          `,
        icon: "info",
        confirmButtonText: "Aceptar",
        preConfirm: () => {
          return new Promise((resolve) => {
            const realizadoRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="R"]`
            );
            const noRealizadoRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="P"]`
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
                ? "P"
                : "O";

              const observacion = observacionRadio.checked
                ? document.querySelector(`#observacion-${task.COD_ALERTA}`)
                    .value
                : "";

              $.ajax({
                url: "./php/checkbox-confirma.php",
                method: "POST",
                data: {
                  estado: estado,
                  observacion: observacion,
                  taskId: task.COD_ALERTA,
                },
                dataType: "json",
              })
                .done(function (response) {
                  console.log(response);

                  if (estado === "P") {
                    const nuevaFechaTotal = new Date();

                    $.ajax({
                      url: "./php/insertar-alertaInterDiario.php",
                      method: "POST",
                      data: {
                        fechaCreacion: nuevaFechaTotal.toISOString(),
                        codInfraestructura: task.COD_INFRAESTRUCTURA,
                      },
                      dataType: "json",
                    })
                      .done(function (insertResponse) {
                        console.log(insertResponse);
                        resolve();
                      })
                      .fail(function (insertError) {
                        console.error(insertError);
                        resolve();
                      });
                  } else {
                    resolve();
                  }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                  console.error(textStatus, errorThrown);
                  resolve();
                });
            } else {
              Swal.showValidationMessage(
                "Selecciona si la tarea se realizó o no."
              );
              resolve();
            }
          });
        },
        // didOpen: () => {
        //   const openNestedModalButton = document.getElementById(
        //     "openNestedModalButton"
        //   );
        //   openNestedModalButton.addEventListener("click", () => {
        //     Swal.fire({
        //       title: "AGREGAR DIAS DE POSTERGO",
        //       html: `
        //         <div><h2 class="nombre_area">Nombre del área:</h2> <p>${task.NOMBRE_AREA}</p></div>
        //         <div><h2 class="nombre_infra">Nombre de la infraestructura:</h2> <p>${task.NOMBRE_INFRAESTRUCTURA}</p></div>
        //         <label>Dias para agregar:</label>
        //         <div><input type="text" class="diasAgregar"></div>`,
        //       icon: "info",
        //       confirmButtonText: "Aceptar",
        //       showCloseButton: true,
        //       onClose: () => {
        //         const nextIndex = index + 1;
        //         mostrarAlertas(data, nextIndex);
        //       },
        //     });
        //   });
        // },
      });

      const observacionRadio = document.querySelector(
        `input[name="estado-${task.COD_ALERTA}"][value="O"]`
      );
      const observacionTextarea = document.querySelector(
        `#observacion-${task.COD_ALERTA}`
      );
      const postergarButton = document.getElementById("openNestedModalButton");
      postergarButton.style.display = "none";

      observacionRadio.addEventListener("change", function () {
        observacionTextarea.style.display = this.checked ? "block" : "none";
        postergarButton.style.display = this.checked ? "block" : "none";
      });

      const noRealizadoRadio = document.querySelector(
        `input[name="estado-${task.COD_ALERTA}"][value="P"]`
      );
      noRealizadoRadio.addEventListener("change", function () {
        observacionTextarea.style.display = "none";
        postergarButton.style.display = "none";
      });

      const realizadoRadio = document.querySelector(
        `input[name="estado-${task.COD_ALERTA}"][value="R"]`
      );
      realizadoRadio.addEventListener("change", function () {
        observacionTextarea.style.display = "none";
        postergarButton.style.display = "none";
      });
    }

    $.ajax({
      url: "php/fecha-alertaSemanal.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        mostrarAlertas(data, 0); // Iniciar la secuencia de alertas
      },
    });
  }

  function alertaMenor6Dias() {
    function mostrarAlertas(data, index) {
      if (index >= data.length) {
        return;
      }

      const task = data[index];
      const ndias = task.NDIAS;

      if (ndias > 1 && ndias < 6) {
        Swal.fire({
          title: "Información",
          html: `
            <div class="COD_ALERTA">ID COD_ALERTA: ${task.COD_ALERTA}</div>
            <div class="fecha-creacion">NDIAS: ${ndias}</div>
            <div class="cod-infraestructura">Nombre infraestructura: ${task.COD_INFRAESTRUCTURA}</div>
            <div class="fecha-creacion">Fecha de creación: ${task.FECHA_CREACION}</div>
            <div class="fecha-total">Fecha total: ${task.FECHA_TOTAL}</div>
            <div class="fecha-acordar">Fecha acordar: ${task.FECHA_ACORDAR}</div>
            <label>
              <input type="radio" name="estado-${task.COD_ALERTA}" value="R"> Realizado
            </label>
            <label>
              <input type="radio" name="estado-${task.COD_ALERTA}" value="P"> No Realizado
            </label>
            <label>
              <input type="radio" name="estado-${task.COD_ALERTA}" value="O"> Observación
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
              `input[name="estado-${task.COD_ALERTA}"][value="P"]`
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
                ? "P"
                : "O";

              const observacion = observacionRadio.checked
                ? document.querySelector(`#observacion-${task.COD_ALERTA}`)
                    .value
                : "";

              return $.ajax({
                url: "./php/checkbox-confirma.php",
                method: "POST",
                data: {
                  estado: estado,
                  observacion: observacion,
                  taskId: task.COD_ALERTA,
                },
                dataType: "json",
              })
                .done(function (response) {
                  console.log(response);
                  mostrarAlertas(data, index + 1);
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
          `input[name="estado-${task.COD_ALERTA}"][value="P"]`
        );
        noRealizadoRadio.addEventListener("change", function () {
          observacionTextarea.style.display = this.checked ? "none" : "none";
        });

        const realizadoRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA}"][value="R"]`
        );
        realizadoRadio.addEventListener("change", function () {
          observacionTextarea.style.display = this.checked ? "none" : "none";
        });
      } else {
        mostrarAlertas(data, index + 1);
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
  }

  function ejemploAlertaRadioButtonConHora() {
    // function mostrarAlertas(data, index) {
    //   if (index >= data.length) {
    //     // Todas las alertas han sido mostradas, detener la recursión
    //     return;
    //   }

    //   const task = data[index];

    //   Swal.fire({
    //     title: "Información",
    //     html: `
    //       <div class="COD_ALERTA">ID COD_ALERTA: ${task.COD_ALERTA}</div>
    //       <div class="cod-infraestructura">Nombre infraestructura: ${task.COD_INFRAESTRUCTURA}</div>
    //       <div class="fecha-creacion">Fecha de creación: ${task.FECHA_CREACION}</div>
    //       <div class="fecha-total">Fecha total: ${task.FECHA_TOTAL}</div>
    //       <div class="fecha-acordar">Fecha acordar: ${task.FECHA_ACORDAR}</div>
    //       <label>
    //         <input type="checkbox" id="realizado-${task.COD_ALERTA}" name="estado" value="T"> Realizado
    //       </label>
    //       <label>
    //         <input type="checkbox" id="no-realizado-${task.COD_ALERTA}" name="estado" value="P"> No Realizado
    //       </label>
    //     `,
    //     icon: "info",
    //     confirmButtonText: "Aceptar",
    //     preConfirm: () => {
    //       const realizadoCheckbox = document.getElementById(
    //         `realizado-${task.COD_ALERTA}`
    //       );
    //       const noRealizadoCheckbox = document.getElementById(
    //         `no-realizado-${task.COD_ALERTA}`
    //       );
    //       const estado = realizadoCheckbox.checked
    //         ? "T"
    //         : noRealizadoCheckbox.checked
    //         ? "P"
    //         : null;

    //       if (estado !== null) {
    //         return $.ajax({
    //           url: "./php/checkbox-confirma.php",
    //           method: "POST",
    //           data: { estado: estado, taskId: task.COD_ALERTA },
    //           dataType: "json",
    //         })
    //           .done(function (response) {
    //             console.log(response);
    //             mostrarAlertas(data, index + 1); // Mostrar la siguiente alerta recursivamente
    //           })
    //           .fail(function (jqXHR, textStatus, errorThrown) {
    //             console.error(textStatus, errorThrown);
    //           });
    //       } else {
    //         Swal.showValidationMessage(
    //           "Selecciona si la tarea se realizó o no."
    //         );
    //       }
    //     },
    //   });
    // }

    // $.ajax({
    //   url: "php/fecha-alerta.php",
    //   method: "GET",
    //   dataType: "json",
    //   success: function (data) {
    //     mostrarAlertas(data, 0); // Iniciar la secuencia de alertas
    //   },
    // });

    // function mostrarAlertas(data, index) {
    //   if (index >= data.length) {
    //     return;
    //   }

    //   const task = data[index];

    //   Swal.fire({
    //     title: "Información",
    //     html: `
    //       <div class="COD_ALERTA">ID COD_ALERTA: ${task.COD_ALERTA}</div>
    //       <div class="cod-infraestructura">Nombre infraestructura: ${task.COD_INFRAESTRUCTURA}</div>
    //       <div class="fecha-creacion">Fecha de creación: ${task.FECHA_CREACION}</div>
    //       <div class="fecha-total">Fecha total: ${task.FECHA_TOTAL}</div>
    //       <div class="fecha-acordar">Fecha acordar: ${task.FECHA_ACORDAR}</div>
    //       <label>
    //         <input type="radio" name="estado-${task.COD_ALERTA}" value="T"> Realizado
    //       </label>
    //       <label>
    //         <input type="radio" name="estado-${task.COD_ALERTA}" value="P"> No Realizado
    //       </label>
    //     `,
    //     icon: "info",
    //     confirmButtonText: "Aceptar",
    //     preConfirm: () => {
    //       const realizadoRadio = document.querySelector(
    //         `input[name="estado-${task.COD_ALERTA}"][value="T"]`
    //       );
    //       const noRealizadoRadio = document.querySelector(
    //         `input[name="estado-${task.COD_ALERTA}"][value="P"]`
    //       );

    //       if (realizadoRadio.checked || noRealizadoRadio.checked) {
    //         const estado = realizadoRadio.checked ? "T" : "P";

    //         return $.ajax({
    //           url: "./php/checkbox-confirma.php",
    //           method: "POST",
    //           data: { estado: estado, taskId: task.COD_ALERTA },
    //           dataType: "json",
    //         })
    //           .done(function (response) {
    //             console.log(response);
    //             mostrarAlertas(data, index + 1);
    //           })
    //           .fail(function (jqXHR, textStatus, errorThrown) {
    //             console.error(textStatus, errorThrown);
    //           });
    //       } else {
    //         Swal.showValidationMessage(
    //           "Selecciona si la tarea se realizó o no."
    //         );
    //       }
    //     },
    //   });
    // }

    // $.ajax({
    //   url: "php/fecha-alerta.php",
    //   method: "GET",
    //   dataType: "json",
    //   success: function (data) {
    //     mostrarAlertas(data, 0); // Iniciar la secuencia de alertas
    //   },
    // });

    function mostrarAlertas(data, index) {
      if (index >= data.length) {
        return;
      }

      const task = data[index];

      // Obtener la fecha y hora actual
      const currentDate = new Date();
      // Establecer la fecha y hora objetivo a las 9:15 am
      const targetDate = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth(),
        currentDate.getDate(),
        9,
        15,
        0
      );

      // Si la hora actual es posterior a la hora objetivo, establecer la hora objetivo para el día siguiente
      if (currentDate > targetDate) {
        targetDate.setDate(targetDate.getDate() + 1);
      }

      // Calcular el tiempo en milisegundos hasta la hora objetivo
      const timeUntilTarget = targetDate.getTime() - currentDate.getTime();

      // Mostrar la alerta después de cierto tiempo (timeUntilTarget)
      setTimeout(() => {
        Swal.fire({
          title: "Información",
          html: `
            <div class="COD_ALERTA">ID COD_ALERTA: ${task.COD_ALERTA}</div>
            <div class="cod-infraestructura">Nombre infraestructura: ${task.COD_INFRAESTRUCTURA}</div>
            <div class="fecha-creacion">Fecha de creación: ${task.FECHA_CREACION}</div>
            <div class="fecha-total">Fecha total: ${task.FECHA_TOTAL}</div>
            <div class="fecha-acordar">Fecha acordar: ${task.FECHA_ACORDAR}</div>
            <label>
              <input type="radio" name="estado-${task.COD_ALERTA}" value="T"> Realizado
            </label>
            <label>
              <input type="radio" name="estado-${task.COD_ALERTA}" value="P"> No Realizado
            </label>
          `,
          icon: "info",
          confirmButtonText: "Aceptar",
          preConfirm: () => {
            const realizadoRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="T"]`
            );
            const noRealizadoRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="P"]`
            );

            if (realizadoRadio.checked || noRealizadoRadio.checked) {
              const estado = realizadoRadio.checked ? "T" : "P";

              return $.ajax({
                url: "./php/checkbox-confirma.php",
                method: "POST",
                data: { estado: estado, taskId: task.COD_ALERTA },
                dataType: "json",
              })
                .done(function (response) {
                  console.log(response);
                  mostrarAlertas(data, index + 1);
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                  console.error(textStatus, errorThrown);
                });
            } else {
              Swal.showValidationMessage(
                "Selecciona si la tarea se realizó o no."
              );
            }
          },
        });
      }, timeUntilTarget);
    }

    $.ajax({
      url: "php/fecha-alerta.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        mostrarAlertas(data, 0); // Iniciar la secuencia de alertas
      },
    });
  }

  function alertaMensaje() {
    function mostrarMensaje(data, index) {
      if (index >= data.length) {
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

      console.log(fechaTotal);
      console.log(fechaActual);
      console.log(diferenciaMilisegundos / milisegundosEnUnDia);

      Swal.fire({
        title: "Mensaje recordatorio",
        html: ` <div><h2 class="nombre_area">Nombre del área:</h2> <p>${task.NOMBRE_AREA}</p></div>
                <div><h2 class="nombre_infra">Nombre de la infraestructura:</h2> <p>${task.NOMBRE_INFRAESTRUCTURA}</p></div>
                <div><h2 class="nombre_infra">Faltan </h2> <p>${diferenciaDias} días</p></div>
                `,
        icon: "info",
        confirmButtonText: "Aceptar",
        allowOutsideClick: false,
      });
    }
    $.ajax({
      url: "php/fecha-alerta-mensaje.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        mostrarMensaje(data, 0);
      },
    });
  }

  function alerta() {
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
        <div><h2 class="nombre_infra">COD_ALERTA:</h2> <p>${task.COD_ALERTA}</p></div>
        <label>
          <input type="radio" name="estado-${task.COD_ALERTA}" value="R"> Realizado
        </label>
        <label>
          <input type="radio" name="estado-${task.COD_ALERTA}" value="T"> No Realizado
        </label>
        <div>
          <input type="radio" name="estado-${task.COD_ALERTA}" value="O"><label id="observacion">Observación</label> 
        </div>
        <textarea class="form-control" id="observacion-${task.COD_ALERTA}" rows="3" style="display: none;"></textarea>
        `,
        icon: "info",
        confirmButtonText: "Aceptar",
        allowOutsideClick: false,

        preConfirm: () => {
          const realizadoRadio = document.querySelector(
            `input[name="estado-${task.COD_ALERTA}"][value="R"]`
          );
          const noRealizadoRadio = document.querySelector(
            `input[name="estado-${task.COD_ALERTA}"][value="T"]`
          );

          if (realizadoRadio.checked || noRealizadoRadio.checked) {
            const estado = realizadoRadio.checked ? "R" : "T";

            //Actualizo mi estado T o R
            return $.ajax({
              url: "./php/checkbox-confirma.php",
              method: "POST",
              data: {
                estado: estado,
                taskId: task.COD_ALERTA,
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
      const obs = document.getElementById("observacion");
      realizadoRadio.addEventListener("change", function () {
        observacionTextarea.style.display = "none";
      });
      if (task.NDIAS > 6) {
        observacionRadio.style.display = "block";
      } else {
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
  }

  function alertaModal() {
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
              ? document.querySelector(`#observacion-${task.COD_ALERTA}`).value
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
  }

  // function ejemploAlertaDeCheckBoxConUno() {
  //   $.ajax({
  //     url: "php/fecha-alerta.php",
  //     method: "GET",
  //     dataType: "json",
  //     success: function (data) {
  //       showNextAlert(data, 0); // Iniciar la secuencia de alertas desde el primer elemento
  //     },
  //   });

  //   function showNextAlert(data, index) {
  //     if (index >= data.length) {
  //       // Todas las alertas se han mostrado, salir de la función recursiva
  //       return;
  //     }

  //     let task = data[index];

  //     Swal.fire({
  //       title: "Información",
  //       html: `<input type="text" id="COD_ALERTA" value="${task.COD_ALERTA}">
  //                <div class="cod-infraestructura">Nombre infraestructura: ${task.COD_INFRAESTRUCTURA}</div>
  //                <div class="fecha-creacion">Fecha de creación: ${task.FECHA_CREACION}</div>
  //                <div class="fecha-total">Fecha total: ${task.FECHA_TOTAL}</div>
  //                <div class="fecha-acordar">Fecha acordar: ${task.FECHA_ACORDAR}</div>
  //                <input type="checkbox" id="checkRealizado" name="checkRealizado"> ¿Se realizó?`,
  //       icon: "info",
  //       confirmButtonText: "Confirmar",
  //     }).then((result) => {
  //       if (result.isConfirmed) {
  //         let COD_ALERTA = document.getElementById("COD_ALERTA").value;
  //         let realizado = document.getElementById("checkRealizado").checked;

  //         $.ajax({
  //           url: "./php/checkbox-confirma.php",
  //           method: "POST",
  //           data: {
  //             realizado: realizado,
  //             COD_ALERTA: COD_ALERTA,
  //           },
  //           dataType: "Json",
  //           success: function (response) {
  //             console.log(response);
  //             if (response.status === "success") {
  //               Swal.fire("Éxito", response.message, "success");
  //             } else {
  //               Swal.fire("Error", response.message, "error");
  //             }

  //             // Mostrar la siguiente alerta después de que se resuelva la actual
  //             showNextAlert(data, index + 1);
  //           },
  //           error: function () {
  //             Swal.fire(
  //               "Error",
  //               "Ocurrió un error al enviar los datos",
  //               "error"
  //             );

  //             // Mostrar la siguiente alerta después de que se resuelva la actual
  //             showNextAlert(data, index + 1);
  //           },
  //         });
  //       } else {
  //         // Mostrar la siguiente alerta sin realizar ninguna acción
  //         showNextAlert(data, index + 1);
  //       }
  //     });
  //   }
  // }
  // $(document).on("change", "#checkRealizado", function () {
  //   if (this.checked) {
  //     Swal.close(); // Cerrar la alerta si se marca como realizado
  //   }
  // });
});
