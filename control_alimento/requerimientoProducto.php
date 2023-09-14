<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
// $dataProducto = $mostrar->MostrarProductoComboRegistro();
$dataProductoTerminado = $mostrar->MostrarProductoTerminado();

?>
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

    <!--====== Estilo de ICON ======-->
    <link rel="stylesheet" href="./styleIcons/style.css">
    <link rel="stylesheet" href="./css/select2.min.css">
    <title>Covifarma</title>

</head>

<body>
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
                <a class="" href="#">Requerimiento</a>
            </li>
            <li>
                <a class="" href="pedidoRequerimiento.php">Confirmación de requerimiento</a>
            </li>
            <li>
                <a class="" href="cantidadMinimaProducto.php">Cantidad mónima</a>
            </li>
            <li>
                <a class="" href="produccionRequerimiento.php">Producción</a>
            </li>
            <li>
                <a class="" href="verificarRegistroEnvase.php">Registros envases</a>
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
                                <!-- <button id="botonCalcularInsumoEnvase" name="calcular" class="btn btn-success">Insertar</button> -->
                            </div>
                        </div>

                        <!-- Tabla de total de productos-->
                        <div id="tablaTotal" class="table-responsive" style="overflow: scroll;height: 200px!important; margin-top:20px;">
                            <div class="row g-4 top-div">
                                <center><label class="title_table">TOTAL DE PRODUCTOS</label></center>
                            </div>
                            <table class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>

                                        <th class="thtitulo" scope="col">PRODUCTOS</th>
                                        <th class="thtitulo" scope="col">CANTIDAD TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="tablainsumoenvasetotal">

                                </tbody>
                            </table>
                        </div>

                        <!-- Tabla de insumos-->
                        <div class="table-responsive" style="overflow: scroll;height: 300px; margin-top:20px;">
                            <div class="row g-4 top-div">
                                <center><label class="title_table">TOTAL DE INSUMOS POR PRODUCTO</label></center>
                            </div>
                            <table id="tinsumo" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th class="thtitulo" scope="col">NOMBRE PRODUCTO</th> -->
                                        <th class="thtitulo" scope="col">INSUMOS</th>
                                        <th class="thtitulo" scope="col">CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaInsumosDatos">

                                </tbody>
                            </table>
                        </div>


                        <!-- Tabla de insumos-->
                        <div class="table-responsive" style="overflow: scroll;height: 200px!important; margin-top:50px;">
                            <table id="tsumatotal" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">TOTAL INSUMOS</th>
                                    </tr>
                                </thead>
                                <tbody id="tablasumatotalinsumo">

                                </tbody>
                            </table>
                        </div>

                        <!-- Tabla de envases-->
                        <div id="tablaE" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">
                            <table class="table table-sm mb-3 table-hover">
                                <div class="row g-4 top-div">
                                    <center><label class="title_table">TOTAL DE ENVASES POR PRODUCTO</label></center>
                                </div>
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">ENVASES</th>
                                        <th class="thtitulo" scope="col">CANTIDAD</th>
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