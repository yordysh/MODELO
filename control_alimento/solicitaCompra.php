<?php
session_start();

// $codusuario = $_SESSION["cod"];
// $oficina=$_SESSION["ofi"];

$codusuario = '0002';
?>
<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/responsiveOrdenCompra.css">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="./images/icon/covifarma-ico.ico" type="images/png">

    <!--====== Estilo de ICON ======-->
    <link rel="stylesheet" href="./styleIcons/style.css">
    <link rel="stylesheet" href="./css/select2.min.css">
    <title>Covifarma</title>

</head>

<body>
    <!-- preloader -->
    <div class="preloader" style="display: none;">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- fin -->
    <nav class="nav">
        <div class="wave"></div>
        <i class="icon-menu navOpenBtn"></i>
        <a class="logo" href="./"><img src="./images/logo-covifarma.png" alt=""></a>
        <ul class="nav-links">
            <div class="icon-cross navCloseBtn"></div>
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
                <a class="activo">Compras realizar</a>
                <ul class="menu-vertical">
                    <li>
                        <a class="" href="#">Solicitar compra</a>
                    </li>
                    <li>
                        <a class="" href="ordenCompra.php">Orden de compra</a>
                    </li>
                    <li>
                        <a class="" href="generarComprobante.php">Generar comprobante</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="" href="cantidadMinimaProducto.php">Cantidad mínima</a>
            </li>
            <li>
                <a class="" href="produccionRequerimiento.php">Producción</a>
            </li>
            <li>
                <a class="" href="verificarRegistroEnvase.php">Avance producción</a>
            </li>
        </ul>
        <i class="icon-magnifying-glass search-icon" id="searchIcon"></i>
        <div class="search-box">
            <i class="icon-magnifying-glass search-icon"></i>
            <input type="search" id="search" placeholder="Buscar . . ." class="form-control me-2">
        </div>
    </nav>
    <main>
        <section>
            <div class="container g-4 row">
                <div class="row g-4 top-div">
                    <center><label class="title">ORDEN DE COMPRAS</label></center>
                </div>

                <div class="main">
                    <form method="post" action="" id="formularioOrdenCompra">
                        <input type="hidden" id="codpersonal" name="codpersonal" value="<?php echo $codusuario; ?>">


                        <!-- Tabla total orden de compra-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 200px!important; margin-top:30px;margin-bottom:20px;">
                            <table id="tOrdenComprarequerimiento" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="" scope="col">CODIGO REQUERIMIENTO</th>
                                        <th class="" scope="col">FECHA</th>
                                        <th class="" scope="col">MIRAR</th>
                                        <th class="" scope="col">APROBAR</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaordencomprarequerimiento">

                                </tbody>
                            </table>
                        </div>
                        <!--------------------------------->
                        <!-- Tabla total ORDEN DE COMPRA ITEM-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 200px!important; margin-top:30px;margin-bottom:20px;">
                            <table id="tOrdenCompra" class="table table-sm mb-3 table-hover">
                                <div class="row g-4 top-div">
                                    <center><label class="title">PRODUCTOS A COMPRAR</label></center>
                                </div>
                                <thead>
                                    <tr>
                                        <th class="" scope="col">INSUMOS</th>
                                        <th class="" scope="col">CANTIDAD FALTANTE</th>
                                        <th class="" scope="col">CANTIDAD POR COMPRAR</th>

                                    </tr>
                                </thead>
                                <tbody id="tablatotalordencompra">

                                </tbody>
                            </table>
                        </div>
                        <!--------------------------------->
                    </form>

                </div>
            </div>
        </section>
    </main>
    <footer class="bg-dark p-2 mt-5 text-light position-fixed bottom-0 w-100 text-center">
        Covifarma-2023
    </footer>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.7.0.min.js"></script>
    <script src="./js/sweetalert2.all.min.js"></script>
    <script src="./js/ajaxSolicitaCompra.js"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>