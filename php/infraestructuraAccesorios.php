<?php
require_once "DataBaseA.php";
require_once "registrar.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();

$mostrar = new m_almacen();
$dataInfra = $mostrar->MostrarAlmacenMuestra();

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


    <title>Covifarma</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bar-color">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-light" href="../"><img src="../assets/images/logo-covifarma.png" alt=""></a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../php/zonaAreas.php">Zona/Areas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Infraestructura Accesorios</a>
                    </li>
                </ul>
            </div>
            <form class="d-flex">
                <input type="search" id="search" placeholder="Buscar" class="form-control me-2">
                <button type="submit" class="btn btn-primary" onclick="calcularDiasRestantes()">Buscar</button>
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
                    <center><label class="title">INFRAESTRUCTURA, ACCESORIOS COMPLEMENTARIOS</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formularioInfra">

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
                        </div>

                        <!-- Text input nombre -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Nombre de infraestructura</label>
                            <input type="text" id="NOMBRE_INFRAESTRUCTURA" class="form-control" name="NOMBRE_INFRAESTRUCTURA" required>
                        </div>
                        <!-- Text input dias-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Dias</label>
                            <input type="text" id="NDIAS" class="form-control" name="NDIAS" required>
                        </div>

                        <!--Combo zona areas -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Zona/Areas</label>
                            <select id="selectInfra" class="form-select" aria-label="Default select example">
                                <option value="none" selected disabled>Seleccione Zona/Areas</option>
                                <?php foreach ($dataInfra as $lis) { ?>
                                    <option value="<?php echo $lis->COD_ZONA; ?>" class="option"><?php echo $lis->COD_ZONA; ?> <?php echo $lis->NOMBRE_T_ZONA_AREAS; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                        <!-- Submit button -->
                        <div class="bt-guardar">
                            <input type="hidden" id="taskId">
                            <button id="boton" type="submit" name="insert" class="btn btn-primary bt-guardar">Guardar </button>
                            <a class="btn btn-primary" href="../reportes-pdf/pdf-index.php" target="_blank"><i class="fa fa-download"></i> Descargar PDF</a>
                        </div>
                    </form>
                    <div class="card my-4" id="task-result">
                        <div class="card-body">
                            <ul id="container"></ul>
                        </div>
                    </div>

                    <div id="tablaInfra" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">

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
    <script src="../assets/js/jquery-3.7.0.min.js"></script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <!-- <script src="../assets/js/jquery-tabledit/jquery.tabledit.js"></script> -->
    <script src="./js/ajaxInfra.js"></script>
    <!-- <script src="js/ajaxAlerta.js"></script> -->
</body>

</html>