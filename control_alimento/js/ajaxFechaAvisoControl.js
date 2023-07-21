$(function () {
  function mostrarAlertasControl(data, index) {
    if (index >= data.length) {
      return;
    }

    const task = data[index];
    Swal.fire({
      title: "Información de control",
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
        <textarea class="form-control" rows="3" id="accioncorrectiva-${task.COD_ALERTA_CONTROL_MAQUINA}" rows="3"></textarea>
        </div>
        <label>
          <input type="radio" name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}" value="R"> Realizado
        </label>
        <label>
          <input type="radio" name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}" value="NR"> No Realizado
        </label>
        <textarea class="form-control" rows="3" id="observacion-${task.COD_ALERTA_CONTROL_MAQUINA}" rows="3" style="display: none;"></textarea>
      `,
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

          const observacionTextArea = observacionTextarea.value;
          const accion = "actualizaalertacontrol";
          $.ajax({
            // url: "./php/checkbox-confirma.php",
            url: "c_almacen.php",
            method: "POST",
            data: {
              accion: accion,
              estado: estado,
              taskId: task.COD_ALERTA_CONTROL_MAQUINA,
              // taskFecha: task.FECHA_TOTAL,
              observacionTextArea: observacionTextArea,
            },
            dataType: "json",
          }).done(function (response) {
            console.log(response);
            mostrarAlertasControl(data, index + 1);

            // Crea una nueva alerta con la fecha total
            // const nuevaFechaTotal = new Date();
            const accion = "insertaralertamixcontrolmaquina";
            return $.ajax({
              // url: "./php/insertar-alertamix.php",
              url: "c_almacen.php",
              method: "POST",
              data: {
                accion: accion,
                // fechaCreacion: nuevaFechaTotal.toISOString(),
                codControlMaquina: task.COD_CONTROL_MAQUINA,
                taskNdias: task.N_DIAS_POS,
              },
              dataType: "json",
            });
          });
        }
      },
    }).then((result) => {
      if (result.isConfirmed) {
        mostrarAlertasControl(data, index + 1);
      }
    });
    const observacionTextarea = document.querySelector(
      `#observacion-${task.COD_ALERTA_CONTROL_MAQUINA}`
    );

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
    url: "c_almacen.php",
    method: "POST",
    dataType: "json",
    data: { accion: accion },
    success: function (data) {
      console.log(data);
      const index = 0;
      mostrarAlertasControl(data, index);
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
});
