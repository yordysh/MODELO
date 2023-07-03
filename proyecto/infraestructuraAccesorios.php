<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataInfra = $mostrar->MostrarAlmacenMuestra();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="../images/icon/covifarma-ico.ico" type="images/png">

    <!--====== Estilo de ICON ======-->
    <link rel="stylesheet" href="../proyecto/styleIcons/style.css">

    <title>Covifarma</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bar-color">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-light" href="./"><img src="../images/logo-covifarma.png" alt=""></a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../proyecto/zonaAreas.php">Zona/Areas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Infraestructura Accesorios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./preparacionSolucion.php">Preparación de soluciones</a>
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
                        <div class="container">
                            <div class="row">
                                <div class="col-2">
                                    <input type="hidden" id="taskId">
                                    <button id="boton" type="submit" name="insert" class="btn btn-primary ">Guardar </button>
                                </div>
                                <div class=" col-10 pdf" style="margin-left: 35%; margin-top:-4%;">
                                    <div class="row">
                                        <div class="col-4 anioCol">
                                            <label for="mes">Seleccione el año:</label>
                                            <input type="number" id="anio" name="anio" min="1900" max="2100" value="2023">

                                        </div>
                                        <div class="col-4 mesCol">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="mes">Seleccione el mes:</label>
                                                </div>
                                                <div class="col-6">
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
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-primary" href="#" onclick="generarPDF()">Generar PDF</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.7.0.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="./js/ajaxInfra.js"></script>
    <!-- <script src="js/ajaxAlerta.js"></script> -->
    <script>
        function generarPDF() {
            var anioSeleccionado = document.getElementById("anio").value;
            var mesSeleccionado = document.getElementById("mes").value;

            // Enviar los valores a tu script de generación de PDF
            var url = "./pdf-monitoreo.php?anio=" + anioSeleccionado + "&mes=" + mesSeleccionado;
            window.open(url, "_blank");
        }
    </script>



</body>

</html>