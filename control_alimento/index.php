<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/responsiveControl.css">
  <!--====== Favicon Icon ======-->
  <link rel="shortcut icon" href="./images/icon/covifarma-ico.ico" type="images/png">

  <!--==== Estilos de SWEETALERT2 =====-->
  <link rel="stylesheet" href="./css/sweetalert2.min.css">
  <link rel="stylesheet" href="./styleIcons/style.css">
  <title>Covifarma</title>
</head>

<body>

  <nav class="nav">
    <i class="icon-menu navOpenBtn"></i>
    <a class="logo" href="./"><img src="./images/logo-covifarma.png" alt=""></a>
    <ul class="nav-links">
      <div class="icon-cross navCloseBtn"></div>
      <li>
        <a class="" aria-current="page" href="phs.php">PHS</a>
      </li>
      <li>
        <a class="" href="vpm.php">VPM</a>
      </li>
    </ul>
  </nav>
  <?php
  require_once "modal.php";
  ?>

  <script src="./js/bootstrap.min.js"></script>

  <script src="./js/jquery-3.7.0.min.js"></script>
  <script src="./js/sweetalert2.all.min.js"></script>

  <script src="./js/ajaxFechaAviso.js"></script>
  <!-- <script src="./js/ajaxFechaAvisoControl.js"></script> -->
  <script src="./js/ajaxIndex.js"></script>
</body>

</html>