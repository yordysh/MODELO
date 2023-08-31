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
            <!-- <li>
                <a class="" aria-current="page" href="zonaAreas.php">Zona</a>
            </li> -->
            <!-- <li>
                <a class="" href="#">Infraestructura</a>
            </li> -->
            <li>
                <a class="" href="#">LBS-PHS-FR-01</a>
            </li>
            <li>
                <a class="" href="preparacionSolucion.php">LBS-PHS-FR-02</a>
            </li>
            <li>
                <a class="" href="controlMaquinas.php">LBS-PHS-FR-03</a>
            </li>
            <li>
                <a class="" href="limpiezaDesinfeccion.php">LBS-PHS-FR-04</a>
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
                    <center><label class="title">LBS-PHS-FR-01:<span class="titulo-span">MONITOREO DE L & D DE ESTRUCTURAS FISICAS Y ACCESORIOS</span></label></center>
                </div>
                <div class="main">

                    <div id="tablaInfra" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">
                        <table id="tbInfra" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <!-- <th class="thtitulo" scope="col">CODIGO </th> -->
                                    <th class="thtitulo" scope="col">ZONA</th>
                                    <th class="thtitulo" scope="col">INFRAESTRUCTURA</th>
                                    <th class="thtitulo" scope="col">FRECUENCIA</th>
                                    <th class="thtitulo" scope="col">FECHA</th>
                                    <!-- <th class="thtitulo" scope="col">USUARIO</th> -->
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tablaInfraestructura">

                            </tbody>
                        </table>
                    </div>
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
                        <div class="form-outline mb-4 ">
                            <label class="form-label">Frecuencia</label>
                            <!-- <input type="text" id="NDIAS" class="form-control" name="NDIAS" required> -->
                            <select id="selectFrecuencia" class="form-select" aria-label="Default select example">
                                <option value="0" selected disabled>Seleccione frecuencia</option>
                                <option value="1">Diario</option>
                                <option value="2">Inter-diario</option>
                                <option value="7">Semanal</option>
                                <option value="15">Quincenal</option>
                                <option value="30">Mensual</option>
                            </select>
                        </div>

                        <!--Combo zona areas -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Zona/Areas</label>
                            <select id="selectInfra" class="form-select selectZona" aria-label="Default select example">
                                <option value="none" selected disabled>Seleccione Zona/Areas</option>
                                <?php foreach ($dataInfra as $lis) {
                                    if ($lis->NOMBRE_T_ZONA_AREAS != "TRANSITO DE PERSONAL" && $lis->NOMBRE_T_ZONA_AREAS != "SS.HH(MUJERES Y VARONES)" && $lis->NOMBRE_T_ZONA_AREAS != "VESTUARIOS(MUJERES Y VARONES)") {
                                ?>
                                        <option value="<?php echo $lis->COD_ZONA; ?>" class="option"><?php echo $lis->COD_ZONA; ?> <?php echo $lis->NOMBRE_T_ZONA_AREAS; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <!-- <input type="hidden" id="task_zona">
                            <input id="selectInfra" class="form-control" required> -->
                        </div>

                        <!-- Crear PDF -->
                        <div class="contenedorgeneral">
                            <div class="btonguardar">
                                <input type="hidden" id="taskId">
                                <button id="boton" type="submit" name="insert" class="btn btn-primary estiloboton">Guardar </button>
                            </div>
                            <div class="aniomes">
                                <div class="styleanmes"><label for="mes">Seleccione el año:</label>
                                    <input type="number" id="anio" name="anio" min="1900" max="2100" value="2023">
                                </div>
                                <div class="styleanmes"> <label for="mes">Seleccione el mes:</label>
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
                    </form>

                    <div class="container g-4 row">
                        <div class="row g-4 top-div" style="margin-top: 55px;">
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
                                <div class="d-grid  col-6 mx-auto bt-guardar-zona">
                                    <input type="hidden" id="taskId">
                                    <button id="boton" type="submit" name="insert" class="btn btn-primary bt-guardarzona">Guardar </button>
                                </div>
                            </form>


                        </div>
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
    <!-- <script src="./js/ui_1.12.1_jquery-ui.min.js"></script> -->
    <script src="./js/ajaxInfra.js"></script>
    <!-- <script src="./js/ajaxZona.js"></script> -->
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