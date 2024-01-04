var svgString;
$(document).ready(function () {
  window.jsPDF = window.jspdf.jsPDF;
  $("#generarPDF").on("click", function () {
    // buscarimgguardada();
    exportardatoscompra();
  });
});

function exportardatoscompra() {
  var doc = new jsPDF({
    orientation: "portrait",
  });
  limitleft = 6;
  var logo = new Image();
  logo.src = "recursos/img_lab.jpg";
  doc.setFont(undefined, "normal");
  doc.setFontSize(12);
  doc.line(10, 8, 200, 8); //linea horizontal cabecera
  doc.line(10, 8, 10, 25); //linea vertical cabecera izquierda
  doc.addImage(logo.src, "JPG", 10.2, 8.4, 40, 16); //imagen posisionada
  doc.line(10, 25, 200, 25); //linea horizontal
  doc.line(200, 8, 200, 25); //linea vertical cabecera derecha
  doc.line(50, 8, 50, 25); // linea vertical separacion imagen
  doc.line(150, 8, 150, 25); // linea vertical nombrede reporte
  doc.line(150, 13.5, 200, 13.5); // linea separacion para fecha version
  doc.line(150, 18.5, 200, 18.5); // linea separacion para fecha version

  doc.setFontSize(13);
  doc.setFont("helvetica", "bold");
  doc.text("CONTROL DE ENVASADO Y ENCAJADO", 55, 19); //TITULO CONTROL
  doc.setFont("helvetica", "normal");
  doc.setFontSize(10);
  doc.text("LBS-OP-FR-05", 151, 12); //LBS-OP-FR-05
  doc.text("Versión:", 151, 18); //Version
  doc.text("Fecha:", 151, 24); //fecha

  /*-------------cabecera del cuerpo----------------------------- */
  // primera fila
  doc.setFontSize(9);
  doc.text("RESPONSABLE:", 10, 32);
  doc.line(40, 32, 70, 32);
  doc.text("LOTE:", 75, 32);
  doc.line(90, 32, 120, 32);
  doc.text("FECHA DE ENVASADO:", 125, 32);
  doc.line(166, 32, 190, 32);

  // segunda fila
  doc.text("PRODUCTO:", 10, 38);
  doc.line(32, 38, 62, 38);
  doc.text("PRESENTACION:", 65, 38);
  doc.line(92, 38, 120, 38);
  doc.text("FECHA DE CERNIDO:", 125, 38);
  doc.line(166, 38, 190, 38);

  /*------------------------------------------------------------ */
  /*--------CUERPO DEL PDF------------------------------------ */

  doc.setFontSize(8);
  doc.setFont("helvetica", "bold");
  doc.line(10, 43, 100, 43); //LINEA HORIZONTAL DEL CUAFRO PARTE SUPERIOR
  doc.line(10, 43, 10, 60); // LINEA IZQUIERDA DE SEPARACION 1
  doc.text("N°", 11, 52);
  doc.line(15, 43, 15, 60); // LINEA IZQUIERDA DE SEPARACION 2
  doc.text("Peso del", 18, 57, { angle: 90 });
  doc.text("producto", 21, 57, { angle: 90 });
  doc.line(24, 43, 24, 60); // LINEA IZQUIERDA DE SEPARACION 3
  doc.line(33, 43, 33, 60); // LINEA IZQUIERDA DE SEPARACION 4
  doc.text("*Sellado", 27, 58, { angle: 90 });
  doc.text("hermético", 30, 58, { angle: 90 });
  doc.line(40, 43, 40, 60); // LINEA IZQUIERDA DE SEPARACION 5
  doc.text("*Rotulado", 36.5, 58, { angle: 90 });
  doc.line(70, 43, 70, 60); // LINEA IZQUIERDA DE SEPARACION 6
  doc.text("Observaciones", 41, 52.4);
  doc.line(100, 43, 100, 60); // LINEA IZQUIERDA DE SEPARACION 7
  doc.text("Acciones correctivas", 71, 52.4);
  doc.line(10, 60, 100, 60); //LINEA HORIZONTAL DEL CUADRO PARTE INFERIOR

  doc.line(10, 60, 10, 144); //LINEA DE SEPARACION VERTICAL IZQUIERDA 1
  doc.line(15, 60, 15, 144); //LINEA DE SEPARACION VERTICAL IZQUIERDA 2
  doc.line(24, 60, 24, 144); //LINEA DE SEPARACION VERTICAL IZQUIERDA 3
  doc.line(33, 60, 33, 144); //LINEA DE SEPARACION VERTICAL IZQUIERDA 4
  doc.line(40, 60, 40, 144); //LINEA DE SEPARACION VERTICAL IZQUIERDA 5
  doc.line(70, 60, 70, 144); //LINEA DE SEPARACION VERTICAL IZQUIERDA 6
  doc.line(100, 60, 100, 144); //LINEA DE SEPARACION VERTICAL IZQUIERDA 7

  doc.line(10, 64.2, 100, 64.2); // LINEA HORIZONTAL 1
  doc.text("1", 12, 63.7);
  doc.line(10, 68.4, 100, 68.4); // LINEA HORIZONTAL 2
  doc.text("2", 12, 68);
  doc.line(10, 72.6, 100, 72.6); // LINEA HORIZONTAL 3
  doc.text("3", 12, 72);
  doc.line(10, 76.8, 100, 76.8); // LINEA HORIZONTAL 4
  doc.text("4", 12, 76.4);
  doc.line(10, 81, 100, 81); // LINEA HORIZONTAL 5
  doc.text("5", 12, 80.1);
  doc.line(10, 85.2, 100, 85.2); // LINEA HORIZONTAL 6
  doc.text("6", 12, 85);
  doc.line(10, 89.4, 100, 89.4); // LINEA HORIZONTAL 7
  doc.text("7", 12, 89.1);
  doc.line(10, 93.6, 100, 93.6); // LINEA HORIZONTAL 8
  doc.text("8", 12, 93.2);
  doc.line(10, 97.8, 100, 97.8); // LINEA HORIZONTAL 9
  doc.text("9", 12, 97.5);
  doc.line(10, 102, 100, 102); // LINEA HORIZONTAL 10
  doc.text("10", 11, 101.2);
  doc.line(10, 106.2, 100, 106.2); // LINEA HORIZONTAL 11
  doc.text("11", 11, 105.9);
  doc.line(10, 110.4, 100, 110.4); // LINEA HORIZONTAL 12
  doc.text("12", 11, 110);
  doc.line(10, 114.6, 100, 114.6); // LINEA HORIZONTAL 13
  doc.text("13", 11, 114.1);
  doc.line(10, 118.8, 100, 118.8); // LINEA HORIZONTAL 14
  doc.text("14", 11, 118.3);
  doc.line(10, 123, 100, 123); // LINEA HORIZONTAL 15
  doc.text("15", 11, 122.9);
  doc.line(10, 127.2, 100, 127.2); // LINEA HORIZONTAL 16
  doc.text("16", 11, 127);
  doc.line(10, 131.4, 100, 131.4); // LINEA HORIZONTAL 17
  doc.text("17", 11, 131);
  doc.line(10, 135.6, 100, 135.6); // LINEA HORIZONTAL 18
  doc.text("18", 11, 135.1);
  doc.line(10, 139.8, 100, 139.8); // LINEA HORIZONTAL 19
  doc.text("19", 11, 139.4);
  doc.line(10, 144, 100, 144); // LINEA FINAL
  doc.text("20", 11, 143.5);

  /*--------------------------------------------------------- */

  /*---------------- SEGUNDO CUADRO COLUMNA 2--------------- */
  doc.line(110, 43, 200, 43); //LINEA DE SEPARACION 1
  doc.line(110, 48, 200, 48); //LINEA DE SEPARACION 2
  doc.line(110, 53, 200, 53); //LINEA DE SEPARACION 3
  doc.text("Llenado", 111, 52);
  doc.line(110, 58, 200, 58); //LINEA DE SEPARACION 4
  doc.text("1", 112, 57);
  doc.line(160, 53, 160, 58); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 53, 180, 58); //LINEA DE SEPARACION VERTICAL
  doc.line(110, 63, 200, 63); //LINEA DE SEPARACION 5
  doc.text("2", 112, 62);
  doc.line(160, 58, 160, 63); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 58, 180, 63); //LINEA DE SEPARACION VERTICAL
  doc.line(110, 68, 200, 68); //LINEA DE SEPARACION 6
  doc.text("Pesado, colocación de cucharita y alupol", 110.5, 67);
  doc.line(110, 73, 200, 73); //LINEA DE SEPARACION 7
  doc.text("1", 112, 72.4);
  doc.line(160, 68, 160, 73); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 68, 180, 73); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 78, 200, 78); //LINEA DE SEPARACION 8

  doc.text("2", 112, 77);
  doc.line(160, 73, 160, 78); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 73, 180, 78); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 83, 200, 83); //LINEA DE SEPARACION 9
  doc.text("Pre-limpiado", 110.5, 82);
  doc.line(110, 88, 200, 88); //LINEA DE SEPARACION 10
  doc.text("1", 112, 87);
  doc.line(160, 83, 160, 88); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 83, 180, 88); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 93, 200, 93); //LINEA DE SEPARACION 11
  doc.text("2", 112, 92);
  doc.line(160, 88, 160, 93); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 88, 180, 93); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 98, 200, 98); //LINEA DE SEPARACION 12
  doc.text("Sellado", 110.5, 97);
  doc.line(110, 103, 200, 103); //LINEA DE SEPARACION 13
  doc.text("1", 112, 102);
  doc.line(160, 98, 160, 103); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 98, 180, 103); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 108, 200, 108); //LINEA DE SEPARACION 14
  doc.text("2", 112, 107);
  doc.line(160, 103, 160, 108); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 103, 180, 108); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 113, 200, 113); //LINEA DE SEPARACION 15
  doc.text("Codificado", 110.5, 112);
  doc.line(110, 118, 200, 118); //LINEA DE SEPARACION 16
  doc.text("1", 112, 117);
  doc.line(160, 113, 160, 118); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 113, 180, 118); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 123, 200, 123); //LINEA DE SEPARACION 17
  doc.text("2", 112, 122);
  doc.line(160, 118, 160, 123); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 118, 180, 123); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 128, 200, 128); //LINEA DE SEPARACION 18
  doc.text("Tapado", 110.5, 127);
  doc.line(110, 133, 200, 133); //LINEA DE SEPARACION 19
  doc.text("1", 112, 132);
  doc.line(160, 128, 160, 133); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 128, 180, 133); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 138, 200, 138); //LINEA DE SEPARACION 20
  doc.text("2", 112, 137);
  doc.line(160, 133, 160, 138); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 133, 180, 138); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 143, 200, 143); //LINEA DE SEPARACION 21
  doc.text("Limpiado", 110.5, 142);
  doc.line(110, 148, 200, 148); //LINEA DE SEPARACION 22
  doc.text("1", 112, 147);
  doc.line(160, 138, 160, 143); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 138, 180, 143); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 153, 200, 153); //LINEA DE SEPARACION 23
  doc.text("2", 112, 152);
  doc.line(160, 148, 160, 153); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 148, 180, 153); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 158, 200, 158); //LINEA DE SEPARACION 24
  doc.text("Etiquetado", 110.5, 157);
  doc.line(110, 163, 200, 163); //LINEA DE SEPARACION 25
  doc.text("1", 112, 162);
  doc.line(160, 158, 160, 163); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 158, 180, 163); //LINEA DE SEPARACION VERTICAL

  doc.line(110, 168, 200, 168); //LINEA DE SEPARACION 26
  doc.text("2", 112, 167);
  doc.line(160, 163, 160, 168); //LINEA DE SEPARACION VERTICAL
  doc.line(180, 163, 180, 168); //LINEA DE SEPARACION VERTICAL

  doc.line(160, 43, 160, 48);
  doc.text("Personal operativo", 120, 46.4);
  doc.line(180, 43, 180, 48);
  doc.text("HI", 170, 46.4);
  doc.line(200, 43, 200, 48);
  doc.text("HS", 190, 46.4);

  doc.line(110, 43, 110, 168); // LINEA VERTICAL IZQUIERDA 1
  doc.line(200, 43, 200, 168); // LINEA VERTICAL IZQUIERDA 2

  /*------------------------------------------------------- */

  /*--------- PARTE INFERIOR DE LAS TABLAS ----------------- */
  doc.setFontSize(5);
  doc.text("Frecuencia: Cada lote producido", 10, 149);

  doc.setFontSize(6);
  doc.setFont("helvetica", "normal");
  doc.text("CANTIDAD ENVASES(UNIDAD):", 10, 153);
  doc.line(45, 153, 100, 153); //RAYA HORIZONTAL
  doc.text("CANTIDAD PRODUCIDA(CAJAS):", 10, 157);
  doc.line(45, 157, 100, 157); //RAYA HORIZONTAL
  doc.text("CANTIDAD DE PRODUCTO SOBRANTE(UNIDADES):", 10, 161);
  doc.line(64, 161, 100, 161); //RAYA HORIZONTAL
  doc.text("LOTE DE PRODUCTO ENVASADO:", 10, 165);
  doc.line(45, 165, 100, 165); //RAYA HORIZONTAL
  doc.text("FECHA DE VENCIMIENTO DEL PRODUCTO TERMINADO:", 10, 169);
  doc.line(70, 169, 100, 169); //RAYA HORIZONTAL
  doc.text("LOTE DE ENVASE UTILIZADO:", 10, 173);
  doc.line(46, 173, 100, 173); //RAYA HORIZONTAL

  doc.text("Pote", 10, 180);
  doc.line(20, 180, 40, 180); //RAYA HORIZONTAL
  doc.text("Alupol", 10, 183);
  doc.line(20, 183, 40, 183); //RAYA HORIZONTAL
  doc.text("Cucharita", 10, 186);
  doc.line(20, 186, 40, 186); //RAYA HORIZONTAL
  /*------------------------------------------------------ */
  /*-------------- TABLA CONTROL DE MERMA ---------------- */
  doc.line(75, 190, 200, 190); //HORIZONTAL
  doc.setFontSize(8);
  doc.text("Control de Merma", 95, 195);
  doc.text("Control de saldo", 165, 195);
  doc.line(75, 200, 200, 200); //HORIZONTAL
  doc.text("Envase y", 80, 203);
  doc.text("accesorios", 78, 206);
  doc.text("complementarios", 76, 209);

  doc.text("Cantidad", 101.5, 206);
  doc.text("Lote", 124, 206);

  doc.text("Cantidad", 144, 206);
  doc.text("Lote", 175, 206);

  doc.line(75, 210, 200, 210); //HORIZONTAL
  doc.line(75, 215, 200, 215); //HORIZONTAL
  doc.text("Alupol", 76, 213);
  doc.line(75, 220, 200, 220); //HORIZONTAL
  doc.text("Cuchara", 76, 218);
  doc.line(75, 225, 200, 225); //HORIZONTAL
  doc.text("Termoencogible", 76, 223);
  doc.line(75, 230, 200, 230); //HORIZONTAL
  doc.text("Frascos", 76, 228);
  doc.line(75, 235, 200, 235); //HORIZONTAL
  doc.text("Tapas", 76, 233);

  doc.line(75, 190, 75, 235); //VERTICAL
  doc.line(100, 200, 100, 235); //VERTICAL
  doc.line(115, 200, 115, 235); //VERTICAL
  doc.line(142, 190, 142, 235); //VERTICAL
  doc.line(157, 190, 157, 235); //VERTICAL
  doc.line(200, 190, 200, 235); //VERTICAL
  /*----------------------------------------------------- */
  /*-----------Observaciones y acciones------------------- */
  doc.text("Observaciones: ", 10, 245);
  doc.line(40, 245, 200, 245); //RAYA HORIZONTAL
  doc.line(10, 250, 200, 250); //RAYA HORIZONTAL
  doc.line(10, 255, 200, 255); //RAYA HORIZONTAL

  doc.text("Acciones correctivas: ", 10, 260);
  doc.line(40, 260, 200, 260); //RAYA HORIZONTAL
  doc.line(10, 265, 200, 265); //RAYA HORIZONTAL
  doc.line(10, 270, 200, 270); //RAYA HORIZONTAL
  /*----------------------------------------------------- */

  window.open(doc.output("bloburl"), "_blank");
}
