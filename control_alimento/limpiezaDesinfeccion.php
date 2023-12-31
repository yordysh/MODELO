<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataZona = $mostrar->MostrarAlmacenMuestra();

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
                <div class="clock" id='reloj' onload="time()"></div>
                <div class="row g-4 top-div">
                    <center><label class="title">LBS-PHS-FR-04:LIMPIEZA Y DESINFECCIÓN DE UTENSILIOS Y LIMPIEZA</label></center>
                </div>
                <div class="main">

                    <div id="tablalimpieza" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">
                        <table id="tbLimpieza" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <!-- <th class="thtitulo" scope="col">COD. FRECUENCIA</th> -->
                                    <th class="thtitulo" scope="col">ZONA/ÁREA</th>
                                    <th class="thtitulo" scope="col">MATERIALES</th>
                                    <th class="thtitulo" scope="col">FECHA</th>
                                    <!-- <th class="thtitulo" scope="col">VERSION</th> -->
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tdLimpiezadesinfeccion">

                            </tbody>
                        </table>
                    </div>

                    <form method="post" action="" id="formularioLimpieza">

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
                        </div>
                        <div class="estiloordencompra">
                            <!--Combo zona areas -->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Zona/Areas</label>
                                <select id="selectZona" class="form-select" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione Zona/Areas</option>
                                    <?php foreach ($dataZona as $lis) {
                                        if ($lis->NOMBRE_T_ZONA_AREAS != "PASADIZO" && $lis->NOMBRE_T_ZONA_AREAS != "SS.HH(MUJERES)" && $lis->NOMBRE_T_ZONA_AREAS != "SS.HH(VARONES)" && $lis->NOMBRE_T_ZONA_AREAS != "VESTUARIOS(MUJERES)" && $lis->NOMBRE_T_ZONA_AREAS != "VESTUARIOS(VARONES)") {
                                    ?>
                                            <option value="<?php echo $lis->COD_ZONA; ?>" class="option"><?php echo $lis->COD_ZONA; ?> <?php echo $lis->NOMBRE_T_ZONA_AREAS; ?></option>
                                    <?php
                                        }
                                    } ?>
                                </select>

                            </div>

                            <!-- Text input dias-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Materiales</label>
                                <input type="text" id="nombreFrecuencia" class="form-control" name="nombreFrecuencia" required>
                            </div>
                        </div>
                        <!-- Text input Observacion-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" id="textAreaObservacion" rows="3"></textarea>
                        </div>
                        <!-- Text input Acciones-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Acciones correctivas</label>
                            <textarea class="form-control" id="textAreaAccion" rows="3"></textarea>
                        </div>
                        <!-- Text input verificacion-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Verificación</label>
                            <select id="selectVerificacion" class="form-select" aria-label="Default select example">
                                <option value="0" selected disabled>Seleccione verificación</option>
                                <option value="1">Conforme</option>
                                <option value="2">No conforme</option>

                            </select>
                        </div>

                        <!-- Submit button -->
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

                                <a class="btn btn-primary estilopdf" href="#" onclick="generarPDF()">PDF</a>
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
    <script src="./js/ajaxLimpieza.js?v=0.001"></script>
    <script src="./js/time.js?v=0.001"></script>
    <script src="../js/menu_a.js"></script>
    <script src="./js/select2.min.js"></script>
    <script>
        function generarPDF() {
            var anioSeleccionado = document.getElementById("anio").value;
            var mesSeleccionado = document.getElementById("mes").value;

            // Enviar los valores a tu script de generación de PDF
            var url = "pdf-limpieza.php?anio=" + anioSeleccionado + "&mes=" + mesSeleccionado;
            window.open(url, "_blank");
        }
    </script>
</body>

</html>