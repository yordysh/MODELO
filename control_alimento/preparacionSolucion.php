<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataInsumos = $mostrar->MostrarSoluciones();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/responsivePreparacion.css">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="./images/icon/covifarma-ico.ico" type="images/png">

    <!--====== Estilo de ICON ======-->
    <link rel="stylesheet" href="./styleIcons/style.css">

    <title>Labsabel</title>
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
                    <center><label class="title">LBS-PHS-FR-02:PREPARACIÓN DE SOLUCIONES DE LIMPIEZA Y DESINFECCIÓN</label></center>
                </div>
                <div class="main">

                    <div id="tabla" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px; margin-bottom:50px;">
                        <table id="tbInsumos" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <th class="thtitulo" scope="col">CANTIDAD</th>
                                </tr>
                            </thead>
                            <tbody id="tbPreparacion">

                            </tbody>
                        </table>
                    </div>

                    <form method="post" action="" id="formularioSoluciones">
                        <div class="estiloordencompra">
                            <!-- Text input Insumos -->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Producto de saneamiento</label>
                                <select id="selectInsumos" class="form-select" aria-label="Default select example">
                                    <option value="0" selected disabled>Seleccione producto</option>
                                    <?php foreach ($dataInsumos as $lista) { ?>
                                        <option value="<?php echo $lista['ID_SOLUCIONES']; ?>" class="option"><?php echo $lista['NOMBRE_INSUMOS']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- Text input Preparacion-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Preparación</label>
                                <select id="selectPreparaciones" class="form-select" aria-label="Default select example">
                                    <option value="0" selected disabled>Seleccione preparación</option>
                                </select>
                            </div>
                            <!-- Text input cantidad-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Cantidad ("%" o "ppm")</label>
                                <select id="selectCantidad" class="form-select" aria-label="Default select example">
                                    <option value="0" selected disabled>Seleccione cantidad</option>
                                </select>
                            </div>
                        </div>

                        <div class="estiloordencompra">
                            <!-- Text input numero ML-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Número de preparacion en ml(Hipoclorito)</label>
                                <select id="selectML" class="form-select" aria-label="Default select example">
                                    <option value="0" selected disabled>Seleccione cantidad ML</option>
                                </select>
                            </div>
                            <!-- Text input numero L-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Número de preparación en L(H<sub>2</sub>O)</label>
                                <select id="selectL" class="form-select" aria-label="Default select example">
                                    <option value="0" selected disabled>Seleccione cantidad L</option>
                                </select>
                            </div>
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Otros litros</label>
                                <input class="form-control" type="number" id="valorextra" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57">
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

                        <div class="contenedorgeneral">
                            <div class="btonguardar">
                                <input type="hidden" id="taskId">
                                <button id="boton" name="insert" class="btn btn-primary estiloboton">Guardar </button>
                            </div>
                            <div class="aniomes">
                                <div class="styleanmes"><label for="mes">Seleccione el año:</label>
                                    <input type="number" id="anio" name="anio" min="1900" max="2100" value="<?php echo date('Y') ?>">
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
        Labsabel-<?php echo date('Y') ?>
    </footer>
    <?php require_once("modallitros.php"); ?>

    <script src="./js/jquery-3.7.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/sweetalert2.all.min.js"></script>
    <script src="./js/ajaxPreparacion.js?v=0.001"></script>
    <script src="./js/time.js?v=0.001"></script>
    <script src="../js/menu_a.js"></script>
    <script src="./js/select2.min.js"></script>
    <script>
        function generarPDF() {
            var anioSeleccionado = document.getElementById("anio").value;
            var mesSeleccionado = document.getElementById("mes").value;

            // Enviar los valores a tu script de generación de PDF
            var url = "pdf-preparacionSolucion.php?anio=" + anioSeleccionado + "&mes=" + mesSeleccionado;
            window.open(url, "_blank");
        }
    </script>



</body>

</html>