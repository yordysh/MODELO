let vmensj = "";
$(function () {
  $("#btnbuscar").on("click", function () {
    // console.log("datos");
    buscarkardex();
  });

  $("#slcproducto").select2({});
  $("#slclote").select2({});
  $("#selectProductokardex").select2({});
  productos();
  $("#slcproducto").change(function () {
    slclotes($(this).val());
  });
});

function slcproductos() {
  $("#selectProductoCombo").change(function () {
    let idp = $("#selectProductoCombo").val();
    let idProductoCombo = $(this).find("option:selected").attr("id_reque");
    $.ajax({
      data: {
        idProductoCombo: idProductoCombo,
        idp: idp,
        accion: accion,
      },
      dataType: "html",
      type: "POST",
      url: "./c_almacen.php",
    }).done(function (data) {
      selectNumProduccion.html(data);
    });
  });
}

function buscarkardex() {
  let producto = $("#slcproducto").val();
  let fecini = $("#txtfechaini").val();
  let fecfin = $("#txtfechafin").val();
  let lote = $("#slclote").val();
  $.ajax({
    dataType: "text",
    type: "POST",
    url: "./c_almacen.php",
    data: {
      accion: "reportekardex",
      producto: producto,
      fechaini: fecini,
      fechafin: fecfin,
      lote: lote,
    },
    beforeSend: function () {
      mensajecargar();
    },
    success: function (e) {
      try {
        obj = JSON.parse(e);
        console.log(obj["d"]);
        tabla = "";
        if (obj["m"] != "") {
          Mensaje1(obj["m"], "info");
          return;
        }
        if (obj["c"] > 0) {
          $.each(obj["d"], function (i, t) {
            console.log(i);
            tabla +=
              '<tr class="trcambio">' +
              '<td title="codigoproducto">' +
              t[1] +
              "</td>" +
              '<td title="producto">' +
              t[4] +
              "-" +
              t[3] +
              "</td>" +
              '<td title="lote">' +
              t[5] +
              "</td>" +
              '<td title="fecha"> ' +
              t[10] +
              "</td>" +
              '<td title="descripcion">' +
              t[6] +
              "</td>" +
              '<td title="ingreso">' +
              t[7] +
              "</td>" +
              '<td title="salida">' +
              t[8] +
              "</td>" +
              '<td title="saldo">' +
              parseFloat(t[9]).toFixed(2) +
              "</td>" +
              "</tr>";
            if (obj["c"] == i + 1) {
              tabla +=
                '<tr class="trcambio">' +
                '<td colspan="6" class="table-active">Total</td>' +
                "<td>" +
                parseFloat(t[11]).toFixed(2) +
                "</td>" +
                "</tr>";
            }
          });
          $("#tbdreportekardex").html(tabla);
        } else {
          Mensaje1("No hay datos que mostrar", "info");
        }
      } catch (error) {
        console.log(e);
        vmensj.close();
        Mensaje1(e, "info");
      }
    },
    complete: function () {
      vmensj.close();
    },
  });
}

function mensajecargar() {
  vmensj = swal.fire({
    title: "Cargando!",
    html: "Espere mientras se cargan los datos no cierre el sistema... <b></b>",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showConfirmButton: false,
  });
}

function Mensaje1(texto, icono) {
  Swal.fire({ icon: icono, title: texto, heightAuto: false });
}

function productos() {
  $.ajax({
    dataType: "text",
    type: "POST",
    url: "./c_almacen.php",
    data: {
      accion: "productoselect",
    },
    success: function (e) {
      try {
        obj = JSON.parse(e);
        if (obj["c"] > 0) {
          $("#slcproducto")
            .find("option")
            .remove()
            .end()
            .append('<option value="">SELECCIONE PRODUCTO</option>')
            .val("");
          $.each(obj["d"], function (i, item) {
            $("#slcproducto").append(
              $("<option value=" + item[0] + ">" + item[1] + "</option>")
            );
          });
        }
      } catch (error) {
        console.log(e);
        Mensaje1(e, "info");
      }
    },
  });
}

function slclotes(producto) {
  $.ajax({
    dataType: "text",
    type: "POST",
    url: "./c_almacen.php",
    data: {
      accion: "slclotes",
      producto: producto,
    },
    success: function (e) {
      try {
        obj = JSON.parse(e);
        console.log(obj);
        if (obj["c"] > 0) {
          $("#slclote")
            .find("option")
            .remove()
            .end()
            .append('<option value="">SELECCIONE LOTE</option>')
            .val("");
          $.each(obj["d"], function (i, item) {
            $("#slclote").append(
              $("<option value=" + item[0] + ">" + item[0] + "</option>")
            );
          });
        } else {
          Mensaje1("Producto no cuenta con lotes", "info");
        }
      } catch (error) {
        console.log(e);
        Mensaje1(e, "info");
      }
    },
  });
}
