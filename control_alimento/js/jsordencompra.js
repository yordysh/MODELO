var svgString;
$(document).ready(function () {
  window.jsPDF = window.jspdf.jsPDF;
  $("#generarPDF").on("click", function () {
    buscarimgguardada();
  });
});

function exportardatoscompra(obj) {
  var doc = new jsPDF({
    orientation: "portrait",
  });
  let imagenes = obj[7][0];
  // $.each(obj["d"], function (i, l) {

  // console.log(l[7]);
  // let numerofactura = l[0];
  // let fecha = l[1];
  // let hora = l[2];
  // let proveedor = l[3];
  // let material = l[6];

  // doc.text(imagenes);
  //   if (i % 1 == 0 && i != 0) {
  //     doc.addPage();
  //   }
  //   // Función para dibujar un rectángulo con esquinas ovaladas
  //   function roundedRect(x, y, width, height, radius) {
  //     doc.setLineWidth(0.5);
  //     doc.setDrawColor(0);
  //     doc.setFillColor(255, 255, 255); // Color blanco
  //     doc.roundedRect(x, y, width, height, radius, radius, "FD"); // 'FD' para dibujar y rellenar
  //   }
  //   // Cabecera de la factura dentro de un rectángulo con esquinas ovaladas
  //   roundedRect(15, 5, 150, 60, 10);
  //   // Texto en la cabecera
  //   doc.setFontSize(14);
  //   doc.text("Factura", 80, 20);
  //   doc.setFontSize(10);
  //   doc.text("N°: " + numerofactura, 20, 30);
  //   doc.text("Fecha: " + fecha, 20, 40);
  //   doc.text("Hora: " + hora, 20, 50);
  //   doc.text("Proveedor: " + proveedor, 20, 60);
  //   // Línea divisoria entre la cabecera y el cuerpo
  //   doc.setLineWidth(0.5);
  //   doc.line(10, 80, 200, 80);
  //   // generar la data productos
  //   let suma = 0;
  //   let yPos;
  //   $.each(material, function (j, k) {
  //     yPos = 100 + j * 20;
  //     let valorsumacantidad = parseFloat(k[4]);
  //     // Cuerpo de la factura
  //     doc.text("Descripción", 10, 90);
  //     doc.text("Cantidad", 95, 90);
  //     // doc.text("Precio Unitario", 120, 90);
  //     doc.text("Total", 170, 90);
  //     // DAta de productos
  //     doc.text(k[2], 10, yPos);
  //     doc.text(k[3], 95, yPos);
  //     // doc.text("$50.00", 130, yPos);
  //     doc.text(k[4], 170, yPos);
  //     // Línea divisoria entre las filas
  //     yPos += 5; // ajuste de vertical
  //     doc.line(10, yPos, 200, yPos);
  //     //suma de productos
  //     suma = suma + valorsumacantidad;
  //   });
  //   // Total
  //   doc.text("Total:", 120, yPos + 10); // Ajusta la posición vertical aquí
  //   doc.text(suma.toString(), 170, yPos + 10);
  //   // imageRow.push({
  //   //   image: "data:image/png;base64," + imagenes,
  //   //   width: 250,
  //   //   height: 90,
  //   // });
  //   // var logo = new Image();
  //   // logo.src = "data:image/png;base64," + imagenes;
  //   // console.log(imagenes);
  //   // doc.addImage(logo, "PNG", 10, 10, 50, 70);
  // });
  window.open(doc.output("bloburl"), "_blank");
}

function buscarimgguardada() {
  let idrequerimientotemp = $("#idrequerimientotemp").val();
  $.ajax({
    dataType: "text",
    type: "POST",
    url: "c_almacen.php",
    data: {
      accion: "reporteordencompra",
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
        exportardatoscompra(obj);
      } catch (e) {
        console.log(e);
        Mensaje1("Error al buscar datos " + message, "info");
      }
      vmensj.close();
    },
    // complete: function () {
    //   vmensj.close();
    // },
  }); /**/
}
function Mensaje1(texto, icono) {
  Swal.fire({ icon: icono, title: texto, heightAuto: false });
}
