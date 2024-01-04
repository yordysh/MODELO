<?php
session_start();

$codusuario = $_SESSION["cod"];
// $codanexo=$_SESSION["ane"];
// $codusuario = 'Raul';
// $codanexo = '1010';

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
    <!-- <nav class="nav">
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
                <a class="pedidoRequerimiento activo" href="#">Confirmación de requerimiento</a>
            </li>
            <li>
                <a class="">Compras realizar</a>
                <ul class="menu-vertical">
                    <li>
                        <a class="" href="solicitaCompra.php">Solicitar compra</a>
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
    </nav> -->
    <?php
    require_once('../menulista/index.php');
    ?>
    <main>
        <section>
            <div class="container g-4 row">
                <div class="row g-4 top-div">
                    <center><label class="title">REQUERIMIENTOS</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formularioPedidoRequerimiento">
                        <input type="hidden" id="codpersonal" name="codpersonal" value="<?php echo $codusuario; ?>">
                        <!-- <input type="hidden" id="codanexo " name="codanexo " value="<?php echo $codanexo; ?>"> -->
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
                        </div>

                        <!-- Tabla total requerimiento pedido-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 200px!important; margin-top:30px;margin-bottom:20px;">
                            <div class="row g-4 top-div">
                                <center><label class="title_table">REQUERIMIENTOS PENDIENTES</label></center>
                            </div>
                            <table id="tmostrartotalpendientes" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">CODIGO</th>
                                        <th class="thtitulo" scope="col">FECHA</th>
                                        <th class="thtitulo" scope="col">PENDIENTE</th>
                                        <th class="thtitulo" scope="col">RECHAZAR</th>
                                    </tr>
                                </thead>
                                <tbody id="tablamostartotalpendientes">

                                </tbody>
                            </table>
                        </div>


                        <!-- Tabla de producto por reuqerimiento que se requiere-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 300px; margin-top:20px;">
                            <div class="row g-4 top-div">
                                <center><label class="title_table">PRODUCTOS TOTALES DEL PENDIENTE</label></center>
                            </div>
                            <table id="tproductorequerido" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">PRODUCTO</th>
                                        <th class="thtitulo" scope="col">CANTIDAD</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tablaproductorequerido">

                                </tbody>
                            </table>
                        </div>

                        <!-- Tabla de insumos por requerimiento que se requiere-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 300px; margin-top:20px;">
                            <div class="row g-4 top-div">
                                <center><label class="title_table">INSUMOS Y ENVASES DE LOS PRODUCTOS</label></center>
                            </div>
                            <table id="tinsumorequerido" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">INSUMOS</th>
                                        <th class="thtitulo" scope="col">CANTIDAD</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tablainsumorequerido">

                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Tabla total a comprar insumos-->
                    <div class="table-responsive" style="overflow-x: hidden;height: 300px; margin-top:20px;">
                        <div class="row g-4 top-div">
                            <center><label class="title_table">INSUMOS Y ENVASES POR COMPRAR</label></center>
                        </div>
                        <table id="tTotalinsumoscomprar" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <th class="thtitulo" scope="col">PRODUCTO</th>
                                    <th class="thtitulo" scope="col">CANTIDAD FALTANTE</th>
                                    <th class="thtitulo" scope="col">STOCK ACTUAL</th>
                                    <th class="thtitulo" scope="col">CANTIDAD MINIMA</th>
                                    <th class="thtitulo" scope="col">CANTIDAD POR COMPRA</th>
                                    <th class="thtitulo" scope="col">PRECIO MINIMO</th>
                                </tr>
                            </thead>
                            <tbody id="tablatotalinsumosrequeridoscomprar">

                            </tbody>
                        </table>
                    </div>

                    <!-- Insertar nuevas cantidades -->
                    <div class="contenedor">

                        <div class="ctnBtn">
                            <input type="hidden" id="taskcodrequhiddenvalidar">
                            <button id="insertarCompraInsumos" name="calcularInsEnv" class="btn btn-primary boton-insertar">Guardar</button>
                            <input type="text" id="mensajecompleto" style="width: 270px; font-weight:bold; display:none;" value="Insumos completos en el almacen" disabled>
                            <!-- <button id="boton" type="submit" name="insert" class="btn btn-primary bt-guardar">Insertar</button> -->
                        </div>
                    </div>
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
    <script src="./js/ajaxPedidoRequerimiento.js?v=0.001"></script>
    <script src="../js/menu_a.js"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>