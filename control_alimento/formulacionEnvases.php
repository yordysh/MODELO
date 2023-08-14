<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataProducto = $mostrar->MostrarProductoComboRegistro();

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
        <i class="icon-menu navOpenBtn"></i>
        <a class="logo" href="./"><img src="./images/logo-covifarma.png" alt=""></a>
        <ul class="nav-links">
            <div class="icon-cross navCloseBtn"></div>

            <li>
                <a class="" href="#">Registros envases</a>
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
                    <center><label class="title">FORMULACION DE ENVASES</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formularioEnvasesFormula">

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="taskIdProducto" type="hidden" class="form-control" name="taskIdProducto" />
                        </div>

                        <!--Combo Productos -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Producto</label>
                            <select id="selectProductoCombo" class="form-select selectProducto" aria-label="Default select example">
                                <option value="none" selected disabled>Seleccione producto</option>
                                <?php foreach ($dataProducto as  $lis) { ?>
                                    <option value="<?php echo $lis['COD_PRODUCTO']; ?>" class="option"><?php echo $lis['ABR_PRODUCTO']; ?><?php echo $lis['DES_PRODUCTO']; ?></option>
                                <?php
                                }

                                ?>
                            </select>
                        </div>
                        <!-- Text input cantidad -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Cantidad producto</label>
                            <input type="text" id="cantidadTotal" class="form-control" name="cantidadTotal" required>
                        </div>
                        <button id="botonCalcularProductosEnvases" type="submit" name="insert" class="btn btn-primary bt-Total">Total de productos</button>
                        <div class="table-responsive " style="overflow: scroll;height: 180px !important; margin-top:20px;margin-bottom:100px;">
                            <table id="tbProEnVa" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">CODIGO PRODUCTO</th>
                                        <th class="thtitulo" scope="col">CANTIDAD PRODUCTO</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaProductoEnvases">

                                </tbody>
                            </table>
                        </div>
                        <!--Combo Insumos -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Insumos</label>
                            <select id="selectInsumosCombo" class="form-select selectInsumos" aria-label="Default select example">
                                <option value="none" selected disabled>Seleccione insumos</option>
                                <?php foreach ($dataProducto as  $lis) { ?>
                                    <option value="<?php echo $lis['COD_PRODUCTO']; ?>" class="option"><?php echo $lis['ABR_PRODUCTO']; ?><?php echo $lis['DES_PRODUCTO']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Text input cantidad insumos-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Cantidad insumos</label>
                            <input type="text" id="cantidadInsumos" class="form-control" name="cantidadInsumos" required>
                        </div>
                        <button id="botonCalcularInsumos" type="submit" name="insert" class="btn btn-primary bt-Total">Insertar insumos </button>
                        <div class="table-responsive " style="overflow: scroll;height: 300px; margin-top:20px;">
                            <table id="tbInsum" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>

                                        <th class="thtitulo" scope="col">CODIGO INSUMOS</th>
                                        <th class="thtitulo" scope="col">CANTIDAD INSUMOS</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaInsumos">

                                </tbody>
                            </table>
                        </div>

                        <!--Combo Envases por producto -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Envases</label>
                            <select id="selectEnvasesProductoCombo" class="form-select selectEnvasesProducto" aria-label="Default select example">
                                <option value="none" selected disabled>Seleccione envases</option>
                                <?php foreach ($dataProducto as  $lis) { ?>
                                    <option value="<?php echo $lis['COD_PRODUCTO']; ?>" class="option"><?php echo $lis['ABR_PRODUCTO']; ?><?php echo $lis['DES_PRODUCTO']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Text input cantidad insumos-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Cantidad envases</label>
                            <input type="text" id="cantidadEnvaseProducto" class="form-control" name="cantidadEnvaseProductos" required>
                        </div>
                        <button id="botonCalcularEnvasesProducto" type="submit" name="insert" class="btn btn-primary bt-Total">Insertar envases </button>
                        <div class="table-responsive " style="overflow: scroll;height: 300px; margin-top:20px;">
                            <table id="tbEnvaseProducto" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>

                                        <th class="thtitulo" scope="col">CODIGO ENVASES</th>
                                        <th class="thtitulo" scope="col">CANTIDAD ENVASES</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaEnvasesCadaProducto">

                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="contenedor">
                            <div class="ctnBtn">
                                <input type="hidden" id="taskId">

                                <button id="boton" type="submit" name="insert" class="btn btn-primary bt-guardar">Guardar </button>
                            </div>
                        </div> -->
                    </form>

                    <!-- <div id="tablaEF" class="table-responsive " style="overflow: scroll;height: 300px; margin-top:20px;">
                        <table id="tbEF" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>

                                    <th class="thtitulo" scope="col">CODIGO PRODUCTO</th>
                                    <th class="thtitulo" scope="col">CANTIDAD TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="tablaEnvaseFormulacion">

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
    <script src="./js/ajaxEnvaseFormulacion.js"></script>
    <script src="./js/select2.min.js"></script>
    <script>
        function generarPDF() {
            var anioSeleccionado = document.getElementById("anio").value;
            var mesSeleccionado = document.getElementById("mes").value;

            // Enviar los valores a tu script de generación de PDF
            var url = "pdf-monitoreo.php?anio=" + anioSeleccionado + "&mes=" + mesSeleccionado;
            window.open(url, "_blank");
        }
    </script>
</body>

</html>