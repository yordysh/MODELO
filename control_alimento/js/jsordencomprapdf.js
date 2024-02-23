var svgString;
$(document).ready(function () {
  window.jsPDF = window.jspdf.jsPDF;
  $("#generarOrdenPDF").on("click", function () {
    buscarordencompra();
  });
});

function exportardatoscomprapdf(obj) {
  var doc = new jsPDF({
    orientation: "portrait",
  });
  // let imagenes = obj[7][0];
  $.each(obj["cabecera"], function (i, l) {
    let numerofactura = l[1];
    let fecha = l[2];
    let hora = l[3];
    let proveedor = l[6];
    let material = l[8];
    let imagenes = l[7];
    if (i % 1 == 0 && i != 0) {
      doc.addPage();
    }
    doc.setFontSize(14);
    // Pongo de color blanco la letra
    // doc.setTextColor(255, 255, 255);
    doc.text("ORDEN DE COMPRA", 70, 17);
    doc.setFontSize(12);
    doc.text("N°: " + numerofactura, 20, 25);
    doc.text("Fecha: " + fecha, 20, 35);
    doc.text("Hora: " + hora, 20, 45);
    doc.text("Proveedor: " + proveedor, 20, 55);
    // Reseteo el color y pongo por defecto (black)
    doc.setTextColor(0, 0, 0);
    // Línea divisoria entre la cabecera y el cuerpo
    doc.setLineWidth(0.5);
    doc.line(10, 72, 200, 72);
    // generar la data productos
    let suma = 0;
    let yPos;
    $.each(material, function (j, k) {
      yPos = 90 + j * 15;

      let prod = parseFloat(k[3]) * parseFloat(k[5]);
      let prodtotal = Math.ceil(prod * 100) / 100;
      let valorsumacantidad = parseFloat(prodtotal);
      // Cuerpo de la factura
      doc.setFontSize(10);
      doc.text("Producto", 10, 80);
      doc.text("Peso", 90, 80);
      doc.text("Precio Unitario", 120, 80);
      doc.text("Total", 170, 80);

      // DAta de productos
      doc.setFontSize(8);
      doc.text(k[2], 10, yPos);
      doc.text(k[3], 90, yPos);
      doc.text(parseFloat(k[5]).toFixed(3), 120, yPos);
      doc.text(prodtotal.toString(), 170, yPos);
      // Línea divisoria entre las filas
      yPos += 5; // ajuste de vertical
      doc.line(10, yPos, 200, yPos);
      //suma de productos
      suma = suma + valorsumacantidad;
    });
    // Total
    igv = suma * 0.18;
    sumaigv = igv + suma;

    igv = igv.toFixed(2);
    sumaigv = sumaigv.toFixed(2);

    doc.setFont("helvetica", "bold");
    doc.text("Sub Total:", 150, yPos + 10);
    doc.text("IGV 18%:", 150, yPos + 15);
    doc.text("Importe Total:", 150, yPos + 20); // Ajusta la posición vertical aquí
    doc.setFont("helvetica", "normal");
    doc.text(suma.toString(), 170, yPos + 10);
    doc.text(igv.toString(), 170, yPos + 15);
    doc.text(sumaigv.toString(), 170, yPos + 20);

    if (imagenes[0] == null) {
      doc.text("", 10, 10);
    } else {
      let imagesPerRow = 3; // Número máximo de imágenes por fila
      let imagesInCurrentRow = 0;
      let offsetY = 0;
      let pageHeight = 298; // Altura de la página en unidades del documento (ajusta según tus necesidades)
      let maxImageHeight = 70; // Altura máxima de la imagen (ajusta según tus necesidades)
      let availableSpace = pageHeight - (20 + yPos + offsetY); // Espacio disponible en la página
      let currentPage = doc.internal.getCurrentPageInfo().pageNumber;

      $.each(imagenes, function (f, q) {
        if (imagesInCurrentRow === 0) {
          offsetY = f > 0 ? offsetY + maxImageHeight : 0;
          availableSpace = pageHeight - (20 + yPos + offsetY);
        }

        // Verificar si hay suficiente espacio para la imagen en la página actual
        if (availableSpace < maxImageHeight) {
          // Agregar una nueva página si no hay suficiente espacio
          doc.addPage();
          offsetY = 0;
          yPos = 0;
          availableSpace = pageHeight - 20;
          currentPage++;
        }

        var logo = new Image();
        logo.src = "data:image/png;base64," + q;

        var offsetX = 10 + (imagesInCurrentRow % imagesPerRow) * 60;
        doc.addImage(
          logo,
          "PNG",
          offsetX,
          30 + yPos + offsetY,
          50,
          maxImageHeight
        );
        imagesInCurrentRow++;

        if (imagesInCurrentRow === imagesPerRow) {
          // Se alcanzó el número máximo de imágenes por fila, reiniciar contador y offsetY
          imagesInCurrentRow = 0;
          offsetY = 0;
        }
      });
    }
  });
  window.open(doc.output("bloburl"), "_blank");
}

function buscarordencompra() {
  let idrequerimientotemp = $("#idrequerimientotemp").val();
  $.ajax({
    dataType: "text",
    type: "POST",
    url: "c_almacen.php",
    data: {
      accion: "reporteordencomprapdf",
      idrequerimientotemp: idrequerimientotemp,
    },
    beforeSend: function () {
      vmensj = swal.fire({
        title: "Cargando!",
        html: "Espere mientras se cargan los datos no cierre el sistema... <b></b>",
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
      });
    },
    success: function (re) {
      try {
        obj = JSON.parse(re);
        console.log(obj);
        exportardatoscomprapdf(obj);
      } catch (e) {
        console.log(e);
        // Mensaje1("Error al buscar datos " + message, "info");
      }
      // vmensj.close();
    },
    complete: function () {
      vmensj.close();
    },
  }); /**/
}
function Mensaje1(texto, icono) {
  Swal.fire({ icon: icono, title: texto, heightAuto: false });
}
