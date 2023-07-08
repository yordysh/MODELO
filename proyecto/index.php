<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/responsive.css">
  <!--====== Favicon Icon ======-->
  <link rel="shortcut icon" href="../images/icon/covifarma-ico.ico" type="images/png">

  <!--==== Estilos de SWEETALERT2 =====-->
  <link rel="stylesheet" href="../css/sweetalert2.min.css">

  <title>Covifarma</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary bar-color">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold text-light" href="./index.php"><img src="../images/logo-covifarma.png" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./zonaAreas.php">Zona/Areas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./infraestructuraAccesorios.php">Infraestructura Accesorios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./preparacionSolucion.php">Preparación de soluciones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./limpiezaDesinfeccion.php">Limpieza y desinfección</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <?php
  require_once "modal.php";
  ?>

  <script src="../js/bootstrap.min.js"></script>

  <script src="../js/jquery-3.7.0.min.js"></script>
  <script src="../js/sweetalert2.all.min.js"></script>

  <script src="./js/ajaxFechaAviso.js"></script>
</body>

</html>