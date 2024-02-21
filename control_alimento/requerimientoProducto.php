<?php
session_start();

// $codusuario = $_SESSION["cod"];
$codusuario = '0004';
?>

<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataProductoTerminado = $mostrar->MostrarProductoTerminado();
$mostrarrequerimiento = $mostrar->MostrarTPMRequerimiento();
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
                    <center><label class="title">REQUERIMIENTO DE PRODUCTOS</label></center>
                </div>
                <div class="main">
                    <form class="formSpace" method="post" action="" id="formularioRequerimientoProducto">
                        <input type="hidden" id="codpersonal" name="codpersonal" value="<?php echo $codusuario; ?>">
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
                        </div>
                        <div class="row">
                            <!--Combo Productos -->
                            <div class="form-outline mb-4 col-md-4">
                                <label class="form-label">Producto</label>
                                <select id="selectInsumoEnvase" class="form-select selectProducto" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione producto</option>
                                    <?php foreach ($dataProductoTerminado as  $lis) { ?>
                                        <option value="<?php echo $lis['COD_PRODUCTO']; ?>" class="option" peso_neto="<?php echo $lis['PESO_NETO']; ?>" cantidad_sachet='<?php echo $lis['CANTIDAD']; ?>'><?php echo ($lis['ABR_PRODUCTO'] . " "); ?><?php echo $lis['DES_PRODUCTO']; ?></option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <input type="hidden" id="valorneto">
                            <input type="hidden" id="cantidadsachet">
                            <!-- Text input cantidad -->

                            <div class="col-md-2">
                                <label class="form-label">Cantidad en Kg</label>
                                <input type="number" id="cantidadInsumoEnvase" class="form-control form-control-sm" name="cantidadProducto" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total unidades estimada</label>
                                <input type="text" class="form-control form-control-sm" id="txtcantidadproductos" name="txtcantidadproductos" readonly />
                            </div>
                            <!-- <div class="btncalcular"> -->
                            <div class="col-md-2">
                                <button class="custom-icon-calcular" name="calcular" id="botonCalcularInsumoEnvase"><i class="icon-circle-with-plus"></i></button>
                            </div>
                            <!-- </div> -->
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
                                        <th class="" scope="col">KILOGRAMOS</th>
                                        <th class="" scope="col">TOTAL PRODUCTOS</th>
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
                                    <label class="title_table">TOTAL DE INSUMOS PARA REQUERIMIENTO</label>
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


                        <!-- Tabla de insumos suma total-->
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
                                    <label class="title_table">TOTAL DE ENVASES PARA REQUERIMIENTO</label>
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
                        <div class="row">
                            <div class="col-md-6">
                                <button style="margin-bottom: 80px;" id="botonInsertValor" name="calcularInsEnv" class="btn btn-primary boton-insertar">Guardar</button>
                            </div>
                            <div class="col-md-6">
                                <select name="select_requerimiento" id="idrequerimientotemp" class="margin">
                                    <?php
                                    $primerRequerimiento = reset($mostrarrequerimiento);
                                    foreach ($mostrarrequerimiento as $reque) {
                                        echo '<option value="' . $reque->COD_REQUERIMIENTO . '"';
                                        if ((int)$reque->COD_REQUERIMIENTO === (int)$primerRequerimiento->COD_REQUERIMIENTO) {
                                            echo ' selected';
                                        }
                                        echo '>';
                                        echo $reque->COD_REQUERIMIENTO;
                                        echo '</option>';
                                    }
                                    ?>
                                </select>
                                <button style="margin-top: 20px;" id="requerimientoorden" name="requerimiento" class="btn btn-success" href="#" onclick="generarPDF()">Requerimiento</button>
                            </div>
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
    <script src="./js/ajaxRequerimientoProducto.js?v=0.001"></script>
    <script src="../js/menu_a.js"></script>
    <script src="./js/select2.min.js"></script>
    <script>
        function generarPDF() {
            var requerimiento = document.getElementById("idrequerimientotemp").value;

            var url = "pdf-lista-requerimiento.php?requerimiento=" + requerimiento;
            window.open(url, "_blank");
        }
    </script>
</body>

</html>