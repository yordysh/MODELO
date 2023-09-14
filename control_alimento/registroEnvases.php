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
    <!-- <link rel="stylesheet" href="./css/ui_1.12.1_themes_base_jquery-ui.css"> -->
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
                <a class="" href="requerimientoProducto.php">Requerimiento produccion</a>
            </li>
            <li>
                <a class="" href="pedidoRequerimiento.php">Pedido requerimiento</a>
            </li>
            <li>
                <a class="" href="cantidadMinimaProducto.php">Cantidad minima</a>
            </li>
            <li>
                <a class="" href="produccionRequerimiento.php">Produccion</a>
            </li>
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
                    <center><label class="title">REGISTRO DE ENVASES</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formularioRegistroEnvases">

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
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

                        <!--Combo Produccion -->
                        <!-- <div class="form-outline mb-4 ">
                            <label class="form-label">Produccion</label>
                            <select id="selectProduccion" class="form-select selectProduccion" aria-label="Default select example">
                                <option value="0" selected disabled>Seleccione produccion</option>

                            </select>
                        </div> -->

                        <!-- Text input cantidad -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Cantidad</label>
                            <input type="text" id="cantidad" class="form-control" name="cantidad" required>
                        </div>
                        <!-- Crear PDF -->
                        <div class="contenedorgeneral">
                            <!-- <div class="ctnBtn"> -->
                            <!-- <input type="hidden" id="taskId"> -->
                            <div class="estilocalcular">
                                <!-- <button id="botonCalcular" type="submit" name="calcular" class="btn btn-primary estilobotoncalcular">Calcular </button> -->
                                <button id="botonCalcularregistros" type="submit" name="calcular" class="btn btn-primary estilobotoncalcular">Calcular </button>
                            </div>
                            <div class="estiloguardar">
                                <button id="botonguardarregistro" type="submit" name="insert" class="btn btn-primary estilobotonguardar">Guardar </button>
                            </div>

                            <div class="aniomes">
                                <div class="styleanmes">
                                    <label for="mes">Seleccione el año:</label>
                                    <input type="number" id="anio" name="anio" min="1900" max="2100" value="2023">
                                </div>
                                <div class="styleanmes">
                                    <label for="mes">Seleccione el mes:</label>
                                    <select id="mes" name="mes">
                                        <option value="" selected disabled>Seleccione...</option>
                                        <option value="01">Enero</option>
                                        <option value="02">Febrero</option>
                                        <option value="03">Marzo</option>
                                        <option value="04">Abril</option>
                                        <option value="05">Mayo</option>
                                        <option value="06">Junio</option>
                                        <option value="07">Julio</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                                <a class="btn btn-primary estilopdf" href="#" onclick="generarPDF()">Generar PDF</a>
                            </div>

                        </div>
                </div>
                </form>

                <div id="tablaRE" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">
                    <table id="tbRE" class="table table-sm mb-3 table-hover">
                        <thead>
                            <tr>
                                <th class="thtitulo" scope="col">ENVASES</th>
                                <th class="thtitulo" scope="col">CANTIDAD</th>
                                <th class="thtitulo" scope="col">LOTE</th>
                            </tr>
                        </thead>
                        <tbody id="tablacalculoregistroenvase">

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
    <script src="./js/ajaxRegistrosEnvasess.js"></script>
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