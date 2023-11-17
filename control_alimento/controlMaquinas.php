<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$datacontrol = $mostrar->MostrarControlMaquina();
$datomaquina = $mostrar->controlmaquinapdfmodal();
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
    <link rel="stylesheet" href="./css/select2.min.css">
    <link rel="shortcut icon" href="./images/icon/covifarma-ico.ico" type="images/png">

    <!--====== Estilo de ICON ======-->
    <link rel="stylesheet" href="./styleIcons/style.css">

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
                    <center><label class="title">LBS-PHS-FR-03:CONTROL DE L & D DE MÁQUINAS, EQUIPOS Y UTENSILIOS DE TRABAJO</label></center>
                </div>
                <div class="main">
                    <div id="tControl" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">
                        <table id="tbControl" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <th class="thtitulo" scope="col">CONTROL DE MAQUINAS</th>
                                    <th class="thtitulo" scope="col">FRECUENCIA</th>
                                    <th class="thtitulo" scope="col">FECHA</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tablaControl">

                            </tbody>
                        </table>
                    </div>

                    <form method="post" action="" id="formularioControl">
                        <div class="estiloordencompra">
                            <!-- Text input -->
                            <div class="form-outline mb-4">
                                <input id="id" type="hidden" class="form-control" name="id" />
                            </div>

                            <!--Combo zona areas -->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Nombre máquina, equipo</label>
                                <select id="selectControl" class="form-select" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione máquina</option>
                                    <?php
                                    foreach ($datacontrol as $lis) { ?>
                                        <option value="<?php echo $lis->COD_CONTROL_MAQUINA; ?>" class="option"><?php echo $lis->NOMBRE_CONTROL_MAQUINA; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="buttonañadircontrolmaquina">
                                <button type='button' class="custom-icon-zona" data-bs-toggle="modal" data-bs-target="#mostrarinfraestructuracontrol"><i class="icon-circle-with-plus"></i></button>
                            </div>
                            <!-- Text input dias-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Frecuencia</label>
                                <!-- <input type="text" id="N_DIAS_CONTROL" class="form-control" name="N_DIAS_CONTROL" required> -->
                                <select id="selectFrecuencia" class="form-select" aria-label="Default select example">
                                    <option value="0" selected disabled>Seleccione frecuencia</option>
                                    <option value="7">Semanal</option>
                                    <!-- <option value="15">Quincenal</option> -->
                                    <option value="30">Mensual</option>
                                </select>
                            </div>
                        </div>
                        <!-- Submit button -->
                        <div class="contenedorgeneral">
                            <div class="btonguardar">
                                <input type="hidden" id="taskId">
                                <button id="botoncontrolmaquina" type="submit" name="insert" class="btn btn-primary estiloboton">Guardar </button>
                                <div class="">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mostrarmaquinapdf">Control</button>
                                </div>
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
        <?php
        require_once "modalinfraestructuracontrol.php";
        ?>
        <?php
        require 'modalmostrarmaquina.php';
        ?>
    </main>
    <footer class="bg-dark p-2 mt-5 text-light position-fixed bottom-0 w-100 text-center">
        Covifarma-2023
    </footer>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.7.0.min.js"></script>
    <script src="./js/sweetalert2.all.min.js"></script>
    <script src="./js/ajaxControlMaquinas.js?v=0.001"></script>
    <script src="./js/time.js?v=0.001"></script>
    <script src="../js/menu_a.js"></script>
    <script src="./js/select2.min.js"></script>
    <script>
        function generarPDF() {
            var anioSeleccionado = document.getElementById("anio").value;
            var mesSeleccionado = document.getElementById("mes").value;

            // Enviar los valores a tu script de generación de PDF
            var url = "pdf-controlmaquina.php?anio=" + anioSeleccionado + "&mes=" + mesSeleccionado;
            window.open(url, "_blank");
        }
    </script>
</body>

</html>