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
            <!-- <li>
                <a class="" href="registroEnvases.php">Registros envases</a>
            </li> -->
            <li>
                <a class="" href="requerimientoProducto.php">Requerimiento produccion</a>
            </li>
            <li>
                <a class="" href="#">Pedido requerimiento</a>
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
                    <center><label class="title">PEDIDO DE REQUERIMIENTOS</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formularioPedidoRequerimiento">

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
                        </div>

                        <!-- Button de estados pendiente o no pendiente -->
                        <!-- <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="pendiente">
                            <label class="form-check-label" for="pendiente">
                                Pendientes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="nopendiente" checked>
                            <label class="form-check-label" for="nopendiente">
                                No pendientes
                            </label>
                        </div> -->

                        <!-- Insertar nuevas cantidades -->
                        <div class="contenedor">
                            <div class="ctnBtn">
                                <input type="hidden" id="taskId">
                                <button id="botonInsertValor" name="calcularInsEnv" class="btn btn-primary bt-insert">Guardar</button>

                                <!-- <button id="boton" type="submit" name="insert" class="btn btn-primary bt-guardar">Insertar</button> -->
                            </div>
                        </div>

                        <!-- Tabla de requerimiento-->
                        <div class="table-responsive" style="overflow: scroll;height: 300px; margin-top:20px;">
                            <table id="trequerimiento" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">PRODUCTO</th>
                                        <th class="thtitulo" scope="col">CANTIDAD</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tablaPedidoRequerimiento">

                                </tbody>
                            </table>
                        </div>
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
    <script src="./js/ajaxPedidoRequerimiento.js"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>