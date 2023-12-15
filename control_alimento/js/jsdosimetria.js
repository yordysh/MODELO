var svgString;
$(document).ready(function () {
  window.jsPDF = window.jspdf.jsPDF;
  $("#generarPDF").on("click", function () {
    //exportardosimetria();
    buscarimgguardada();
  });
});

function exportardosimetria(obj) {
  var doc = new jsPDF({
    orientation: "landscape",
  });
  let can = obj["c"] - 1;
  let hojbla = 0;
  $.each(obj["d"], function (i, l) {
    let nombre = l[7].split(" ");
    let operario = nombre[0] + " " + nombre[1];
    let cantidad = l[3];
    let bachada = l[4];
    let producto = l[2];
    let fecha = l[5];
    let lote = l[6];
    let material = l[8];
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
      logo.src = "recursos/img_lab.jpg";
      doc.setFont(undefined, "normal");
      doc.setFontSize(12);
      doc.line(6, 6.5, 6, 26); //linea vertical
      doc.line(limitleft, 6.5, 290, 6.5); //linea horizontal
      doc.addImage(logo.src, "JPG", 9, 9, 60, 15);
      doc.line(limitleft, 26, 290, 26); //linea horizontal
      doc.line(70, 6.5, 70, 26); //linea vertical
      doc.setFontSize(20);
      doc.text("DOSIMETRÍA", 125, 19); //TITULO DOSIMETRIA
      doc.line(210, 6.5, 210, 26); //linea vertical
      doc.line(290, 6.5, 290, 26); //linea vertical
      doc.setFontSize(9);
      doc.setFont("helvetica", "bold");
      doc.text(obj["n"], 211, 11); //reemplazar
      doc.line(210, 13, 290, 13); //linea horizontal
      doc.text("Version: " + obj["v"], 211, 17); //campo para agregar la version reemplazar
      doc.line(210, 19, 290, 19); //linea horizontal
      doc.text("Fecha: " + obj["m"], 211, 23.5); //campo para agregar la fecha reemplazar
    }
    if (i % 2 == 0) {
      /*primera columna-------------------------------------- */
      doc.text("OPERARIO: " + operario, 6, 31);
      doc.line(24, 32, 66, 32); //linea horizontal
      doc.text("CANTIDA DE PRODUCTO:", 6, 38);
      doc.text(cantidad, 53, 38);
      doc.line(46, 39, 66, 39); //linea horizontal
      doc.text("N° DE BACHADAS: ", 6, 45);
      doc.text(bachada, 50, 45);
      doc.line(35, 46, 66, 46); //linea horizontal
      doc.text("PRODUCTO: " + producto, 68, 31);
      doc.line(87, 32, 137, 32); //linea horizontal
      doc.text("FECHA:", 68, 38);
      doc.text(fecha, 90, 38);
      doc.line(80, 39, 137, 39); //linea horizontal
      doc.text("LOTE: ", 68, 45);
      doc.text(lote, 90, 45);
      doc.line(78, 46, 137, 46); //linea horizontal
      /*----------------------------------------------------*/
      /*-------------PRIMERA TABLA */
      doc.line(6, 52, 137, 52); //linea horizontal
      doc.line(6, 52, 6, 194); //primera linea vertical
      doc.line(16, 52, 16, 188); //segunda linea vertical
      doc.line(46, 52, 46, 188); //tercera linea vertical
      doc.line(90, 52, 90, 188); // cuarta linea vertical
      doc.line(90, 57, 118, 57); //linea horizontal
      doc.line(104, 57, 104, 188); //quinta linea vertical
      doc.line(118, 52, 118, 194); //sexta linea vertical
      doc.line(137, 52, 137, 194); // ultima linea vertical

      doc.setFontSize(9);
      doc.text("N°", 9.5, 58);
      doc.text("MATERIA PRIMA /", 17.5, 56);
      doc.text("INSUMO", 23, 60);
      doc.text("CÓDIGO/LOTE ", 54, 58);
      doc.text("PRESENTACIÓN", 92, 56);
      doc.text("g", 95, 60.5);
      doc.text("KG", 108, 60.5);
      doc.text("CANTIDAD", 119, 58);
      doc.line(6, 62, 137, 62); //linea horizontal
      let p = 68;
      for (let i = 0; i < 22; i++) {
        doc.line(6, p, 137, p); //linea horizontal
        p += 6;
      }
      let index = 1;
      let altura = 66;
      let position = 9.5;

      var che1X_1 = 109; // Posición X
      var che1Y_1 = 65; // Posición Y

      var che2X_1 = 95; // Posición X

      $.each(material, function (j, k) {
        /*console.log(material[j]);*/
        doc.text("" + index, position, altura); //correlativo numerico
        doc.text("" + k[2], 18, altura); //nombre del insumo
        doc.text("" + k[3], 47, altura); //lote
        if (k[5] == "g") {
          // Dibujar un check con líneas en la posición (50, 50)
          doc.line(che2X_1, che1Y_1, che2X_1 + 2, che1Y_1 + 2); // Dibujar una línea diagonal más corta
          doc.line(che2X_1 + 2, che1Y_1 + 2, che2X_1 + 4, che1Y_1 - 2); // Dibujar otra línea diagonal más corta
        } else {
          //Dibujar un check con líneas en la posición (50, 50)
          doc.line(che1X_1, che1Y_1, che1X_1 + 2, che1Y_1 + 2); // Dibujar una línea diagonal más corta
          doc.line(che1X_1 + 2, che1Y_1 + 2, che1X_1 + 4, che1Y_1 - 2); // Dibujar otra línea diagonal más corta
        } //gramos o kilos
        doc.text("" + k[4], 122, altura); //peso
        index++;
        if (index > 9) {
          position = 8.5;
        }
        altura += 6;
        che1Y_1 += 6;
      });
      doc.setFontSize(7);
      doc.line(9, 200, 60, 200); //linea horizontal de firma 1
      doc.text("Firma del Asistente de calidad", 18, 205); //text de firma 1
      doc.line(78, 200, 135, 200); //linea horizontal de firma 2
      doc.text("Firma del Jefe de Aseguramiento de la calidad", 80, 205); //text de firma 2*/
      /*------------*/
    }
    if (i % 2 != 0 || hojbla == 1) {
      if (hojbla == 1) {
        operario = "";
        cantidad = "";
        bachada = "";
        fecha = "";
        lote = "";
        producto = "";
        material = [];
      }
      doc.setFontSize(9);
      /*segunda columna*/
      doc.text("OPERARIO: " + operario, 160, 31);
      doc.line(178, 32, 220, 32); //linea horizontal

      doc.text("CANTIDA DE PRODUCTO: ", 160, 38);
      doc.text(cantidad, 205, 38);
      doc.line(200, 39, 220, 39); //linea horizontal

      doc.text("N° DE BACHADAS: ", 160, 45);
      doc.text(bachada, 205, 45);
      doc.line(189, 46, 220, 46); //linea horizontal

      doc.text("PRODUCTO: " + producto, 222, 31);
      doc.line(241, 32, 290, 32); //linea horizontal

      doc.text("FECHA:", 222, 38);
      doc.text(fecha, 250, 38);
      doc.line(234, 39, 290, 39); //linea horizontal

      doc.text("LOTE: ", 222, 45);
      doc.text(lote, 250, 45);
      doc.line(232, 46, 290, 46); //linea horizontal/**/

      doc.setFontSize(9);
      doc.setFont("helvetica", "bold");

      /*--------------SEGUNDA TABLA */
      doc.line(159, 52, 290, 52); //primera linea horizontal/**/
      doc.text("N°", 162.5, 58);
      doc.text("MATERIA PRIMA /", 171, 56);
      doc.text("INSUMO", 180, 60);
      doc.text("CÓDIGO/LOTE ", 209, 58);
      doc.text("PRESENTACIÓN", 245, 56);
      doc.text("g", 249, 60.5);
      doc.text("KG", 261, 60.5);
      doc.text("CANTIDAD", 271.8, 58);
      doc.line(159, 62, 290, 62); //ultima horizontal/**/

      doc.line(159, 52, 159, 194); //prmera linea vertical/**/
      doc.line(169, 52, 169, 188); //segunda linea vertical
      doc.line(200, 52, 200, 188); // tercera linea vertical
      doc.line(243, 52, 243, 188); // cuarta linea vertical
      doc.line(243, 57, 271, 57); //linea horizontal
      doc.line(257, 57, 257, 188); //quinta linea vertical
      doc.line(271, 52, 271, 194); //sexta linea vertical
      doc.line(290, 52, 290, 194); //linea vertical

      let s = 68;
      for (let i = 0; i < 22; i++) {
        doc.line(159, s, 290, s); //linea horizontal
        s += 6;
      }

      let index2 = 1;
      let altura2 = 66;
      let position2 = 162.5;

      var che1X_2 = 262; // Posición X
      var che1Y_2 = 65; // Posición Y

      var che2X_2 = 248; // Posición X
      $.each(material, function (s, a) {
        /*console.log(material[j]);*/
        doc.text("" + index2, position2, altura2); //correlativo numerico
        doc.text("" + a[2], 173, altura2); //nombre del insumo
        doc.text("" + a[3], 201, altura2); //lote
        if (a[5] == "g") {
          // Dibujar un check con líneas en la posición (50, 50)
          doc.line(che2X_2, che1Y_2, che2X_2 + 2, che1Y_2 + 2); // Dibujar una línea diagonal más corta
          doc.line(che2X_2 + 2, che1Y_2 + 2, che2X_2 + 4, che1Y_2 - 2); // Dibujar otra línea diagonal más corta/**/
        } else {
          // Dibujar un check con líneas en la posición (50, 50)
          doc.line(che1X_2, che1Y_2, che1X_2 + 2, che1Y_2 + 2); // Dibujar una línea diagonal más corta
          doc.line(che1X_2 + 2, che1Y_2 + 2, che1X_2 + 4, che1Y_2 - 2); // Dibujar otra línea diagonal más corta/**/
        } //gramos o kilos/**/
        doc.text("" + a[4], 274.5, altura2); //peso

        index2++;
        if (index2 > 9) {
          position2 = 162.5;
        }
        altura2 += 6;
        che1Y_2 += 6;
      });
      doc.setFontSize(7);
      doc.line(162, 200, 212, 200); //linea horizontal de firma 1
      doc.text("Firma del Asistente de calidad", 170, 205); //text de firma 1
      doc.line(230, 200, 287.5, 200); //linea horizontal de firma 2
      doc.text("Firma del Jefe de Aseguramiento de la calidad", 232, 205); //text de firma 2
      /*------------*/
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
