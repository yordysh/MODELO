$(function () {
  $("#botonalertaguardar").click(function () {
    $("#tablaalerta tr").each(function (index) {
      if (index !== 0) {
        let check = $(this).find(".check").prop("checked");
        let obs = $(this).find(".observacion").val();
        let accioncorrectox = $(this).find(".accioncorrectiva").val();
        let selectvb = $(this).find(".selectVerificacion").val();
      }
    });

    let capturavalor = [];
    $("#tablaalerta tr").each(function (index) {
      if (index !== 0) {
        let idzona = $(this).find(".codigozona").val();
        let idinfra = $(this).find(".codigoinfra").val();
        let idalerta = $(this).find(".codigoalerta").val();
        let frecuenciadias = $(this).find(".frecuenciadias").val();
        let check = $(this).find(".check").prop("checked");
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
          check: check,
          obs: obs,
          accioncorrecto: accioncorrecto,
          selectvb: selectvb,
          estadoverifica: estadoverifica,
          fecha: fecha,
        });
      }
    });
    console.log(capturavalor);

    const accion = "insertaryactualizaralerta";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, capturavalor: capturavalor },
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
              alertaOrdenCompra();
              // $("#formularioZona").trigger("reset");
            }
          });
        }
      },
    });
  });

  /*-----------------------Para deshabilitar cajas de texto al darle check------------ */
  $("#tablaalerta tr").each(function () {
    let checkbox = $(this).find("input[type='checkbox']");
    let observacion = $(this).find("#observacion");
    let accionCorrectiva = $(this).find("#accioncorrectiva");
    let selectVerificacion = $(this).find("#selectVerificacion");

    checkbox.on("click", function () {
      let isChecked = $(this).prop("checked");
      observacion.prop("disabled", isChecked);
      accionCorrectiva.prop("disabled", isChecked);
      selectVerificacion.prop("disabled", isChecked);
    });
  });
  /*------------------------------------------------------------------------------- */
  /*-----------------------Poner check si es estado OB------------ */

  $("#tablaalerta tr").each(function () {
    let checkbox = $(this).find("input[type='checkbox']");
    let observacion = $(this).find("#observacion");
    let accionCorrectiva = $(this).find("#accioncorrectiva");
    let selectVerificacion = $(this).find("#selectVerificacion");
    let estadoverifica = $(this).find(".estadoverifica").val();

    if (estadoverifica === "OB") {
      $(this).find("input[type='checkbox']").prop("checked", true);
      checkbox.on("click", function () {
        observacion.prop("disabled", false);
        accionCorrectiva.prop("disabled", false);
        selectVerificacion.prop("disabled", false);
      });
    }
  });

  /*------------------------------------------------------------- */
});
