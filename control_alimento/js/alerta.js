$(function () {
  $("#botonalertaguardar").click(function () {
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
        });
      }
    });
    console.log(capturavalor);
    const accion = "insertaryactualizaralerta";
    $.ajax({
      url: "./c_almacen.php",
      type: "POST",
      data: { accion: accion, capturavalor: capturavalor },
      success: function (response) {},
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
  $(document).ready(function () {
    $("#tablaalerta tr").each(function () {
      let estadoverifica = $(this).find(".estadoverifica").val();

      if (estadoverifica === "OB") {
        // console.log("uno");
        $(this).find("input[type='checkbox']").prop("checked", true);
      }
    });
  });
  /*------------------------------------------------------------- */
});
