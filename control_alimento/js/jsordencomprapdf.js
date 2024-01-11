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
    let numerofactura = l[0];
    let fecha = l[2];
    let hora = l[3];
    let proveedor = l[6];
    let material = l[7];
    // let imagenes = l[6];
    if (i % 1 == 0 && i != 0) {
      doc.addPage();
    }
    // Función para dibujar un rectángulo con esquinas ovaladas
    function roundedRect(x, y, width, height, radius) {
      doc.setLineWidth(0.5);
      doc.setDrawColor(0);
      doc.setFillColor(255, 255, 255); // Color blanco
      doc.roundedRect(x, y, width, height, radius, radius, "FD"); // 'FD' para dibujar y rellenar
    }
    // Cabecera de la factura dentro de un rectángulo con esquinas ovaladas
    roundedRect(15, 10, 150, 54, 10);

    function roundedTopSombreado(
      x,
      y,
      width,
      height,
      radiusTopLeft,
      radiusTopRight
    ) {
      doc.setDrawColor(0);
      doc.setFillColor(212, 138, 212); // Color blanco

      doc.moveTo(x + radiusTopLeft, y);
      doc.lineTo(x + width - radiusTopRight, y);
      doc.curveTo(
        x + width - radiusTopRight / 2,
        y,
        x + width,
        y + radiusTopRight / 2,
        x + width,
        y + radiusTopRight
      );
      doc.lineTo(x + width, y + height);
      doc.lineTo(x, y + height);
      doc.lineTo(x, y + radiusTopLeft);
      doc.curveTo(
        x,
        y + radiusTopLeft / 2,
        x + radiusTopLeft / 2,
        y,
        x + radiusTopLeft,
        y
      );

      doc.fill();
    }
    // Uso de la función con fondo de altura 20 y radios de borde para las esquinas superiores
    roundedTopSombreado(15, 10, 150, 10, 10, 10);

    function roundedBottomSombreado(
      x,
      y,
      width,
      height,
      radiusBottomLeft,
      radiusBottomRight
    ) {
      doc.setDrawColor(0);
      doc.setFillColor(200, 182, 242);

      doc.moveTo(x, y);
      doc.lineTo(x + width, y);
      doc.lineTo(x + width, y + height - radiusBottomRight);
      doc.curveTo(
        x + width,
        y + height - radiusBottomRight / 2,
        x + width - radiusBottomRight / 2,
        y + height,
        x + width - radiusBottomRight,
        y + height
      );
      doc.lineTo(x + radiusBottomLeft, y + height);
      doc.curveTo(
        x + radiusBottomLeft / 2,
        y + height,
        x,
        y + height - radiusBottomLeft / 2,
        x,
        y + height - radiusBottomLeft
      );

      doc.fill();
    }
    // Uso de la función con fondo de altura 20 y radios de borde para las esquinas superiores
    roundedBottomSombreado(15.3, 20.1, 149.3, 43.5, 10, 10);

    // Texto en la cabecera
    doc.setFontSize(14);
    // Pongo de color blanco la letra
    doc.setTextColor(255, 255, 255);
    doc.text("Factura", 80, 17);
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
      let valorsumacantidad = parseFloat(k[4]);
      // Cuerpo de la factura
      doc.setFontSize(10);
      doc.text("Producto", 10, 80);
      doc.text("Cantidad", 95, 80);
      // doc.text("Precio Unitario", 120, 90);
      doc.text("Total", 170, 80);

      // DAta de productos
      doc.setFontSize(8);
      doc.text(k[2], 10, yPos);
      doc.text(k[3], 95, yPos);
      doc.text(k[4], 170, yPos);
      // Línea divisoria entre las filas
      yPos += 5; // ajuste de vertical
      doc.line(10, yPos, 200, yPos);
      //suma de productos
      suma = suma + valorsumacantidad;
    });
    // Total
    igv = suma * 0.18;
    sumaigv = igv + suma;
    doc.setFont("helvetica", "bold");
    doc.text("Sub Total:", 150, yPos + 10);
    doc.text("Importe Total:", 150, yPos + 15); // Ajusta la posición vertical aquí
    doc.setFont("helvetica", "normal");
    doc.text(suma.toString(), 170, yPos + 10);
    doc.text(sumaigv.toString(), 170, yPos + 15);

    // if (imagenes[0] == null) {
    //   doc.text("", 10, 10);
    // } else {
    //   let imagesPerRow = 3; // Número máximo de imágenes por fila
    //   let imagesInCurrentRow = 0;
    //   let offsetY = 0;
    //   let pageHeight = 297; // Altura de la página en unidades del documento (ajusta según tus necesidades)
    //   let maxImageHeight = 70; // Altura máxima de la imagen (ajusta según tus necesidades)
    //   let availableSpace = pageHeight - (20 + yPos + offsetY); // Espacio disponible en la página
    //   let currentPage = doc.internal.getCurrentPageInfo().pageNumber;

    //   $.each(imagenes, function (f, q) {
    //     if (imagesInCurrentRow === 0) {
    //       offsetY = f > 0 ? offsetY + maxImageHeight : 0;
    //       availableSpace = pageHeight - (20 + yPos + offsetY);
    //     }

    //     // Verificar si hay suficiente espacio para la imagen en la página actual
    //     if (availableSpace < maxImageHeight) {
    //       // Agregar una nueva página si no hay suficiente espacio
    //       doc.addPage();
    //       offsetY = 0;
    //       yPos = 0;
    //       availableSpace = pageHeight - 20;
    //       currentPage++;
    //     }

    //     var logo = new Image();
    //     logo.src = "data:image/png;base64," + q;

    //     var offsetX = 10 + (imagesInCurrentRow % imagesPerRow) * 60;
    //     doc.addImage(
    //       logo,
    //       "PNG",
    //       offsetX,
    //       20 + yPos + offsetY,
    //       50,
    //       maxImageHeight
    //     );
    //     imagesInCurrentRow++;

    //     if (imagesInCurrentRow === imagesPerRow) {
    //       // Se alcanzó el número máximo de imágenes por fila, reiniciar contador y offsetY
    //       imagesInCurrentRow = 0;
    //       offsetY = 0;
    //     }
    //   });
    // }
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
    // beforeSend: function () {
    //   vmensj = swal.fire({
    //     title: "Cargando!",
    //     html: "Espere mientras se cargan los datos no cierre el sistema... <b></b>",
    //     allowOutsideClick: false,
    //     allowEscapeKey: false,
    //     showConfirmButton: false,
    //   });
    // },
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
    // complete: function () {
    //   vmensj.close();
    // },
  }); /**/
}
function Mensaje1(texto, icono) {
  Swal.fire({ icon: icono, title: texto, heightAuto: false });
}
