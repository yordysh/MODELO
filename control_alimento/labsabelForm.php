<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataProducto = $mostrar->MostrarProductoSelect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="./css/ui_1.12.1_themes_base_jquery-ui.css"> -->
    <link rel="stylesheet" href="./css/responsivePrevileLab.css">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="./images/icon/covifarma-ico.ico" type="images/png">

    <!--====== Estilo de ICON ======-->
    <link rel="stylesheet" href="./styleIcons/style.css">

    <script src="./js/jquery-3.7.0.min.js"></script>
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
                <a class="" href="#">Envases labsabell</a>
            </li>
            <!-- <li>
                <a class="" href="previlifeForm.php">Envases previlife</a>
            </li> -->
            <li>
                <a class="" href="insumosLabsabellForm.php">Insumos labsabell</a>
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
                    <center><label class="title">LISTA MAESTRA DE ENVASES Y EMBALAJES LABSABELL</label></center>
                </div>
                <div class="main">
                    <div id="tablaLabsabell" class="table-responsive " style="overflow: scroll;height: 300px; margin-top:20px;">
                        <table id="tblabsabell" class="table table-sm mb-3 table-hover table_id">
                            <thead>
                                <tr>

                                    <!-- <th class="thtitulo" scope="col">CODIGO</th> -->
                                    <th class="thtitulo" scope="col">NOMBRE</th>
                                    <th class="thtitulo" scope="col">CODIGO</th>
                                    <!-- <th class="thtitulo" scope="col">FECHA</th> -->
                                    <!-- <th class="thtitulo" scope="col">VERSION</th> -->
                                    <!-- <th></th>
                                    <th></th> -->
                                </tr>
                            </thead>
                            <tbody id="tablaLabsabells">

                            </tbody>
                        </table>
                    </div>

                    <form method="post" action="" id="formularioLabsabell">

                        <!-- Text input codigo -->
                        <!-- <div class="form-outline mb-4">
                            <label class="form-label">Nombre</label>
                            <select id="selectProducto" class="form-select selectProducto" aria-label="Default select example">
                                <option value="none" selected disabled>Seleccione producto</option>
                                <?php foreach ($dataProducto as $lis) { ?>
                                    <option value="<?php echo $lis['COD_PRODUCTO']; ?>" class="option"> <?php echo $lis['DES_PRODUCTO']; ?></option>
                                <?php
                                }

                                ?>
                            </select>
                        </div> -->
                        <!-- Text input nombre -->
                        <!-- <div class="form-outline mb-4">
                            <label class="form-label">Codigo</label>
                            <input type="text" id="codigo_labsabell" class="form-control" name="codigo_labsabell" required>
                        </div> -->




                        <!-- <div class="contenedor">
                            <div class="d-grid  col-6 mx-auto bt-guardar">
                                <input type="hidden" id="taskId">
                                <button id="boton" type="submit" name="insert" class="btn btn-primary bt-guardar">Guardar </button>
                            </div>
                            <div class="ordenar">
                                <a class="btn btn-primary btnPdf" href="#" onclick="generarPDF()">Generar PDF</a>
                            </div>
                        </div> -->
                    </form>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-dark p-2 mt-5 text-light position-fixed bottom-0 w-100 text-center">
        Covifarma-2023
    </footer>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/sweetalert2.all.min.js"></script>
    <!-- <script src="./js/ui_1.12.1_jquery-ui.min.js"></script> -->
    <script src="./js/select2.min.js"></script>
    <script src="./js/ajaxLabsabell.js"></script>
    <script>
        function generarPDF() {
            // Enviar los valores a tu script de generación de PDF
            var url = "pdf-envases-labsabell.php";
            window.open(url, "_blank");
        }
    </script>
</body>

</html>