function time() {
  // let date = new Date();
  // let h = date.getHours();
  // let m = date.getMinutes();
  // let s = date.getSeconds();
  // let session = "AM";
  // if (h == 0) {
  //   h = 12;
  // }
  // if (h > 12) {
  //   h = h - 12;
  //   session = "PM";
  // }
  // h = h < 10 ? "0" + h : h;
  // m = m < 10 ? "0" + m : m;
  // s = s < 10 ? "0" + s : s;

  // var digital = h + ":" + m + ":" + s + " " + session;
  // document.getElementById("reloj").innerHTML = digital;
  // setInterval(time, 1000);
  let accion = "fechaactualservidor";
  $.ajax({
    type: "POST",
    url: "./c_almacen.php",
    data: { accion: accion },
    success: function (response) {
      $("#reloj").text(response);
    },
  });
}
time();
