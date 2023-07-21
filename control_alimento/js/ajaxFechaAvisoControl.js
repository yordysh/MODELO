$(function () {
  function mostrarAlertasControl(data, index) {
    if (index >= data.length) {
      return;
    }

    const task = data[index];
    // Swal.fire({
    //   title: "Información de control",
    //   icon: "info",
    //   html: `
    //     <div>
    //       <h2>Area:</h2>
    //       <p>${task.NOMBRE_T_ZONA_AREAS}</p>
    //     </div>
    //     <div>
    //     <h2>Maquina, equipos y utensilios de trabajo:</h2>
    //     <p>${task.NOMBRE_CONTROL_MAQUINA}</p>
    //     </div>
    //     <div>
    //     <p>Accion Correctiva:</p>
    //     <textarea class="form-control" id="accionCorrectiva" rows='3' "></textarea>
    //     </div>
    //     <label>
    //       <input type="radio" name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}" value="R"> Realizado
    //     </label>
    //     <label>
    //       <input type="radio" name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}" value="NR"> No Realizado
    //     </label>
    //     <textarea class="form-control" rows="3" id="observacion-${task.COD_ALERTA_CONTROL_MAQUINA}" rows="3" style="display: none;"></textarea>
    //   `,
    //   confirmButtonText: '<i class="fa fa-thumbs-up"></i> Aceptar',
    //   preConfirm: () => {
    //     const realizadoRadio = document.querySelector(
    //       `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="R"]`
    //     );
    //     const noRealizadoRadio = document.querySelector(
    //       `input[name="estado-${task.COD_ALERTA_CONTROL_MAQUINA}"][value="NR"]`
    //     );

    //     if (realizadoRadio.checked || noRealizadoRadio.checked) {
    //       const estado = realizadoRadio.checked ? "R" : "NR";

    //       const observacionTextArea = observacionTextarea.value;
    //       let accionCorrectiva =
    //         document.getElementById("accionCorrectiva").value;

    //       const accion = "actualizaalertacontrol";
    //       $.ajax({
    //         url: "c_almacen.php",
    //         method: "POST",
    //         data: {
    //           accion: accion,
    //           estado: estado,
    //           taskId: task.COD_ALERTA_CONTROL_MAQUINA,
    //           accionCorrectiva: accionCorrectiva,
    //           observacionTextArea: observacionTextArea,
    //         },
    //         dataType: "json",
    //       });
    //     }
    //   },
    // }).then((result) => {
    //   if (result.isConfirmed) {
    //     mostrarAlertasControl(data, index + 1);
    //   }
    // });

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

          // First AJAX request
          const accion = "actualizaalertacontrol";
          $.ajax({
            url: "c_almacen.php",
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
            url: "c_almacen.php",
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
        mostrarAlertasControl(data, index + 1);
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
