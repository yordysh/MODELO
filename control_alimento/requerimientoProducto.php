<?php
session_start();

$codusuario = $_SESSION["cod"];
// $codusuario = 'Raul';

?>

<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataProductoTerminado = $mostrar->MostrarProductoTerminado();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/responsivePO.css">
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
                <a class="activo" href="#">Requerimiento</a>
            </li>
            <li>
                <a class="" href="pedidoRequerimiento.php">Confirmación de requerimiento</a>
            </li>
            <!-- <li>
                <a class="" href="solicitaCompra.php">Solicitar compra</a>
            </li> -->
            <li>
                <a class="">Compras realizar</a>
                <ul class="menu-vertical">
                    <li>
                        <a class="" href="solicitaCompra.php">Solicitar compra</a>
                    </li>
                    <li>
                        <a class="" href="generarComprobante.php">Generar comprobante</a>
                    </li>
                    <li>
                        <a class="" href="ordenCompra.php">Orden de compra</a>
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
                    <center><label class="title">REQUERIMIENTO DE PRODUCTOS</label></center>
                </div>
                <div class="main">
                    <form class="formSpace" method="post" action="" id="formularioRequerimientoProducto">
                        <input type="hidden" id="codpersonal" name="codpersonal" value="<?php echo $codusuario; ?>">
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
                        </div>

                        <!--Combo Productos -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Producto</label>
                            <select id="selectInsumoEnvase" class="form-select selectProducto" aria-label="Default select example">
                                <option value="none" selected disabled>Seleccione producto</option>
                                <?php foreach ($dataProductoTerminado as  $lis) { ?>
                                    <option value="<?php echo $lis['COD_PRODUCTO']; ?>" class="option"><?php echo ($lis['ABR_PRODUCTO'] . " "); ?><?php echo $lis['DES_PRODUCTO']; ?></option>
                                <?php
                                }

                                ?>
                            </select>
                        </div>

                        <!-- Text input cantidad -->
                        <div class="contenedorcantidadcalculo">
                            <div class="form-outline mb-4">
                                <label class="form-label">Cantidad</label>
                                <input type="number" id="cantidadInsumoEnvase" class="form-control" name="cantidadProducto" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                            </div>
                            <div class="btncalcular">
                                <button class="custom-icon-calcular" name="calcular" id="botonCalcularInsumoEnvase"><i class="icon-circle-with-plus"></i></button>
                            </div>
                        </div>

                        <!-- Tabla de total de productos-->
                        <div id="tablaTotal" class="table-responsive" style="overflow-x: hidden;height: 200px!important; margin-top:20px;">
                            <div class="row g-4 top-div">
                                <label class="title_table">TOTAL DE PRODUCTOS</label>
                            </div>
                            <table class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="" scope="col">PRODUCTOS</th>
                                        <th class="" scope="col">CANTIDAD TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="tablainsumoenvasetotal">

                                </tbody>
                            </table>
                        </div>

                        <!-- Tabla de insumos-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 300px; margin-top:20px;">

                            <table id="tinsumo" class="table table-sm mb-3 table-hover">
                                <div class="row g-4 top-div">
                                    <label class="title_table">TOTAL DE INSUMOS POR PRODUCTO</label>
                                </div>
                                <thead>

                                    <tr>
                                        <th class="" scope="col">INSUMOS</th>
                                        <th class="" scope="col">CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaInsumosDatos">

                                </tbody>
                            </table>
                        </div>


                        <!-- Tabla de insumos-->
                        <div class="table-responsive totalinsumo" style="overflow-x: hidden;height: 100px!important; margin-top:10px;margin-left:600px;">
                            <table id="tsumatotal" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtotalinsumo" scope="col">TOTAL INSUMOS</th>
                                    </tr>
                                </thead>
                                <tbody id="tablasumatotalinsumo">

                                </tbody>
                            </table>
                        </div>

                        <!-- Tabla de envases-->
                        <div id="tablaE" class="table-responsive " style="overflow-x: hidden;height: 600px; margin-top:20px;">
                            <table class="table table-sm mb-3 table-hover">
                                <div class="row g-4 top-div">
                                    <label class="title_table">TOTAL DE ENVASES POR PRODUCTO</label>
                                </div>
                                <thead>
                                    <tr>
                                        <th class="" scope="col">ENVASES</th>
                                        <th class="" scope="col">CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaenvase">

                                </tbody>
                            </table>
                        </div>

                        <!-- Insertar nuevas cantidades -->

                        <input type="hidden" id="taskId">
                        <button style="margin-bottom: 80px;" id="botonInsertValor" name="calcularInsEnv" class="btn btn-primary boton-insertar">Guardar</button>

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
    <script src="./js/ajaxRequerimientoProducto.js"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>