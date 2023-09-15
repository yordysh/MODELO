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
  <style>
    .menu-vertical {
      position: absolute;
      display: none;
      list-style: none;
      width: 150px;
      background-color: #5b8ccc;

    }

    .nav-links li:hover .menu-vertical {
      display: block;
    }

    .menu-vertical li:hover {
      background-color: rgba(0, 0, 0, .5);
    }

    .menu-vertical li a {
      display: block;
      color: #FFFFFF;

    }
  </style>
</head>

<body>

  <nav class="nav">
    <div class="wave"></div>
    <i class="icon-menu navOpenBtn"></i>
    <a class="logo" href="./"><img src="./images/logo-covifarma.png" alt=""></a>
    <ul class="nav-links">
      <div class="icon-cross navCloseBtn"></div>
      <li>
        <a class="phsStyle" aria-current="page">PHS</a>
        <ul class="menu-vertical">
          <li>
            <a class="" href="infraestructuraAccesorios.php">LBS-PHS-FR-01</a>
          </li>
          <li>
            <a class="" href="preparacionSolucion.php">LBS-PHS-FR-02</a>
          </li>
          <li>
            <a class="" href="controlMaquinas.php">LBS-PHS-FR-03</a>
          </li>
          <li>
            <a class="" href="limpiezaDesinfeccion.php">LBS-PHS-FR-04</a>
          </li>
        </ul>
      </li>
      <li>
        <a class="bpmStyle">BPM</a>
        <ul class="menu-vertical">
          <li>
            <a class="" href="labsabelForm.php">Envases labsabell</a>
          </li>
          <!-- <li>
            <a class="" href="previlifeForm.php">Envases previlife</a>
          </li> -->
          <li>
            <a class="" href="insumosLabsabellForm.php">Insumos labsabell</a>
          </li>
        </ul>
      </li>
      <li>
        <a class="bpmStyle">OP</a>
        <ul class="menu-vertical">
          <li>
            <a class="" href="formulacionEnvases.php">Formulación</a>
          </li>
          <li>
            <a class="" href="requerimientoProducto.php">Requerimiento</a>
          </li>
          <li>
            <a class="" href="pedidoRequerimiento.php">Confirmación de requerimiento</a>
          </li>
          <li>
            <a class="" href="ordenCompra.php">Orden de compra</a>
          </li>
          <li>
            <a class="" href="cantidadMinimaProducto.php">Cantidad mínima</a>
          </li>
          <li>
            <a class="" href="registroEnvases.php">Producción</a>
          <li>
            <a class="" href="verificarRegistroEnvase.php">Registros envases</a>
          </li>
      </li>
    </ul>
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