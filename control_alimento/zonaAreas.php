<?php
require_once "m_almacen.php";


$mostrar = new m_almacen();
$data = $mostrar->MostrarAlmacenMuestra();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/responsiveZonaAreas.css">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="./images/icon/covifarma-ico.ico" type="images/png">

    <!--====== Estilo de ICON ======-->
    <link rel="stylesheet" href="./styleIcons/style.css">

    <script src="./js/jquery-3.7.0.min.js"></script>


    <title>Covifarma</title>

</head>

<body>
    <nav class="nav">
        <i class="icon-menu navOpenBtn"></i>
        <a class="logo" href="./"><img src="./images/logo-covifarma.png" alt=""></a>
        <ul class="nav-links">
            <div class="icon-cross navCloseBtn"></div>
            <li>
                <a class="" aria-current="page" href="#">Zona</a>
            </li>
            <li>
                <a class="" href="infraestructuraAccesorios.php">Infraestructura</a>
            </li>
            <li>
                <a class="" href="preparacionSolucion.php">Preparación de soluciones</a>
            </li>
            <li>
                <a class="" href="limpiezaDesinfeccion.php">Limpieza y desinfección</a>
            </li>
            <li>
                <a class="" href="controlMaquinas.php">Control de maquinas</a>
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
                    <center><label class="title">ZONAS/ÁREAS</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formularioZona">

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Nombre de área</label>
                            <input type="text" id="NOMBRE_T_ZONA_AREAS" class="form-control" name="NOMBRE_T_ZONA_AREAS" required>
                        </div>

                        <!-- Submit button -->
                        <div class="d-grid  col-6 mx-auto bt-guardar">
                            <input type="hidden" id="taskId">
                            <button id="boton" type="submit" name="insert" class="btn btn-primary bt-guardar">Guardar </button>
                        </div>
                    </form>
                    <div id="tablaAlmacen" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">
                        <table id="tbalmacen" class="table table-sm mb-3 table-hover table_id">
                            <thead>
                                <tr>

                                    <th class="thtitulo" scope="col">CODIGO</th>
                                    <th class="thtitulo" scope="col">NOMBRE</th>
                                    <th class="thtitulo" scope="col">FECHA</th>
                                    <th class="thtitulo" scope="col">VERSION</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tablita">

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
    <script src="./js/sweetalert2.all.min.js"></script>
    <script src="./js/ajaxZona.js"></script>
</body>

</html>