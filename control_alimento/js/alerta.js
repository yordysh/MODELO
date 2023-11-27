$(function () {
  $("#botonalertaguardar").click(function () {
    let valores = [];

    $("#tablaalerta tr").each(function () {
      var total = $(this).find("td:eq(0)");
      var rowspan = total.attr("rowspan");

      if (rowspan) {
        rowspan = parseInt(rowspan);
        var text = total.text().trim();
        for (var i = 0; i < rowspan; i++) {
          valores.push({ total: text });
        }
      } else {
        valores.push({ total: total.text().trim() });
      }
    });

    console.log(valores);
  });
});
