<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();

$dataProductoTerminado = $mostrar->MostrarProductoFormulacion();
$dataProductoInsumos = $mostrar->MostrarProductoInsumos();
$dataProductoEnvases = $mostrar->MostrarProductoEnvases();
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
    <?php
    require_once('../menulista/index.php');
    ?>
    <main>
        <section>
            <div class="container g-4 row">
                <div class="row g-4 top-div">
                    <center><label class="title">FORMULACION PATRON</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formularioEnvasesFormula">
                        <input type="hidden" id="codanexo" name="codanexo " value="<?php echo $codanexo; ?>">
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="taskIdProducto" type="hidden" class="form-control" name="taskIdProducto" />
                        </div>

                        <!--Combo Productos -->
                        <div class="row">
                            <div class="form-outline mb-4 col-md-6">
                                <label class="form-label">Producto</label>
                                <select id="selectProductoCombo" class="form-select selectProducto" aria-label="Default select example" required>
                                    <option value="none" selected disabled>Seleccione producto</option>
                                    <?php foreach ($dataProductoTerminado as  $lis) { ?>
                                        <option value="<?php echo ($lis['COD_PRODUCTO']); ?>" class="option"><?php echo ($lis['ABR_PRODUCTO'] . " "); ?><?php echo $lis['DES_PRODUCTO']; ?></option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <!-- Text input cantidad -->
                            <div class="form-outline mb-4 col-md-6">
                                <label class="form-label">Cantidad por kilosgramos</label>
                                <input type="number" id="cantidadTotal" class="form-control" name="cantidadTotal" required>
                            </div>
                        </div>
                        <div class="row">
                            <!--Combo Insumos -->
                            <div class="form-outline mb-4 col-md-6">
                                <label class="form-label">Insumos</label>
                                <select id="selectInsumosCombo" class="form-select selectInsumos" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione insumos</option>
                                    <?php foreach ($dataProductoInsumos as  $lis) { ?>
                                        <option value="<?php echo $lis['COD_PRODUCTO']; ?>" class="option"><?php echo ($lis['ABR_PRODUCTO'] . " "); ?><?php echo $lis['DES_PRODUCTO']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Text input cantidad insumos-->
                            <div class="contenedorcantidadcalculo col-md-6">
                                <div class="form-outline mb-4">

                                    <label class="form-label">Cantidad por kilogramos</label>
                                    <input type="number" id="cantidadInsumos" class="form-control" name="cantidadInsumos" required>
                                </div>
                                <!-- <button id="botonCalcularInsumos" name="insert" class="btn btn-success bt-Total">Insertar insumos </button> -->
                                <div class="btncalcularformula">
                                    <button class="custom-icon-calcular" name="insert" id="botonCalcularInsumos"><i class="icon-circle-with-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive " style="height: 300px; margin-top:20px;margin-bottom:50px!important;">
                            <table id="tbInsum" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="" scope="col">INSUMOS</th>
                                        <th class="" scope="col">CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaInsumos">

                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <!--Combo Envases por producto -->
                            <div class="form-outline mb-4 col-md-6">
                                <label class="form-label">Envases</label>
                                <select id="selectEnvasesProductoCombo" class="form-select selectEnvasesProducto" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione envases</option>
                                    <?php foreach ($dataProductoEnvases as  $lis) { ?>
                                        <option value="<?php echo ($lis['COD_PRODUCTO']); ?>" class="option"><?php echo ($lis['ABR_PRODUCTO'] . " "); ?><?php echo $lis['DES_PRODUCTO']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Text input cantidad envases-->
                            <div class="contenedorcantidadcalculo col-md-6">
                                <div class="form-outline mb-4">
                                    <label class="form-label">Cantidad envases</label>
                                    <input type="number" id="cantidadEnvaseProducto" class="form-control" name="cantidadEnvaseProductos" required>
                                </div>
                                <!-- <button id="botonCalcularEnvasesProducto" name="insert" class="btn btn-success bt-Total">Insertar envases </button> -->
                                <div class="btncalcular">
                                    <button class="custom-icon-calcular" name="insert" id="botonCalcularEnvasesProducto"><i class="icon-circle-with-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" style="height: 300px; margin-top:20px;">
                            <table id="tbEnvaseProducto" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="" scope="col">ENVASES</th>
                                        <th class="" scope="col">CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaEnvasesCadaProducto">

                                </tbody>
                            </table>
                        </div>
                        <button id="botonCalcularProductosEnvases" type="submit" name="insert" class="btn btn-primary bt-Total">Total de productos</button>
                        <a class="btn btn-success estilopdf" href="#" onclick="generarPDF()"> Lista maestra</a>
                        <div class="table-responsive " style="height: 200px !important; margin-top:20px;margin-bottom:100px;">
                            <table id="tbProEnVa" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="" scope="col">PRODUCTO</th>
                                        <th class="" scope="col">CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaProductoEnvases">

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
    <script src="./js/ajaxEnvaseFormulacion.js"></script>
    <script src="../js/menu_a.js"></script>
    <script src="./js/select2.min.js"></script>
    <script>
        function generarPDF() {


            // Enviar los valores a tu script de generación de PDF
            var url = "pdf-valores.php";
            window.open(url, "_blank");
        }
    </script>
</body>

</html>