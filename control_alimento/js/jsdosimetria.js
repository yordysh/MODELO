var svgString;
$(document).ready(function () {
  window.jsPDF = window.jspdf.jsPDF;
  $("#generarPDF").on("click", function () {
    //exportardosimetria();
    buscarimgguardada();
  });
});
function exportardosimetria(obj) {
  var doc = new jsPDF("p", "mm", [297, 210]);
  let can = obj["c"] - 1;
  let hojbla = 0;
  $.each(obj["d"], function (i, l) {
    console.log(obj["d"]);
    let nombre = l[7].split(" ");
    let operario = nombre[0] + " " + nombre[1];
    let cantidad = l[3];
    let bachada = l[4];
    let producto = l[2];
    let fecha = l[5];
    let lote = l[6];
    let material = l[9];
    let codreque = l[8];

    if (can % 2 == 0 && i == can) {
      hojbla = 1;
    } else {
      hojbla = 0;
    }
    if (i % 2 == 0) {
      if (i != 0) {
        doc.addPage();
      }
      limitleft = 6;
      var logo = new Image();
      logo.src = "./images/img_lab.jpg";
      doc.setFont(undefined, "normal");
      doc.setFontSize(12);
      doc.line(6, 6.5, 6, 293); //primera linea vertical
      doc.line(12, 6.5, 12, 80); //segunda linea vertical
      doc.line(19, 6.5, 19, 80); //tercera linea vertical
      doc.line(25, 6.5, 25, 293); //cuarta linea vertical

      doc.line(limitleft, 6.5, 25, 6.5); //primera linea horizontal
      doc.line(limitleft, 80, 25, 80); //segunda linea horizontal
      doc.line(limitleft, 220, 25, 220); //tercera linea horizontal
      doc.line(limitleft, 293, 25, 293); //cuarta linea horizontal
      doc.addImage(logo.src, "JPEG", 23, 270, 60, 15, "", "", 90);

      doc.setFontSize(20);
      doc.text("DOSIMETRÍA", 18, 172.5, null, 90); //TITULO DOSIMETRIA
      doc.setFontSize(9);
      doc.setFont("helvetica", "bold");
      doc.text(obj["n"], 10, 78, null, 90); //reemplazar
      doc.text("Version: " + obj["v"], 16.5, 78, null, 90); //campo para agregar la version reemplazar
      doc.text("Fecha: " + obj["m"], 23, 78, null, 90); //campo para agregar la fecha reemplazar
    }
    if (i % 2 == 0) {
      ///-------------PRIMERA TABLA
      doc.line(29, 6.5, 204, 6.5); //primera linea horizontal
      doc.line(165, 12, 185, 12); //segunda linea horizontal

      let p = 17;
      for (let i = 0; i < 24; i++) {
        doc.line(80, p, 204, p); //linea horizontal
        p += 5.5;
      }
      doc.line(29, 148, 204, 148); //ultima linea horizontal

      doc.line(29, 6.5, 29, 148); //1 linea vertical
      doc.line(80, 6.5, 80, 148); //2 linea vertical
      doc.line(86, 6.5, 86, 143.5); //3 linea vertical
      doc.line(100, 6.5, 100, 143.5); //4 linea vertical
      doc.line(120, 6.5, 120, 143.5); //5 linea vertical
      doc.line(165, 6.5, 165, 143.5); //6 linea vertical

      doc.line(175, 12, 175, 143.5); //7 linea vertical

      doc.line(185, 6.5, 185, 148); //8 linea vertical
      doc.line(204, 6.5, 204, 148); //ultima linea vertical

      doc.setFontSize(6);
      doc.text("N°", 81.5, 13);
      doc.text("CÓDIGO DE", 87, 12);
      doc.text("INSUMO", 89, 14);
      doc.text("MATERIA PRIMA", 101.2, 12);
      doc.text("/INSUMO", 105, 14);
      doc.text("CÓDIGO LOTE", 135, 12);
      doc.text("PRESENTACIÓN", 166.2, 11);
      doc.text("g", 169, 15);
      doc.text("KG", 178, 15);
      doc.text("CANTIDAD", 189, 11);

      doc.text("TOTAL", 129, 146.6); /**/
      doc.setFontSize(8);
      doc.text(cantidad, 192, 146.6);

      doc.setFontSize(8);
      doc.text("PRODUCTO: ", 32, 12);
      doc.text(producto, 32, 17); //linea horizonatal
      doc.line(32, 18, 78, 18); //linea horizonatal

      doc.text("OPERARIO: ", 32, 26);
      doc.text(operario, 32, 31);
      doc.line(32, 32, 78, 32); //linea horizonatal

      doc.text("REQUERIMIENTO: ", 32, 40);
      doc.text(codreque, 60, 39);
      doc.line(58, 40, 78, 40); //linea horizonatal

      doc.text("CANTIDAD DE PRODUCTO: ", 32, 48);
      doc.text(cantidad, 50, 53);
      doc.line(32, 54, 78, 54); //linea horizonatal

      doc.text("FECHA: ", 32, 62);
      doc.text(fecha, 47, 67);
      doc.line(32, 68, 78, 68); //linea horizonatal

      doc.text("N° DE BACHADAS: ", 32, 76);
      doc.text(bachada, 52, 81);
      doc.line(32, 82, 78, 82); //linea horizonatal

      doc.text("LOTE: ", 32, 90);
      doc.text(lote, 50, 95);
      doc.line(32, 96, 78, 96); //linea horizonatal

      doc.setFontSize(6);
      doc.line(36, 114, 73, 114); //linea horizonatal
      doc.text("Firma del asistente de calidad", 40, 117);

      doc.line(32, 132, 78, 132); //linea horizonatal
      doc.text("Firma del jefe de Aseguramiento de calidad", 33, 135); /**/

      let index = 1;
      let altura = 21;
      let position = 83;
      var che1X_1 = 178; // Posición X
      var che1Y_1 = 19.5; // Posición Y

      var che2X_1 = 168; // Posición X

      doc.setFontSize(8);
      $.each(material, function (j, k) {
        doc.text("" + index, position, altura); //correlativo numerico
        doc.text("" + k[2], 90, altura); //codigo produccion
        doc.text("" + k[3], 107, altura); //materia prima
        doc.text("" + k[4], 125, altura); //lote prima
        if (k[6] == "g") {
          // Dibujar un check con líneas en la posición (50, 50)
          doc.line(che2X_1, che1Y_1, che2X_1 + 1, che1Y_1 + 1); // Dibujar una línea diagonal más corta
          doc.line(che2X_1 + 1, che1Y_1 + 1, che2X_1 + 3, che1Y_1 - 1); // Dibujar otra línea diagonal más corta
        } else {
          //Dibujar un check con líneas en la posición (50, 50)
          doc.line(che1X_1, che1Y_1, che1X_1 + 1, che1Y_1 + 1); // Dibujar una línea diagonal más corta
          doc.line(che1X_1 + 1, che1Y_1 + 1, che1X_1 + 3, che1Y_1 - 1); // Dibujar otra línea diagonal más corta
        } //gramos o kilos
        doc.text("" + k[5], 190, altura); //peso
        // doc.text("" + k[5], 190, altura); //peso
        index++;
        if (index > 9) {
          position = 82;
        } /**/
        altura += 5.5;
        che1Y_1 += 5.5;
      });
      /*//----------- */
    }
    console.log(i % 2);
    if (i % 2 != 0 || hojbla == 1) {
      if (hojbla == 1) {
        operario = "";
        cantidad = "";
        bachada = "";
        fecha = "";
        lote = "";
        producto = "";
        material = [];
        codreque = "";
      }

      doc.line(29, 151, 204, 151); //primera linea horizontal
      doc.line(165, 157, 185, 157); //segunda linea horizontal
      let p = 162;
      for (let i = 0; i < 24; i++) {
        doc.line(80, p, 204, p); //linea horizontal
        p += 5.5;
      }
      doc.line(29, 293, 204, 293); //ultima linea horizontal

      doc.line(29, 151, 29, 293); //1 linea vertical
      doc.line(80, 151, 80, 293); //2 linea vertical
      doc.line(86, 151, 86, 288.4); //3 linea vertical
      doc.line(100, 151, 100, 288.4); //4 linea vertical
      doc.line(120, 151, 120, 288.4); //5 linea vertical
      doc.line(165, 151, 165, 288.4); //6 linea vertical

      doc.line(175, 157, 175, 288.4); //7 linea vertical

      doc.line(185, 151, 185, 293); //8 linea vertical
      doc.line(204, 151, 204, 293); //ultima linea vertical

      doc.setFontSize(6);
      doc.text("N°", 81.5, 158);
      doc.text("CÓDIGO DE", 87, 157);
      doc.text("INSUMO", 89, 159);
      doc.text("MATERIA PRIMA", 101.2, 157);
      doc.text("/INSUMO", 105, 159);
      doc.text("CÓDIGO LOTE", 135, 157);
      doc.text("PRESENTACIÓN", 166.2, 156);
      doc.text("g", 169, 160);
      doc.text("KG", 178, 160);
      doc.text("CANTIDAD", 189, 156);

      doc.text("TOTAL", 129, 291.6); /**/
      doc.setFontSize(8);
      doc.text(cantidad, 192, 291.6);

      doc.setFontSize(8);
      doc.text("PRODUCTO: ", 32, 156);
      doc.text(producto, 32, 161); //linea horizonatal
      doc.line(32, 162, 78, 162); //linea horizonatal

      doc.text("OPERARIO: ", 32, 170);
      doc.text(operario, 32, 175);
      doc.line(32, 176, 78, 176); //linea horizonatal

      doc.text("REQUERIMIENTO: ", 32, 184);
      doc.text(codreque, 60, 183);
      doc.line(58, 184, 78, 184); //linea horizonatal

      doc.text("CANTIDAD DE PRODUCTO: ", 32, 192);
      doc.text(cantidad, 50, 197);
      doc.line(32, 198, 78, 198); //linea horizonatal

      doc.text("FECHA: ", 32, 206);
      doc.text(fecha, 47, 211);
      doc.line(32, 212, 78, 212); //linea horizonatal

      doc.text("N° DE BACHADAS: ", 32, 220);
      doc.text(bachada, 52, 225);
      doc.line(32, 226, 78, 226); //linea horizonatal

      doc.text("LOTE: ", 32, 234);
      doc.text(lote, 50, 239);
      doc.line(32, 240, 78, 240); //linea horizonatal

      doc.setFontSize(6);
      doc.line(36, 258, 73, 258); //linea horizonatal
      doc.text("Firma del asistente de calidad", 40, 261);

      doc.line(32, 276, 78, 276); //linea horizonatal
      doc.text("Firma del jefe de Aseguramiento de calidad", 33, 279); /**/

      let index2 = 1;
      let altura2 = 166;
      let position2 = 83;

      var che1X_2 = 178; // Posición X
      var che1Y_2 = 165; // Posición Y

      var che2X_2 = 168; // Posición X

      doc.setFontSize(8);
      $.each(material, function (s, a) {
        doc.text("" + index2, position2, altura2); //correlativo numerico
        doc.text("" + a[2], 90, altura2); //codigo produccion
        doc.text("" + a[3], 107, altura2); //materia prima
        doc.text("" + a[4], 125, altura2); //lote prima
        if (a[6] == "g") {
          // Dibujar un check con líneas en la posición (50, 50)
          doc.line(che2X_2, che1Y_2, che2X_2 + 1, che1Y_2 + 1); // Dibujar una línea diagonal más corta
          doc.line(che2X_2 + 1, che1Y_2 + 1, che2X_2 + 3, che1Y_2 - 1); // Dibujar otra línea diagonal más corta
        } else {
          // Dibujar un check con líneas en la posición (50, 50)
          doc.line(che1X_2, che1Y_2, che1X_2 + 1, che1Y_2 + 1); // Dibujar una línea diagonal más corta
          doc.line(che1X_2 + 1, che1Y_2 + 1, che1X_2 + 3, che1Y_2 - 1); // Dibujar otra línea diagonal más corta
        } //gramos o kilos
        doc.text("" + a[5], 190, altura2); //peso

        index2++;
        if (index2 > 9) {
          position2 = 82;
        }
        altura2 += 5.5;
        che1Y_2 += 5.5;
      });
      /* 
        
        //------------*/
    }
  });
  window.open(doc.output("bloburl"), "_blank");
}

function buscarimgguardada() {
  $.ajax({
    dataType: "text",
    type: "POST",
    url: "c_reporte_docimetria.php",
    data: {
      accion: "reporte",
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
        // console.log(obj["m"]);
        exportardosimetria(obj);
      } catch ({ name, message }) {
        Mensaje1("Error al buscar datos " + message, "info");
      }
      vmensj.close();
    },
    complete: function () {
      vmensj.close();
    },
  }); /**/
}

function Mensaje1(texto, icono) {
  Swal.fire({ icon: icono, title: texto, heightAuto: false });
}
