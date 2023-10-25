$(function () {
  async function executeAlerts() {
    try {
      await alertaMensaje();
    } catch (error) {
      console.error("Error executing alertaMensaje():");
    }

    try {
      await alerta();
    } catch (error) {
      console.error("Error executing alerta():");
    }

    try {
      await alertaControl();
    } catch (error) {
      console.error("Error executing alertaControl():");
    }
    try {
      await alertaOrdenCompra();
    } catch (error) {
      console.error("Error executing alertaORdenCompra");
    }

    console.log("All alert functions executed!");
  }

  async function alertaMensaje() {
    return new Promise(function (resolve, reject) {
      function mostrarMensaje(datas, index) {
        if (index >= datas.length) {
          resolve();
          return;
        }

        const task = datas[index];

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
        // console.log("FECHA_TOTAL: " + fecha);
        // console.log("FECHA_ACTUAL: " + fechaTotal);
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
          mostrarMensaje(datas, index + 1);
        });
      }
      const accion = "fechaalertamensaje";
      $.ajax({
        url: "../control_alimento/c_almacen.php",
        // url: "./c_almacen.php",
        method: "POST",
        dataType: "text",
        data: { accion: accion },
        success: function (data) {
          // console.log(data);
          const datas = JSON.parse(data);
          if (datas.length > 0) {
            mostrarMensaje(datas, 0);
          } else {
            resolve();
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error(
            "Error in alertaMensaje AJAX:",
            textStatus,
            errorThrown
          );
          reject(errorThrown);
        },
      });
    });
  }

  async function alerta() {
    return new Promise(function (resolve, reject) {
      function mostrarAlertas(datass, index) {
        if (index >= datass.length) {
          resolve();
          return;
        }

        const task = datass[index];

        let accionCorrectiva;
        let selectVerificacion;

        Swal.fire({
          title: "Información LBS-PHS-FR-01",
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
              <label class='estilolabel'>
                <input type="radio" name="estado-${task.COD_ALERTA}" value="R"> Realizado
              </label>
              <!-- <label class='estilolabel'>
                 <input type="radio" name="estado-${task.COD_ALERTA}" value="NR"> No Realizado
               </label> -->
              <label class='estilolabel'>
              <input type="radio" name="estado-${task.COD_ALERTA}" value="OB"> Observación
              </label>
              <label class='estilolabel' id="postergacion">
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
            // const noRealizadoRadio = document.querySelector(
            //   `input[name="estado-${task.COD_ALERTA}"][value="NR"]`
            // );
            const observacionButtonRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="OB"]`
            );
            const postergacionRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="PO"]`
            );

            if (
              realizadoRadio.checked ||
              // noRealizadoRadio.checked ||
              observacionButtonRadio.checked ||
              postergacionRadio.checked
            ) {
              const estado = realizadoRadio.checked
                ? "R"
                : // : noRealizadoRadio.checked
                // ? "NR"
                observacionButtonRadio.checked
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
                $("#myModalExito").modal("show");

                return Promise.resolve();
              }
              const accion = "actualizaalerta";
              return $.ajax({
                url: "../control_alimento/c_almacen.php",
                // url: "./c_almacen.php",
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
                  // console.log(response);
                  mostrarAlertas(datass, index + 1);

                  // Crea una nueva alerta con la fecha total
                  const nuevaFechaTotal = new Date();
                  const accion = "insertaralertamix";
                  return $.ajax({
                    url: "../control_alimento/c_almacen.php",
                    // url: "./c_almacen.php",
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
            const postergacionRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA}"][value="PO"]`
            );
            const observacionTextarea = document.querySelector(
              `#observacion-${task.COD_ALERTA}`
            );

            if (postergacionRadio.checked) {
              /*abrir modal al darle aceptar */
              $("#myModalExito").modal("show");
              // Resolves the promise to confirm the action
              Promise.resolve().then(() => {
                observacionTextarea.style.display = "block";
                const realizadoRadio = document.querySelector(
                  `input[name="estado-${task.COD_ALERTA}"][value="R"]`
                );
                // const noRealizadoRadio = document.querySelector(
                //   `input[name="estado-${task.COD_ALERTA}"][value="NR"]`
                // );

                realizadoRadio.checked = false;
                // noRealizadoRadio.checked = false;

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
                    url: "../control_alimento/c_almacen.php",
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
                      // console.log(response);
                      $("#myModalExito").modal("hide");
                      mostrarAlertas(data, index + 1);

                      // Crea una nueva alerta con la fecha total
                      const nuevaFechaTotal = new Date();
                      const accion = "insertaralertamix";
                      // Insertar nueva alerta con la fecha total utilizando una solicitud AJAX
                      $.ajax({
                        url: "../control_alimento/c_almacen.php",
                        // url: "./c_almacen.php",
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

        // const noRealizadoRadio = document.querySelector(
        //   `input[name="estado-${task.COD_ALERTA}"][value="NR"]`
        // );
        // noRealizadoRadio.addEventListener("change", function () {
        //   observacionTextarea.style.display = this.checked ? "block" : "none";
        // });

        const realizadoRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA}"][value="R"]`
        );
        realizadoRadio.addEventListener("change", function () {
          observacionTextarea.style.display = this.checked ? "block" : "none";
        });
        const obs = document.getElementById("postergacion");

        // if (task.NDIAS > 6 && task.POSTERGACION == "NO") {
        //     postergacionRadio.style.display = "block";
        //     realizadoRadio.addEventListener("change", function () {
        //       observacionTextarea.style.display = "block";
        //     });
        //     noRealizadoRadio.addEventListener("change", function () {
        //       observacionTextarea.style.display = "block";
        //     });
        //     console.log(task.POSTERGACION);
        //   } else {
        //     if (task.POSTERGACION == "SI") {
        //       realizadoRadio.addEventListener("change", function () {
        //         observacionTextarea.style.display = "block";
        //       });
        //       noRealizadoRadio.addEventListener("change", function () {
        //         observacionTextarea.style.display = "block";
        //       });
        //     }
        //     postergacionRadio.style.display = "none";
        //     obs.style.visibility = "hidden";
        //   }
      }
      const accion = "fechaalerta";
      $.ajax({
        url: "../control_alimento/c_almacen.php",
        // url: "./c_almacen.php",
        method: "POST",
        dataType: "text",
        data: { accion: accion },
        success: function (data) {
          const datass = JSON.parse(data);
          mostrarAlertas(datass, 0);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Error in alerta AJAX:", textStatus, errorThrown);
          reject(errorThrown);
        },
      });
    });
  }

  async function alertaControl() {
    return new Promise(function (resolve, reject) {
      function mostrarAlertasControl(dato, index) {
        if (index >= dato.length) {
          resolve();
          return;
        }

        const task = dato[index];

        Swal.fire({
          title: "Información de LBS-PHS-FR-03",
          icon: "info",
          html: `
            <div>
              <h2>Area:</h2>
              <p>${task.NOMBRE_T_ZONA_AREAS}</p>
            </div>
            <div>
            <h2>Maquina, equipos y utensilios de trabajo:</h2>
            <p>${task.NOMBRE_CONTROL_MAQUINA}</p>
            </div>
            <div>
            <p>Accion Correctiva:</p>
            <textarea class="form-control" id="accionCorrectiva" rows='3' "></textarea>
            </div>
            <label>
              <input type="radio" name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}" value="R"> Realizado
            </label>
            <label>
              <input type="radio" name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}" value="NR"> No Realizado
            </label>
            <textarea class="form-control" rows="3" id="observacion-${task.COD_ALERTA_CONTROL_MAQUINA}" rows="3" style="display: none;"></textarea>
          `,
          allowOutsideClick: false,
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Aceptar',
          preConfirm: () => {
            const realizadoRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="R"]`
            );
            const noRealizadoRadio = document.querySelector(
              `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="NR"]`
            );

            if (realizadoRadio.checked || noRealizadoRadio.checked) {
              const estado = realizadoRadio.checked ? "R" : "NR";
              const observacionTextArea = document.getElementById(
                `observacion-${task.COD_ALERTA_CONTROL_MAQUINA}`
              ).value;
              let accionCorrectiva =
                document.getElementById("accionCorrectiva").value;

              const accion = "actualizaalertacontrol";
              $.ajax({
                url: "../control_alimento/c_almacen.php",
                // url: "./c_almacen.php",
                method: "POST",
                data: {
                  accion: accion,
                  estado: estado,
                  taskId: task.COD_ALERTA_CONTROL_MAQUINA,
                  accionCorrectiva: accionCorrectiva,
                  observacionTextArea: observacionTextArea,
                },
                dataType: "json",
              });

              const accioninsertar = "insertaralertamixcontrolmaquina";

              $.ajax({
                url: "../control_alimento/c_almacen.php",
                // url: "./c_almacen.php",
                method: "POST",
                data: {
                  accion: accioninsertar,
                  codControlMaquina: task.COD_CONTROL_MAQUINA,
                  taskNdias: task.N_DIAS_POS,
                },
                dataType: "json",
                success: function (response) {
                  console.log("Second AJAX request success!");
                },
                // error: function (error) {
                //   console.error("Second AJAX request error:", error);
                // },
              });
            }
          },
        }).then((result) => {
          if (result.isConfirmed) {
            mostrarAlertasControl(dato, index + 1);
          }
        });

        const observacionTextarea = document.querySelector(
          `#observacion-${task.COD_ALERTA_CONTROL_MAQUINA}`
        );

        // const accioncorrectivaTextarea = document.querySelector(
        //   `#accioncorrectiva-${task.COD_ALERTA_CONTROL_MAQUINA}`
        // );

        const noRealizadoRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="NR"]`
        );
        noRealizadoRadio.addEventListener("change", function () {
          observacionTextarea.style.display = this.checked ? "block" : "none";
        });

        const realizadoRadio = document.querySelector(
          `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="R"]`
        );
        realizadoRadio.addEventListener("change", function () {
          observacionTextarea.style.display = this.checked ? "block" : "none";
        });
      }

      const accion = "fechaalertacontrol";
      $.ajax({
        url: "../control_alimento/c_almacen.php",
        // url: "./c_almacen.php",
        method: "POST",
        dataType: "text",
        data: { accion: accion },
        success: function (data) {
          // console.log(data);
          const dato = JSON.parse(data);
          const index = 0;
          mostrarAlertasControl(dato, index);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error(
            "Error in alertaControl AJAX:",
            textStatus,
            errorThrown
          );
          reject(errorThrown);
        },
      });
    });
  }
  // async function alertaOrdenCompra() {
  //   const accion = "mostrarordencompraalmacenalerta";
  //   var codrequerimiento, codordencompra;
  //   $.ajax({
  //     url: "../control_alimento/c_almacen.php",
  //     // url: "./c_almacen.php",
  //     type: "POST",
  //     data: { accion: accion },
  //     success: function (response) {
  //       let task = JSON.parse(response);
  //       console.log(task);
  //       codrequerimiento = task[0].COD_TMPREQUERIMIENTO;
  //       codordencompra = task[0].COD_ORDEN_COMPRA;

  //       let htmlContent = "<h1>¡Listo para producción!</h1>";
  //       htmlContent += "<ul>";
  //       task.forEach(function (producto) {
  //         htmlContent +=
  //           "<li style='list-style:none;'>" + producto.ABR_PRODUCTO + "</li>";
  //       });
  //       htmlContent += "</ul>";
  //       Swal.fire({
  //         title: "Compra de insumos",
  //         icon: "question",
  //         html: htmlContent,
  //         confirmButtonText: "Ok",
  //         showCloseButton: true,
  //       }).then((result) => {
  //         if (result.isConfirmed) {
  //           const accion = "actualizarrequerimientoitem";
  //           $.ajax({
  //             url: "../control_alimento/c_almacen.php",
  //             // url: "./c_almacen.php",
  //             type: "POST",
  //             data: {
  //               accion: accion,
  //               codrequerimiento: codrequerimiento,
  //               codordencompra: codordencompra,
  //             },
  //             success: function (response) {
  //               console.log("se actualizo");
  //             },
  //           });
  //         }
  //       });
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error al cargar los datos de la tabla:", error);
  //     },
  //   });
  // }
  async function alertaOrdenCompra() {
    return new Promise((resolve, reject) => {
      const accion = "mostrarordencompraalmacenalerta";
      var codrequerimiento, codordencompra;

      $.ajax({
        url: "../control_alimento/c_almacen.php",
        type: "POST",
        data: { accion: accion },
        success: function (response) {
          if (response > 0) {
            let task = JSON.parse(response);

            codrequerimiento = task[0].COD_TMPREQUERIMIENTO;
            codordencompra = task[0].COD_ORDEN_COMPRA;

            let htmlContent = "<h1>¡Listo para producción!</h1>";
            htmlContent += "<ul>";
            task.forEach(function (producto) {
              htmlContent +=
                "<li style='list-style:none;'>" +
                producto.ABR_PRODUCTO +
                "</li>";
            });
            htmlContent += "</ul";
            Swal.fire({
              title: "Compra de insumos",
              icon: "question",
              html: htmlContent,
              confirmButtonText: "Ok",
              showCloseButton: true,
            }).then((result) => {
              if (result.isConfirmed) {
                const accion = "actualizarrequerimientoitem";
                $.ajax({
                  url: "../control_alimento/c_almacen.php",
                  type: "POST",
                  data: {
                    accion: accion,
                    codrequerimiento: codrequerimiento,
                    codordencompra: codordencompra,
                  },
                  success: function (response) {
                    resolve("La actualización se realizó con éxito");
                  },
                  error: function (xhr, status, error) {
                    console.error(
                      "Error al cargar los datos de la tabla:",
                      error
                    );
                    reject("Error al actualizar");
                  },
                });
              } else {
                reject("El usuario no confirmó la acción");
              }
            });
          } else {
            console.log("vacio");
          }
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar los datos de la tabla:", error);
          reject("Error al cargar datos de la tabla");
        },
      });
    });
  }

  executeAlerts();
});
