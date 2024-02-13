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
    if (
      !window.location.pathname.endsWith(
        "/control_alimento/controlRecepcion.php"
      )
    ) {
      return new Promise((resolve, reject) => {
        const accion = "mostrarordencompraalmacenalerta";
        // var codrequerimiento;
        $.ajax({
          url: "../control_alimento/c_almacen.php",
          type: "POST",
          data: { accion: accion },
          success: function (response) {
            let task = JSON.parse(response);
            console.log(task);
            if (task.length > 0) {
              // let task = JSON.parse(response);
              // codrequerimiento = task[0].COD_REQUERIMIENTO;
              let htmlContent = "<h1>¡Lista de productos!</h1>";
              htmlContent += "<table class='tableta'>";
              htmlContent += "<thead>";
              htmlContent += "<tr>";
              htmlContent += "<th style='margin-rigth:15px;'>Codigo</th>";
              htmlContent += "<th style='margin-rigth:15px;'> Producto</th>";
              htmlContent += "<th> Cantidad pedida</th>";
              htmlContent += "<th> Cantidad recibida</th>";
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
                  parseFloat(producto.CANTIDAD_INSUMO_ENVASE).toFixed(2) +
                  "</td>";
                htmlContent +=
                  "<td class='td-cantidad-llegada'>" +
                  (producto.CANTIDAD_LLEGADA == null
                    ? 0
                    : parseFloat(producto.CANTIDAD_LLEGADA)
                  ).toFixed(2) +
                  "</td>";
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
                  window.location.href =
                    "../control_alimento/controlRecepcion.php";
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
