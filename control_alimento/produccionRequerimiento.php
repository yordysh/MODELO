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
                <a class="" href="formulacionEnvases.php">Formulacion</a>
            </li>
            <li>
                <a class="" href="requerimientoProducto.php">Requerimiento producto</a>
            </li>
            <li>
                <a class="" href="pedidoRequerimiento.php">Confirmacion de requerimiento</a>
            </li>
            <li>
                <a class="" href="cantidadMinimaProducto.php">Cantidad minima</a>
            </li>
            <!-- <li>
                <a class="" href="registroEnvases.php">Registros envases</a>
            </li> -->
            <li>
                <a class="" href="#">Produccion requerimiento</a>
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
                    <center><label class="title">PRODUCCION REQUERIMIENTO</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formularioPedidoRequerimiento">

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
                        </div>

                        <!-- Tabla total requerimiento pedido-->
                        <div class="table-responsive" style="overflow: scroll;height: 200px!important; margin-top:20px;margin-bottom:50px;">
                            <table id="tmostrarproduccionrequerimiento" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">CODIGO</th>
                                        <th class="thtitulo" scope="col">PRODUCTO</th>
                                        <th class="thtitulo" scope="col">CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaproduccionrequerimiento">

                                </tbody>
                            </table>
                        </div>

                        <!-- Text input producto seleccionado-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Producto</label>
                            <input type="hidden" id="idhiddencodrequerimiento">
                            <input type="hidden" id="idhiddenproducto">
                            <input type="text" id="productorequerimientoitem" class="form-control" name="" disabled>
                        </div>
                        <!-- Text input numero de produccion-->
                        <div class="form-outline mb-4">
                            <label class="form-label">N° produccion</label>
                            <input type="text" id="numeroproduccion" class="form-control" name="" required>
                        </div>

                        <!-- Text input cantidad produccion-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Cantidad produccion</label>
                            <input type="text" id="cantidadhiddentotalrequerimiento" class="form-control" name="" disabled>
                        </div>
                        <!-- Text input fecha inicio-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Fecha produccion</label>
                            <input type="date" id="fechainicio" class="form-control" name="">
                        </div>
                        <!-- Text input fecha inicio-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Fecha vencimiento</label>
                            <input type="date" id="fechavencimiento" class="form-control" name="">
                        </div>
                        <!-- Text input cantidad por caja-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Cantidad por caja</label>
                            <input type="number" id="cantidadcaja" class="form-control" name="" value="20">
                        </div>
                        <!-- Text input Observacion-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" id="textAreaObservacion" rows="3"></textarea>
                        </div>
                        <!-- Insertar produccion por requerimiento -->
                        <div class="contenedor">

                            <div class="ctnBtn">
                                <input type="hidden" id="taskcodrequerimiento">
                                <button id="insertarProduccionRequerimiento" name="produccionrequerimiento" class="btn btn-primary bt-insert">Guardar</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla total a comprar insumos-->
                    <!-- <div class="table-responsive" style="overflow: scroll;height: 300px; margin-top:20px;">
                        <table id="tTotalinsumoscomprar" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <th class="thtitulo" scope="col">INSUMOS</th>
                                    <th class="thtitulo" scope="col">CANTIDAD</th>
                                    <th class="thtitulo" scope="col">CANTIDAD COMPRA</th>

                                </tr>
                            </thead>
                            <tbody id="tablatotalinsumosrequeridoscomprar">

                            </tbody>
                        </table>
                    </div> -->


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
    <script src="./js/ajaxProduccionRequerimiento.js"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>