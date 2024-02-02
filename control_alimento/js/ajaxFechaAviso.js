// var valor;
$(function () {
  window.onload = function () {
    fadeout();
  };

  function fadeout() {
    document.querySelector(".preloader").style.opacity = "0";
    document.querySelector(".preloader").style.display = "none";
  }
  async function executeAlerts() {
    // try {
    //   await alertaMensaje();
    // } catch (error) {
    //   console.error("Error executing alertaMensaje():");
    // }

    // try {
    //   await alerta();
    // } catch (error) {
    //   console.error("Error executing alerta():");
    // }

    // try {
    //   await alertaControl();
    // } catch (error) {
    //   console.error("Error executing alertaControl():");
    // }
    try {
      await alertaOrdenCompra();
    } catch (error) {
      console.error("Error executing alertaORdenCompra");
    }

    // if (valor == 1) {
    //   swal.close();
    // }
    //valor = postergacionRadio.checked ? 1 : 0;
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
    // return new Promise(function (resolve, reject) {
    //   function mostrarAlertas(datass, index) {
    //     if (index >= datass.length) {
    //       resolve();
    //       return;
    //     }

    //     const task = datass[index];

    //     let accionCorrectiva;
    //     let selectVerificacion;
    //     let selectVB;

    //     Swal.fire({
    //       title: "Información LBS-PHS-FR-01",
    //       html: `
    //           <div><h2 class="nombre_area">Nombre del área:</h2> <p>${task.NOMBRE_AREA}</p></div>
    //           <div><h2 class="nombre_infra">Nombre de la infraestructura:</h2> <p>${task.NOMBRE_INFRAESTRUCTURA}</p></div>
    //             <label class='estilolabel'>
    //                  <input type="radio" name="estado-${task.COD_ALERTA}" value="R"> Realizado
    //             </label>
    //                <!-- <label class='estilolabel'>
    //                     <input type="radio" name="estado-${task.COD_ALERTA}" value="NR"> No Realizado
    //               </label> -->
    //            <label class='estilolabel'>
    //             <input type="radio" name="estado-${task.COD_ALERTA}" value="OB"> Observado
    //            </label>
    //             <label class='estilolabel' id="postergacion">
    //                 <input type="radio" name="estado-${task.COD_ALERTA}" value="PO"> Pendiente
    //             </label>
    //             <h3 class='observaciontext' >Observación</h4>
    //             <textarea class="form-control" id="observacion-${task.COD_ALERTA}" rows="3" style="display: none;"></textarea>

    //           <div>
    //           <h3 class='accioncorrectiva'>Accion correctiva:</h3>
    //           <textarea class="form-control" id="accionCorrectiva" rows='3' "></textarea>
    //           </div>
    //           <div>
    //           <h3 class='verificarealizada'>Verificacion realizada:</h3>
    //            <select id="selectVerificacion" class="form-select selectVerif" style="width:250px; margin-left:140px;" aria-label="Default select example">
    //               <option selected>Seleccione una verificacion</option>
    //               <option value="1">Conforme</option>
    //               <option value="2">No conforme</option>
    //             </select>
    //           </div>
    //           <div>
    //           <h3 class='vb'>V°B°:</h3>
    //            <select id="selectVB" class="form-select selectVerif" style="width:250px; margin-left:140px;" aria-label="Default select example">
    //               <option selected>Seleccione V°B°</option>
    //               <option value="1">J.A.C</option>
    //               <option value="2">A.A.C</option>
    //             </select>
    //           </div>
    //          `,
    //       icon: "info",
    //       width: 600,
    //       allowOutsideClick: false,
    //       confirmButtonText: "Aceptar",
    //       preConfirm: () => {
    //         const realizadoRadio = document.querySelector(
    //           `input[name="estado-${task.COD_ALERTA}"][value="R"]`
    //         );
    //         const observacionButtonRadio = document.querySelector(
    //           `input[name="estado-${task.COD_ALERTA}"][value="OB"]`
    //         );
    //         const postergacionRadio = document.querySelector(
    //           `input[name="estado-${task.COD_ALERTA}"][value="PO"]`
    //         );

    //         if (
    //           realizadoRadio.checked ||
    //           observacionButtonRadio.checked ||
    //           postergacionRadio.checked
    //         ) {
    //           const estado = realizadoRadio.checked
    //             ? "R"
    //             : observacionButtonRadio.checked
    //             ? "OB"
    //             : "PO";

    //           const postergacion = postergacionRadio.checked
    //             ? document.querySelector(`#observacion-${task.COD_ALERTA}`)
    //                 .value
    //             : "";
    //           const observacionTextArea = observacionTextarea.value;

    //           accionCorrectiva =
    //             document.getElementById("accionCorrectiva").value;

    //           selectVerificacion = $(
    //             "#selectVerificacion option:selected"
    //           ).text();

    //           selectVB = $("#selectVB option:selected").text();

    //           if (postergacionRadio.checked) {
    //             $("#myModalExito").modal("show");

    //             return Promise.resolve();
    //           }
    //           const accion = "actualizaalerta";

    //           return $.ajax({
    //             url: "../control_alimento/c_almacen.php",
    //             // url: "./c_almacen.php",
    //             method: "POST",
    //             data: {
    //               accion: accion,
    //               estado: estado,
    //               taskId: task.COD_ALERTA,
    //               taskFecha: task.FECHA_TOTAL,
    //               observacionTextArea: observacionTextArea,
    //               accionCorrectiva: accionCorrectiva,
    //               selectVerificacion: selectVerificacion,
    //               selectVB: selectVB,
    //               codigozonaalerta: task.COD_ZONA,
    //             },
    //             dataType: "json",
    //           })
    //             .done(function (response) {
    //               // console.log(response);
    //               mostrarAlertas(datass, index + 1);

    //               // Crea una nueva alerta con la fecha total
    //               const nuevaFechaTotal = new Date();
    //               const accion = "insertaralertamix";
    //               return $.ajax({
    //                 url: "../control_alimento/c_almacen.php",
    //                 method: "POST",
    //                 data: {
    //                   accion: accion,
    //                   fechaCreacion: nuevaFechaTotal.toISOString(),
    //                   codigozona: task.COD_ZONA,
    //                   codInfraestructura: task.COD_INFRAESTRUCTURA,
    //                   taskNdias: task.NDIAS,
    //                 },
    //                 beforeSend: function () {
    //                   $(".preloader").css("opacity", "1");
    //                   $(".preloader").css("display", "block");
    //                 },
    //                 dataType: "json",
    //                 complete: function () {
    //                   $(".preloader").css("opacity", "0");
    //                   $(".preloader").css("display", "none");
    //                 },
    //               });
    //             })
    //             .fail(function (jqXHR, textStatus, errorThrown) {
    //               console.error(textStatus, errorThrown);
    //             });
    //         } else {
    //           Swal.showValidationMessage(
    //             "Selecciona si la tarea se realizó o no."
    //           );
    //           return false;
    //         }
    //       },
    //     }).then((result) => {
    //       if (result.isConfirmed) {
    //         const postergacionRadio = document.querySelector(
    //           `input[name="estado-${task.COD_ALERTA}"][value="PO"]`
    //         );
    //         const observacionTextarea = document.querySelector(
    //           `#observacion-${task.COD_ALERTA}`
    //         );

    //         if (postergacionRadio.checked) {
    //           /*abrir modal al darle aceptar */
    //           $("#myModalExito").modal("show");
    //           // Resolves the promise to confirm the action
    //           Promise.resolve().then(() => {
    //             observacionTextarea.style.display = "block";
    //             const realizadoRadio = document.querySelector(
    //               `input[name="estado-${task.COD_ALERTA}"][value="R"]`
    //             );
    //             // const noRealizadoRadio = document.querySelector(
    //             //   `input[name="estado-${task.COD_ALERTA}"][value="NR"]`
    //             // );

    //             realizadoRadio.checked = false;
    //             // noRealizadoRadio.checked = false;

    //             // Agregar evento de clic al botón de confirmación dentro del modal
    //             const modalConfirmButton = document.querySelector(
    //               "#myModalExito .confirm-button"
    //             );
    //             modalConfirmButton.addEventListener("click", function () {
    //               // const fechaPostergacion = document.querySelector(
    //               //   "input[name='fecha_postergacion']"
    //               // ).value;
    //               const fechaPostergacion = $("#fecha_postergacion").val();

    //               const observacion = observacionTextarea.value;
    //               const accion = "actualizaalerta";

    //               // Realizar la actualización del estado con "PO" utilizando una solicitud AJAX
    //               $.ajax({
    //                 url: "../control_alimento/c_almacen.php",
    //                 method: "POST",
    //                 data: {
    //                   accion: accion,
    //                   estado: "PO",
    //                   codigozonaalerta: task.COD_ZONA,
    //                   taskId: task.COD_ALERTA,
    //                   taskFecha: task.FECHA_TOTAL,
    //                   observacion: observacion,
    //                   fechaPostergacion: fechaPostergacion,
    //                   accionCorrectiva: accionCorrectiva,
    //                   selectVerificacion: selectVerificacion,
    //                   selectVB: selectVB,
    //                   codigozonaalerta: task.COD_ZONA,
    //                 },
    //                 dataType: "json",
    //               })
    //                 .done(function (response) {
    //                   // console.log(response);
    //                   $("#myModalExito").modal("hide");
    //                   mostrarAlertas(datass, index + 1);

    //                   // Crea una nueva alerta con la fecha total
    //                   const nuevaFechaTotal = new Date();
    //                   const accion = "insertaralertamix";
    //                   // Insertar nueva alerta con la fecha total utilizando una solicitud AJAX
    //                   $.ajax({
    //                     url: "../control_alimento/c_almacen.php",
    //                     // url: "./c_almacen.php",
    //                     method: "POST",
    //                     data: {
    //                       accion: accion,
    //                       fechaCreacion: nuevaFechaTotal.toISOString(),
    //                       codigozona: task.COD_ZONA,
    //                       codInfraestructura: task.COD_INFRAESTRUCTURA,
    //                       taskNdias: task.NDIAS,
    //                       fechaPostergacion: fechaPostergacion,
    //                       accionCorrectiva: accionCorrectiva,
    //                       selectVerificacion: selectVerificacion,
    //                       selectVB: selectVB,
    //                     },
    //                     beforeSend: function () {
    //                       $(".preloader").css("opacity", "1");
    //                       $(".preloader").css("display", "block");
    //                     },
    //                     dataType: "json",
    //                     complete: function () {
    //                       $(".preloader").css("opacity", "0");
    //                       $(".preloader").css("display", "none");
    //                     },
    //                   });
    //                 })
    //                 .fail(function (jqXHR, textStatus, errorThrown) {
    //                   console.error(textStatus, errorThrown);
    //                 });
    //             });
    //           });
    //         } else {
    //           observacionTextarea.style.display = "none";
    //           mostrarAlertas(datass, index + 1);
    //         }
    //       }
    //     });

    //     const accionCorrectivax = document.getElementById("accionCorrectiva");
    //     const selectVerificacionx =
    //       document.getElementById("selectVerificacion");
    //     const postergacionRadio = document.querySelector(
    //       `input[name="estado-${task.COD_ALERTA}"][value="PO"]`
    //     );
    //     const accionvb = document.getElementById("selectVB");
    //     const observacionButtonRadio = document.querySelector(
    //       `input[name="estado-${task.COD_ALERTA}"][value="OB"]`
    //     );

    //     const h3accion = document.querySelector(".accioncorrectiva");
    //     const h3verifica = document.querySelector(".verificarealizada");
    //     const h4obs = document.querySelector(".observaciontext");
    //     const h3vb = document.querySelector(".vb");

    //     const observacionTextarea = document.querySelector(
    //       `#observacion-${task.COD_ALERTA}`
    //     );

    //     observacionTextarea.style.display = "none";
    //     observacionTextarea.style.display = "none";
    //     accionCorrectivax.style.display = "none";
    //     selectVerificacionx.style.display = "none";
    //     accionvb.style.display = "none";
    //     h3accion.style.display = "none";
    //     h3verifica.style.display = "none";
    //     h4obs.style.display = "none";
    //     h3vb.style.display = "none";

    //     postergacionRadio.addEventListener("change", function () {
    //       observacionTextarea.style.display = this.checked ? "block" : "none";
    //       accionCorrectivax.style.display = this.checked ? "block" : "none";
    //       selectVerificacionx.style.display = this.checked ? "block" : "none";
    //       accionvb.style.display = this.checked ? "block" : "none";
    //       h3accion.style.display = this.checked ? "block" : "none";
    //       h3verifica.style.display = this.checked ? "block" : "none";
    //       h4obs.style.display = this.checked ? "block" : "none";
    //       h3vb.style.display = this.checked ? "block" : "none";
    //     });

    //     observacionButtonRadio.addEventListener("change", function () {
    //       observacionTextarea.style.display = this.checked ? "block" : "none";
    //       accionCorrectivax.style.display = this.checked ? "block" : "none";
    //       selectVerificacionx.style.display = this.checked ? "block" : "none";
    //       accionvb.style.display = this.checked ? "block" : "none";
    //       h3accion.style.display = this.checked ? "block" : "none";
    //       h3verifica.style.display = this.checked ? "block" : "none";
    //       h4obs.style.display = this.checked ? "block" : "none";
    //       h3vb.style.display = this.checked ? "block" : "none";
    //     });

    //     const realizadoRadio = document.querySelector(
    //       `input[name="estado-${task.COD_ALERTA}"][value="R"]`
    //     );

    //     realizadoRadio.addEventListener("click", function () {
    //       if (this.checked) {
    //         observacionTextarea.style.display = "none";
    //         accionCorrectivax.style.display = "none";
    //         selectVerificacionx.style.display = "none";
    //         accionvb.style.display = "none";
    //         h3accion.style.display = "none";
    //         h3verifica.style.display = "none";
    //         h4obs.style.display = "none";
    //         h3vb.style.display = "none";
    //       }
    //     });

    //     const obs = document.getElementById("postergacion");
    //   }
    //   const accion = "fechaalerta";
    //   $.ajax({
    //     url: "../control_alimento/c_almacen.php",
    //     method: "POST",
    //     dataType: "text",
    //     data: { accion: accion },
    //     beforeSend: function () {
    //       $(".preloader").css("opacity", "1");
    //       $(".preloader").css("display", "block");
    //     },
    //     success: function (data) {
    //       const datass = JSON.parse(data);
    //       mostrarAlertas(datass, 0);
    //     },
    //     complete: function () {
    //       $(".preloader").css("opacity", "0");
    //       $(".preloader").css("display", "none");
    //     },
    //     error: function (jqXHR, textStatus, errorThrown) {
    //       console.error("Error in alerta AJAX:", textStatus, errorThrown);
    //       reject(errorThrown);
    //     },
    //   });
    // });

    return new Promise(function (resolve, reject) {
      const accion = "fechaalerta";
      $.ajax({
        url: "../control_alimento/c_almacen.php",
        method: "POST",
        dataType: "text",
        data: { accion: accion },
        beforeSend: function () {
          $(".preloader").css("opacity", "1");
          $(".preloader").css("display", "block");
        },
        success: function (data) {
          let datas = JSON.parse(data);
          console.log(datas);
          if (datas == "datossi") {
            $("#modalalertaaviso").modal("show");
          } else if (datas == "datosno") {
            resolve();
          }
          /*---poner resolve para que resuleva la promesa y pase a la siguiente-- */
          // resolve();
          // const areaData = {};

          // for (let i = 0; i < datass.length; i++) {
          //   const rowData = datass[i];

          //   if (!areaData[rowData.NOMBRE_AREA]) {
          //     areaData[rowData.NOMBRE_AREA] = {
          //       NOMBRE_AREA: rowData.NOMBRE_AREA,
          //       INFRAESTRUCTURAS: [],
          //     };
          //   }

          //   areaData[rowData.NOMBRE_AREA].INFRAESTRUCTURAS.push({
          //     NOMBRE_INFRAESTRUCTURA: rowData.NOMBRE_INFRAESTRUCTURA,
          //     NDIAS: rowData.NDIAS,
          //     FECHA_TOTAL: rowData.FECHA_TOTAL,
          //   });
          // }

          // for (const key in areaData) {
          //   if (areaData.hasOwnProperty(key)) {
          //     const rowData = areaData[key];
          //     const rowspan = rowData.INFRAESTRUCTURAS.length;

          //     const nombre = rowData.INFRAESTRUCTURAS[0].NDIAS;
          //     let nombredia = "";
          //     if (nombre == "1") {
          //       nombredia = "Diario";
          //     } else if (nombre == "2") {
          //       nombredia = "Inter-diario";
          //     } else if (nombre == "7") {
          //       nombredia = "Semanal";
          //     } else if (nombre == "15") {
          //       nombredia = "Quincenal";
          //     } else if (nombre == "30") {
          //       nombredia = "Mensual";
          //     }
          //     const fecha = rowData.INFRAESTRUCTURAS[0].FECHA_TOTAL;
          //     var fechaconv = new Date(fecha);
          //     var diaif = fechaconv.getDate() + 1;

          //     let tableRow =
          //       "<tr><td rowspan='" +
          //       rowspan +
          //       "' style='border: 1px solid black;'>" +
          //       rowData.NOMBRE_AREA +
          //       "</td><td style='border: 1px solid black;'>" +
          //       rowData.INFRAESTRUCTURAS[0].NOMBRE_INFRAESTRUCTURA +
          //       "</td><td style='border: 1px solid black;'>" +
          //       // rowData.INFRAESTRUCTURAS[0].NDIAS
          //       nombredia +
          //       "</td>";
          //     for (let col = 4; col <= diamesactual + 4; col++) {
          //       let diasum = diaif + 4;
          //       if (col == diasum) {
          //         tableRow +=
          //           "<td style='border: 1px solid black;background-color:#bda2fa;'><input type='checkbox'/></td>";
          //       } else {
          //         tableRow +=
          //           "<td style='border: 1px solid black;width:15px;'>" +
          //           col +
          //           "</td>";
          //       }
          //     }
          //     tableRow += "</tr>";
          //     // tableRow +=
          //     //   "<td style='border: 1px solid black;'>" + diaif + "</td></tr>";
          //     // "</td><td style='border: 1px solid black;'>" +
          //     // // rowData.INFRAESTRUCTURAS[0].FECHA_TOTAL
          //     // diaif +
          //     // "</td></tr>";

          //     $("#tablaavisoalerta").append(tableRow);

          //     for (let i = 1; i < rowspan; i++) {
          //       var fechaString = rowData.INFRAESTRUCTURAS[i].FECHA_TOTAL;

          //       const nombree = rowData.INFRAESTRUCTURAS[i].NDIAS;
          //       let nombrediaa = "";
          //       if (nombree == "1") {
          //         nombrediaa = "Diario";
          //       } else if (nombree == "2") {
          //         nombrediaa = "Inter-diario";
          //       } else if (nombree == "7") {
          //         nombrediaa = "Semanal";
          //       } else if (nombree == "15") {
          //         nombrediaa = "Quincenal";
          //       } else if (nombree == "30") {
          //         nombrediaa = "Mensual";
          //       }

          //       var fechaObjeto = new Date(fechaString);
          //       var dia = fechaObjeto.getDate() + 1;

          //       let additionalRow =
          //         "<tr><td style='border: 1px solid black;'>" +
          //         rowData.INFRAESTRUCTURAS[i].NOMBRE_INFRAESTRUCTURA +
          //         "</td><td style='border: 1px solid black;'>" +
          //         // rowData.INFRAESTRUCTURAS[i].NDIAS
          //         nombrediaa +
          //         "</td>";
          //       // "<td style='border: 1px solid black;'>" +
          //       // dia +
          //       // "</td>";
          //       for (let a = 4; a <= diamesactual + 4; a++) {
          //         let sum = dia + 4;
          //         if (a == sum) {
          //           additionalRow +=
          //             "<td style='border: 1px solid black;'>a</td>";
          //         } else {
          //           additionalRow +=
          //             "<td style='border: 1px solid black;'></td>";
          //         }
          //       }
          //       additionalRow += "</tr>";
          //       // "</td></tr>";

          //       $("#tablaavisoalerta").append(additionalRow);
          //     }
          //   }
          // }

          // $("#modalalertaaviso").modal("show");
        },
        complete: function () {
          $(".preloader").css("opacity", "0");
          $(".preloader").css("display", "none");
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Error in alerta AJAX:", textStatus, errorThrown);
          reject(errorThrown);
        },
      });
    });
  }

  async function alertaControl() {
    // return new Promise(async function (resolve, reject) {
    //   function mostrarAlertasControl(datacontroles, index) {
    //     if (index >= datacontroles.length) {
    //       resolve();
    //       return;
    //     }
    //     const task = datacontroles[index];
    //     let accionCorrectiva;
    //     let selectVB;
    //     // let postergacionRadio;
    //     Swal.fire({
    //       title: "Información LBS-PHS-FR-03",
    //       html: `
    //           <div><h2 class="nombre_infra">Máquinas,equipos y utensilios:</h2> <p>${task.NOMBRE_CONTROL_MAQUINA}</p></div>
    //             <label class='estilolabel'>
    //                  <input type="radio" name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}" value="R"> Realizado
    //             </label>
    //            <label class='estilolabel'>
    //             <input type="radio" name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}" value="OB"> Observado
    //            </label>
    //             <label class='estilolabel' id="postergacion">
    //                 <input type="radio" name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}" value="PO"> Pendiente
    //             </label>
    //             <h3 class='fechapostergar' style="display: none;">Fecha Postergar</h3>
    //             <input type="date" id="fechapostergacion" style="display: none;width:250px; margin-left:140px;"/>
    //             <h3 class='observaciontext' >Observación</h3>
    //             <textarea class="form-control" id="observacion-${task.COD_ALERTA_CONTROL_MAQUINA}" rows="3" style="display: none;"></textarea>
    //           <div>
    //           <h3 class='accioncorrectiva'>Accion correctiva:</h3>
    //           <textarea class="form-control" id="accionCorrectiva" rows='3' "></textarea>
    //           </div>
    //           <div>
    //           <h3 class='vb'>V°B°:</h3>
    //            <select id="selectVB" class="form-select selectVerif" style="width:250px; margin-left:140px;" aria-label="Default select example">
    //               <option selected>Seleccione V°B°</option>
    //               <option value="1">J.A.C</option>
    //               <option value="2">A.A.C</option>
    //             </select>
    //           </div>
    //          `,
    //       icon: "info",
    //       width: 600,
    //       allowOutsideClick: false,
    //       confirmButtonText: "Aceptar",
    //     }).then((result) => {
    //       if (result.isConfirmed) {
    //         const observacionButtonRadio = document.querySelector(
    //           `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="OB"]`
    //         );
    //         const realizadoRadio = document.querySelector(
    //           `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="R"]`
    //         );
    //         const postergacionRadio = document.querySelector(
    //           `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="PO"]`
    //         );
    //         const observacionTextarea = document.querySelector(
    //           `#observacion-${task.COD_ALERTA_CONTROL_MAQUINA}`
    //         );
    //         const observacionTextAreavalor = observacionTextarea.value;
    //         accionCorrectiva =
    //           document.getElementById("accionCorrectiva").value;
    //         selectVB = $("#selectVB option:selected").text();
    //         const fechapostergacion =
    //           document.getElementById("fechapostergacion").value;
    //         // if (postergacionRadio.checked) {
    //         //   $("#modalcontrolalertas").modal("show");
    //         //   valor = postergacionRadio.checked ? 1 : 0;
    //         //   const modalConfirmButton = document.querySelector(
    //         //     "#modalcontrolalertas .guardar"
    //         //   );
    //         //   modalConfirmButton.addEventListener("click", function () {
    //         //     const fechaPostergacionControl = $(
    //         //       "#fecha_postergacion_control"
    //         //     ).val();
    //         //     const accion = "actualizaalertacontrolpos";
    //         //     $.ajax({
    //         //       url: "../control_alimento/c_almacen.php",
    //         //       method: "POST",
    //         //       data: {
    //         //         accion: accion,
    //         //         estado: "PO",
    //         //         taskId: task.COD_ALERTA_CONTROL_MAQUINA,
    //         //         ndiaspos: task.N_DIAS_POS,
    //         //         taskFecha: task.FECHA_TOTAL,
    //         //         observacionTextArea: observacionTextAreavalor,
    //         //         accionCorrectiva: accionCorrectiva,
    //         //         selectVB: selectVB,
    //         //         codigocontrolmaquina: task.COD_CONTROL_MAQUINA,
    //         //         fechapostergacioncontrol: fechaPostergacionControl,
    //         //       },
    //         //       beforeSend: function () {
    //         //         $(".preloader").css("opacity", "1");
    //         //         $(".preloader").css("display", "block");
    //         //       },
    //         //       dataType: "text",
    //         //     })
    //         //       .done(function (response) {
    //         //         $("#fecha_postergacion_control").val("");
    //         //         $("#modalcontrolalertas").modal("hide");
    //         //         mostrarAlertasControl(datacontroles, index + 1);
    //         //       })
    //         //       .fail(function (jqXHR, textStatus, errorThrown) {
    //         //         console.error("AJAX Error:", textStatus, errorThrown);
    //         //       })
    //         //       .always(function () {
    //         //         $(".preloader").css("opacity", "0");
    //         //         $(".preloader").css("display", "none");
    //         //       });
    //         //   });
    //         // } else {
    //         if (
    //           realizadoRadio.checked ||
    //           observacionButtonRadio.checked ||
    //           postergacionRadio.checked
    //         ) {
    //           const estado = realizadoRadio.checked
    //             ? "R"
    //             : observacionButtonRadio.checked
    //             ? "OB"
    //             : "PO";
    //           const accion = "actualizaalertacontrol";
    //           $.ajax({
    //             url: "../control_alimento/c_almacen.php",
    //             method: "POST",
    //             data: {
    //               accion: accion,
    //               estado: estado,
    //               taskId: task.COD_ALERTA_CONTROL_MAQUINA,
    //               ndiaspos: task.N_DIAS_POS,
    //               taskFecha: task.FECHA_TOTAL,
    //               observacionTextArea: observacionTextAreavalor,
    //               accionCorrectiva: accionCorrectiva,
    //               selectVB: selectVB,
    //               codigocontrolmaquina: task.COD_CONTROL_MAQUINA,
    //               fechapostergacioncontrol: fechapostergacion,
    //             },
    //             beforeSend: function () {
    //               $(".preloader").css("opacity", "1");
    //               $(".preloader").css("display", "block");
    //             },
    //             dataType: "text",
    //           })
    //             .done(function (response) {
    //               mostrarAlertasControl(datacontroles, index + 1);
    //             })
    //             .fail(function (jqXHR, textStatus, errorThrown) {
    //               console.error("AJAX Error:", textStatus, errorThrown);
    //             })
    //             .always(function () {
    //               $(".preloader").css("opacity", "0");
    //               $(".preloader").css("display", "none");
    //             });
    //         }
    //         // }
    //       }
    //     });
    //     const realizadoRadio = document.querySelector(
    //       `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="R"]`
    //     );
    //     const accionCorrectivax = document.getElementById("accionCorrectiva");
    //     const postergacionRadio = document.querySelector(
    //       `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="PO"]`
    //     );
    //     const accionvb = document.getElementById("selectVB");
    //     const fechapostergacion = document.getElementById("fechapostergacion");
    //     const observacionButtonRadio = document.querySelector(
    //       `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="OB"]`
    //     );
    //     const h3accion = document.querySelector(".accioncorrectiva");
    //     const h4obs = document.querySelector(".observaciontext");
    //     const h3vb = document.querySelector(".vb");
    //     const h3fecha = document.querySelector(".fechapostergar");
    //     const observacionTextarea = document.querySelector(
    //       `#observacion-${task.COD_ALERTA_CONTROL_MAQUINA}`
    //     );
    //     observacionTextarea.style.display = "none";
    //     accionCorrectivax.style.display = "none";
    //     h3accion.style.display = "none";
    //     accionvb.style.display = "none";
    //     h4obs.style.display = "none";
    //     h3vb.style.display = "none";
    //     postergacionRadio.addEventListener("click", function () {
    //       observacionTextarea.style.display = this.checked ? "block" : "none";
    //       h4obs.style.display = this.checked ? "block" : "none";
    //       accionCorrectivax.style.display = this.checked ? "block" : "none";
    //       h3accion.style.display = this.checked ? "block" : "none";
    //       accionvb.style.display = this.checked ? "block" : "none";
    //       h3vb.style.display = this.checked ? "block" : "none";
    //       h3fecha.style.display = this.checked ? "block" : "none";
    //       fechapostergacion.style.display = this.checked ? "block" : "none";
    //     });
    //     /*------FECHA BLOQUEAR------------------------------------------- */
    //     var fechaPostergacionInput =
    //       document.getElementById("fechapostergacion");
    //     var fechaActual = new Date();
    //     var fechaMinima = new Date(fechaActual);
    //     fechaMinima.setDate(fechaActual.getDate() + 1);
    //     var fechaMaxima = new Date(fechaActual);
    //     fechaMaxima.setDate(fechaActual.getDate() + 3);
    //     var fechaMinimaString = fechaMinima.toISOString().split("T")[0];
    //     var fechaMaximaString = fechaMaxima.toISOString().split("T")[0];
    //     fechaPostergacionInput.setAttribute("min", fechaMinimaString);
    //     fechaPostergacionInput.setAttribute("max", fechaMaximaString);
    //     /*----------------------------------------------------------*/
    //     observacionButtonRadio.addEventListener("click", function () {
    //       observacionTextarea.style.display = this.checked ? "block" : "none";
    //       h4obs.style.display = this.checked ? "block" : "none";
    //       accionCorrectivax.style.display = this.checked ? "block" : "none";
    //       h3accion.style.display = this.checked ? "block" : "none";
    //       accionvb.style.display = this.checked ? "block" : "none";
    //       h3vb.style.display = this.checked ? "block" : "none";
    //       $("#fechapostergacion").val("");
    //       h3fecha.style.display = "none";
    //       fechapostergacion.style.display = "none";
    //     });
    //     realizadoRadio.addEventListener("click", function () {
    //       if (this.checked) {
    //         observacionTextarea.style.display = "none";
    //         accionCorrectivax.style.display = "none";
    //         accionvb.style.display = "none";
    //         h3accion.style.display = "none";
    //         h4obs.style.display = "none";
    //         h3vb.style.display = "none";
    //         h3fecha.style.display = "none";
    //         fechapostergacion.style.display = "none";
    //         $("#fechapostergacion").val("");
    //       }
    //     });
    //   }
    //   const accion = "fechaalertacontrol";
    //   $.ajax({
    //     url: "../control_alimento/c_almacen.php",
    //     method: "POST",
    //     dataType: "text",
    //     data: { accion: accion },
    //     beforeSend: function () {
    //       $(".preloader").css("opacity", "1");
    //       $(".preloader").css("display", "block");
    //     },
    //     success: function (dataControl) {
    //       const datacontroles = JSON.parse(dataControl);
    //       console.log(datacontroles);
    //       mostrarAlertasControl(datacontroles, 0);
    //     },
    //     complete: function () {
    //       $(".preloader").css("opacity", "0");
    //       $(".preloader").css("display", "none");
    //     },
    //     error: function (jqXHR, textStatus, errorThrown) {
    //       console.error("Error in alerta AJAX:", textStatus, errorThrown);
    //       reject(errorThrown);
    //     },
    //   });
    // });
    return new Promise(function (resolve, reject) {
      const accion = "fechaalertacontrol";
      $.ajax({
        url: "../control_alimento/c_almacen.php",
        method: "POST",
        dataType: "text",
        data: { accion: accion },
        beforeSend: function () {
          $(".preloader").css("opacity", "1");
          $(".preloader").css("display", "block");
        },
        success: function (datacontrol) {
          let datacontroles = JSON.parse(datacontrol);
          console.log(datacontroles);
          if (datacontroles == "controlsi") {
            $("#modalcontrolalertas").modal("show");
          } else if (datacontroles == "controlno") {
            resolve();
          }
        },
        complete: function () {
          $(".preloader").css("opacity", "0");
          $(".preloader").css("display", "none");
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Error in alerta AJAX:", textStatus, errorThrown);
          reject(errorThrown);
        },
      });
    });
  }

  async function alertaOrdenCompra() {
    return new Promise((resolve, reject) => {
      const accion = "mostrarordencompraalmacenalerta";
      var codrequerimiento;
      $.ajax({
        url: "../control_alimento/c_almacen.php",
        type: "POST",
        data: { accion: accion },
        success: function (response) {
          let task = JSON.parse(response);
          console.log(task);
          if (task.length > 0) {
            // let task = JSON.parse(response);
            codrequerimiento = task[0].COD_REQUERIMIENTO;
            let htmlContent = "<h1>¡Lista de productos!</h1>";
            htmlContent += "<table class='tableta'>";
            htmlContent += "<thead>";
            htmlContent += "<tr>";
            htmlContent += "<th style='margin-rigth:15px;'>Codigo</th>";
            htmlContent += "<th style='margin-rigth:15px;'> Producto</th>";
            htmlContent += "<th> Cantidad pedida</th>";
            // htmlContent += "<th> Cantidad llegada</th>";
            htmlContent += "</tr>";
            htmlContent += "</thead>";

            htmlContent += "<tbody id='tbodyordencompra'>";

            task.forEach(function (producto) {
              htmlContent +=
                "<tr codigocompraorde='" +
                producto.COD_ORDEN_COMPRA +
                "'  codtempreque='" +
                producto.COD_REQUERIMIENTOTEMP +
                "'>";
              htmlContent +=
                "<td class='td-producto' codigoproducto='" +
                producto.COD_PRODUCTO +
                "'  codigoproveedororden='" +
                producto.COD_PROVEEDOR +
                "'>" +
                producto.COD_PRODUCCION +
                "</td>";
              htmlContent +=
                "<td class='td-nombre'>" + producto.DES_PRODUCTO + "</td>";
              htmlContent +=
                "<td class='td-cantidad'>" +
                producto.CANTIDAD_INSUMO_ENVASE +
                "</td>";
              // htmlContent +=
              //   "<td>  <input class='form-check-input td-checkbox' type='checkbox' value='' id='checkedvalor' checked></td>";
              htmlContent += "</tr>";
            });
            htmlContent += "</tbody>";
            htmlContent += "</table";
            Swal.fire({
              title: "Compra de insumos",
              icon: "question",
              html: htmlContent,
              confirmButtonText: "Ok",
              showCloseButton: true,
              customClass: {
                popup: "custom-width-class",
              },
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = "controlRecepcion.php";
                // let valoresorden = [];
                // $("#tbodyordencompra tr").each(function () {
                //   let codigocompraorde = $(this).attr("codigocompraorde");
                //   let codtempreque = $(this).attr("codtempreque");
                //   let codigoproductocompra = $(this)
                //     .find("td:eq(0)")
                //     .attr("codigoproducto");
                //   let codigoproveedororden = $(this)
                //     .find("td:eq(0)")
                //     .attr("codigoproveedororden");
                //   let cantidadpedida = $(this).find("td:eq(1)").text();
                //   let cantidadllegada = $(this)
                //     .find("td:eq(2) input:checkbox")
                //     .prop("checked");
                //   valoresorden.push({
                //     codigocompraorde: codigocompraorde,
                //     codtempreque: codtempreque,
                //     codigoproductocompra: codigoproductocompra,
                //     codigoproveedororden: codigoproveedororden,
                //     cantidadpedida: cantidadpedida,
                //     cantidadllegada: cantidadllegada,
                //   });
                // });
                // console.log(valoresorden);
                // const accion = "actualizarrequerimientoitem";
                // $.ajax({
                //   url: "../control_alimento/c_almacen.php",
                //   type: "POST",
                //   data: {
                //     accion: accion,
                //     codrequerimiento: codrequerimiento,
                //     valoresorden: valoresorden,
                //   },
                //   beforeSend: function () {
                //     $(".preloader").css("opacity", "1");
                //     $(".preloader").css("display", "block");
                //   },
                //   success: function (response) {
                //     console.log(response);
                //     resolve("La actualización se realizó con éxito");
                //   },
                //   complete: function () {
                //     $(".preloader").css("opacity", "0");
                //     $(".preloader").css("display", "none");
                //   },
                //   error: function (xhr, status, error) {
                //     console.error(
                //       "Error al cargar los datos de la tabla:",
                //       error
                //     );
                //     reject("Error al actualizar");
                //   },
                // });
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
  alertax();
  alertacontrolaviso();
  executeAlerts();

  function alertax() {
    $("#botonalertaguardar").click(function () {
      let capturavalor = [];
      $("#tablaalerta tr").each(function (index) {
        if (index !== 0) {
          let idzona = $(this).find(".codigozona").val();
          let idinfra = $(this).find(".codigoinfra").val();
          let idalerta = $(this).find(".codigoalerta").val();
          let frecuenciadias = $(this).find(".frecuenciadias").val();
          // let check = $(this).find(".check").prop("checked");
          let estadoseleccion = $(this).find(".seleccionestado").val();
          let obs = $(this).find(".observacion").val();
          let accioncorrecto = $(this).find(".accioncorrectiva").val();
          let selectvb = $(this)
            .find(".selectVerificacion")
            .find("option:selected")
            .text();
          let estadoverifica = $(this).find(".estadoverifica").val();
          let fecha = $(this).find(".fecha").val();

          capturavalor.push({
            idzona: idzona,
            idinfra: idinfra,
            idalerta: idalerta,
            frecuenciadias: frecuenciadias,
            estadoseleccion: estadoseleccion,
            // check: check,
            obs: obs,
            accioncorrecto: accioncorrecto,
            selectvb: selectvb,
            estadoverifica: estadoverifica,
            fecha: fecha,
          });
        }
      });
      console.log(capturavalor);

      let entraajax = true;
      $("#tablaalerta tr").each(function (index) {
        if (index !== 0) {
          let estadoseleccionado = $(this).find(".seleccionestado").val();
          let idcon = $(this).find(".id").attr("idcontador");
          let obs = $(this).find(".observacion").val();
          let accioncorrectox = $(this).find(".accioncorrectiva").val();
          let selectvb = $(this).find(".selectVerificacion").val();

          let estadoverifica = $(this).find(".estadoverifica").val();

          if (estadoseleccionado == "PE" || estadoseleccionado == "OB") {
            if (obs === "" || accioncorrectox === "" || selectvb == null) {
              Swal.fire({
                title: "¡Necesita llenar campos!",
                text: "Verifique el item " + idcon + "",
                icon: "info",
                confirmButtonText: "Aceptar",
              });
              entraajax = false;
              return false;
            }
          } else if (estadoseleccionado == null) {
            Swal.fire({
              title: "¡Necesita seleccionar un estado!",
              text: "Verifique el estado del item " + idcon + "",
              icon: "info",
              confirmButtonText: "Aceptar",
            });
            entraajax = false;
            return false;
          }
        }
      });
      if (entraajax) {
        const accion = "insertaryactualizaralerta";
        $.ajax({
          url: "../control_alimento/c_almacen.php",
          type: "POST",
          data: { accion: accion, capturavalor: capturavalor },
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
                  $("#modalalertaaviso").modal("hide");
                  alertaControl();
                  // $("#formularioZona").trigger("reset");
                }
              });
            } else {
              console.log("error");
            }
          },
          complete: function () {
            $(".preloader").css("opacity", "0");
            $(".preloader").css("display", "none");
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error in alerta AJAX:", textStatus, errorThrown);
            reject(errorThrown);
          },
        });
      }
    });

    /*-----------------------Para deshabilitar cajas de texto al darle check------------ */
    $("#tablaalerta .seleccionestado").on("change", function () {
      let valorSeleccionado = $(this).val();
      let currentRow = $(this).closest("tr");

      if (valorSeleccionado == "R") {
        currentRow
          .find("#observacion, #accioncorrectiva")
          .prop("disabled", true)
          .val("");
        currentRow.find("#selectVerificacion").prop("disabled", true);
        currentRow.find("#selectVerificacion").val("0").trigger("change");
      } else {
        currentRow
          .find("#observacion, #accioncorrectiva")
          .prop("disabled", false)
          .val("");
        currentRow.find("#selectVerificacion").prop("disabled", false);
        currentRow.find("#selectVerificacion").val("0").trigger("change");
      }
    });
    /*------------------------------------------------------------------------------- */
  }
  function alertacontrolaviso() {
    $("#botoncontrolalerta").click(function () {
      let alertaLanzadacontrol = false;

      $("#tablacontrolalerta tr").each(function (index) {
        let checkc = $(this).find(".checkcontrol").prop("checked");
        let obsc = $(this).find(".observacioncontrol").val();
        let accioncorrectoc = $(this).find(".accioncorrectivacontrol").val();
        let selectvbc = $(this).find(".selectVerificacionControl").val();
        let estadoverificacontrolr = $(this)
          .find(".estadoverificacontrol")
          .val();

        if (!checkc || accioncorrectoc.trim() === "" || obsc.trim() === "") {
          if (!alertaLanzadacontrol) {
            Swal.fire({
              icon: "info",
              title: "Rellenar campos",
              text: "Necesita llenar campo observacion o accion correctiva.",
            });
            alertaLanzadacontrol = true;
          }
        }
        if (
          (estadoverificacontrolr =
            ("OB" && accioncorrectoc.trim() === "") || obsc.trim() === "")
        ) {
          if (!alertaLanzadacontrol) {
            Swal.fire({
              icon: "info",
              title: "Rellenar campos",
              text: "Necesita llenar campo observacion o accion correctiva.",
            });
            alertaLanzadacontrol = true;
          }
        }
      });
      let capturavalorcontrol = [];
      $("#tablacontrolalerta tr").each(function () {
        let checkcontro = $(this).find(".checkcontrol").prop("checked");
        let idcontrolalerta = $(this).find(".codigocontrolalerta").val();
        let codigomaquinacontrol = $(this)
          .find(".nombremaquina")
          .attr("idcontrol");
        let frecuenciacontrol = $(this)
          .find(".nombrefrecuencia")
          .attr("frecuencia");
        let obscontrol = $(this).find(".observacioncontrol").val();
        let accioncorrectocontrol = $(this)
          .find(".accioncorrectivacontrol")
          .val();
        let selectvbcontrol = $(this)
          .find(".selectVerificacionControl")
          .find("option:selected")
          .text();
        let estadoverificacontrol = $(this)
          .find(".estadoverificacontrol")
          .val();
        let fechacontrol = $(this).find(".fechatotal").val();

        capturavalorcontrol.push({
          checkcontro: checkcontro,
          idcontrolalerta: idcontrolalerta,
          codigomaquinacontrol: codigomaquinacontrol,
          frecuenciacontrol: frecuenciacontrol,
          obscontrol: obscontrol,
          accioncorrectocontrol: accioncorrectocontrol,
          selectvbcontrol: selectvbcontrol,
          estadoverificacontrol: estadoverificacontrol,
          fechacontrol: fechacontrol,
        });
      });
      console.log(capturavalorcontrol);

      const accion = "insertaryactualizaralertacontrol";
      $.ajax({
        url: "../control_alimento/c_almacen.php",
        type: "POST",
        beforeSend: function () {
          $(".preloader").css("opacity", "1");
          $(".preloader").css("display", "block");
        },
        data: { accion: accion, capturavalorcontrol: capturavalorcontrol },
        success: function (response) {
          if (response == "ok") {
            Swal.fire({
              title: "¡Guardado exitoso!",
              text: "Los datos se han guardado correctamente.",
              icon: "success",
              confirmButtonText: "Aceptar",
            }).then((result) => {
              if (result.isConfirmed) {
                $("#modalcontrolalertas").modal("hide");
                // alertaControl();
              }
            });
          }
        },
        complete: function () {
          $(".preloader").css("opacity", "0");
          $(".preloader").css("display", "none");
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Error in alerta AJAX:", textStatus, errorThrown);
          reject(errorThrown);
        },
      });
    });

    /*-----------------------Para deshabilitar cajas de texto al darle check------------ */
    $("#tablacontrolalerta tr").each(function () {
      let checkboxcontrol = $(this).find("input[type='checkbox']");
      let observacioncontrol = $(this).find("#observacioncontrol");
      let accionCorrectivacontrol = $(this).find("#accioncorrectivacontrol");
      let selectVerificacioncontrol = $(this).find(
        "#selectVerificacionControl"
      );

      checkboxcontrol.on("click", function () {
        let isChecked = $(this).prop("checked");
        observacioncontrol.prop("disabled", isChecked);
        accionCorrectivacontrol.prop("disabled", isChecked);
        selectVerificacioncontrol.prop("disabled", isChecked);
        observacioncontrol.val("");
        accionCorrectivacontrol.val("");
        selectVerificacioncontrol.val("0").trigger("change");
      });
    });
    /*------------------------------------------------------------------------------- */
    /*-----------------------Poner check si es estado OB------------ */

    $("#tablacontrolalerta tr").each(function () {
      let checkboxcontrol = $(this).find("input[type='checkbox']");
      let observacioncontrol = $(this).find("#observacioncontrol");
      let accionCorrectivacontrol = $(this).find("#accioncorrectivacontrol");
      let selectVerificacioncontrol = $(this).find(
        "#selectVerificacionControl"
      );
      let estadoverificacontrol = $(this).find(".estadoverificacontrol").val();

      if (estadoverificacontrol === "OB") {
        $(this).find("input[type='checkbox']").prop("checked", true);
        checkboxcontrol.on("click", function () {
          observacioncontrol.prop("disabled", false);
          accionCorrectivacontrol.prop("disabled", false);
          selectVerificacioncontrol.prop("disabled", false);
        });
      }
    });

    /*------------------------------------------------------------- */
  }
});
