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
  <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary bar-color">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold text-light" href="index.php"><img src="./images/logo-covifarma.png" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="zonaAreas.php">Zona/Areas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="infraestructuraAccesorios.php?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Infraestructura Accesorios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="preparacionSolucion.php">Preparación de soluciones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="limpiezaDesinfeccion.php">Limpieza y desinfección</a>
          </li>
        </ul>
      </div>
    </div>
  </nav> -->

  <nav class="nav">
    <i class="icon-menu navOpenBtn"></i>
    <a class="logo" href="./"><img src="./images/logo-covifarma.png" alt=""></a>
    <ul class="nav-links">
      <div class="icon-cross navCloseBtn"></div>
      <li>
        <a class="" aria-current="page" href="zonaAreas.php">Zona</a>
      </li>
      <li>
        <a class="" href="infraestructuraAccesorios.php">Infraestructura</a>
      </li>
      <li>
        <a class="" href="preparacionSolucion.php">Preparación de soluciones</a>
      </li>
      <li>
        <a class="" href="limpiezaDesinfeccion.php">Limpieza y desinfección</a>
      </li>
      <li>
        <a class="" href="controlMaquinas.php">Control de maquinas</a>
      </li>
      <li>
        <a class="" href="LabsabelForm.php">Labsabell</a>
      </li>
      <li>
        <a class="" href="previlifeForm.php">Previlife</a>
      </li>
      <li>
        <a class="" href="insumosLabsabellForm.php">Insumos labsabell</a>
      </li>
    </ul>
    <!-- <i class="icon-magnifying-glass search-icon" id="searchIcon"></i>
    <div class="search-box">
      <i class="icon-magnifying-glass search-icon"></i>
      <input type="search" id="search" placeholder="Buscar . . ." class="form-control me-2">
    </div> -->
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