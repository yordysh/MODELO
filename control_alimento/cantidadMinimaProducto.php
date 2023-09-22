<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataCantidadMinima = $mostrar->MostrarProductoComboRegistro();

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
                <a class="" href="requerimientoProducto.php">Requerimiento</a>
            </li>
            <li>
                <a class="" href="pedidoRequerimiento.php">Confirmación de requerimiento</a>
            </li>
            <li>
                <a class="" href="ordenCompra.php">Orden de compra</a>
            </li>
            <li>
                <a class="" href="#">Cantidad mínima</a>
            </li>
            <!-- <li>
                <a class="" href="registroEnvases.php">Registros envases</a>
            </li> -->
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
                    <center><label class="title">CANTIDAD MINIMA DE COMPRA</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formulariocantidadminima">

                        <!-- Insertar nuevas cantidades -->
                        <div class="contenedor">
                            <div class="mb-3">
                                <label class="form-label">Productos</label>
                                <select id="selectCantidadminima" class="form-select" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione producto</option>
                                    <?php foreach ($dataCantidadMinima as $lis) {
                                    ?>
                                        <option value="<?php echo $lis['COD_PRODUCTO']; ?>" class="option"><?php echo $lis['ABR_PRODUCTO'] . " "; ?> <?php echo $lis['DES_PRODUCTO']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cantidad minima</label>
                                <input class="form-control" type="number" id="cantidadMinima" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57" required></input>
                            </div>
                        </div>
                        <div class="">
                            <input type="hidden" id="taskId">
                            <button id="botonminimo" type="submit" name="insert" class="btn btn-primary bt-insert">Guardar </button>
                        </div>
                    </form>
                    <!-- Tabla de insumos que se requiere-->
                    <div class="table-responsive" style="overflow: scroll;height: 300px; margin-top:20px;">
                        <table id="tcantidadminima" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <th class="" scope="col">INSUMOS</th>
                                    <th class="" scope="col">CANTIDAD</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tablacantidadminima">

                            </tbody>
                        </table>
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
    <script src="./js/ajaxCantidadMinima.js"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>