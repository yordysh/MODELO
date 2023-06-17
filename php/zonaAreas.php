<?php
require_once "m_almacen.php";
// require_once "./funciones/f_funcion.php";



$mostrar = new m_almacen();
$data = $mostrar->MostrarAlmacenMuestra();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="../assets/images/icon/covifarma-ico.ico" type="images/png">

    <!--====== Estilo de ICON ======-->
    <link rel="stylesheet" href="../assets/styleIcons/style.css">

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="../assets/js/jquery-3.7.0.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->



    <title>Covifarma</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bar-color">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-light" href="../"><img src="../assets/images/logo-covifarma.png" alt=""></a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Zona/Areas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="infraestructuraAccesorios.php">Infraestructura Accesorios</a>
                    </li>
                </ul>
            </div>
            <form class="d-flex">
                <input type="search" id="search" placeholder="Buscar" class="form-control me-2">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <main>
        <section>
            <div class="container g-4 mt-100 row">
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
                    <div class="card my-4" id="task-result">
                        <div class="card-body">
                            <ul id="container"></ul>
                        </div>
                    </div>

                    <div id="tablaAlmacen" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">

                    </div>


                </div>
            </div>
            </div>
        </section>
    </main>
    <footer class="bg-dark p-2 mt-5 text-light position-fixed bottom-0 w-100 text-center">
        Covifarma-2023
    </footer>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- <script src="../assets/js/jquery-3.7.0.min.js"></script> -->
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <!-- <script src="../assets/js/jquery-tabledit/jquery.tabledit.js"></script> -->
    <script src="./js/ajaxZona.js"></script>
    <!-- <script src="js/ajaxAlerta.js"></script> -->
</body>

</html>