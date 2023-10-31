<?php
session_start();

// $codusuario = $_SESSION["cod"];
// $codoficina = $_SESSION["ofi"];

// $codanexo=$_SESSION["ane"];
$codusuario = '0002';
// $codoficina = 'SMP2';

?>
<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataRequerimiento = $mostrar->MostrarRequerimientoEstadoT();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/responsiveOrdenCompra.css">
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
    <style>
        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            text-align: center;
            width: 30px;
            height: 100px;
        }

        td {
            width: 150px !important;

        }
    </style>
    <main>
        <section>
            <div class="container g-4 row">
                <div class="main">
                    <form method="post" action="" id="formulariocompraorden">
                        <input type="hidden" id="codpersonal" name="codpersonal" value="<?php echo $codusuario; ?>">
                        <!-- <input type="hidden" id="vroficina" name="vroficina" value="<?php echo $codoficina; ?>"> -->

                        <div class="row g-4 top-div">
                            <center><label class="title_table">CONTROL DE RECEPCIÓN</label></center>
                        </div>


                        <!-- Text input empresa-->
                        <div class="form-outline mb-4 custom-input">
                            <label class="form-label">Requerimiento</label>
                            <select id="selectrequerimiento" class="form-select" aria-label="Default select example">
                                <option value="none" selected disabled>Seleccione requerimiento</option>
                                <?php

                                foreach ($dataRequerimiento as $lista) {
                                    echo '<option value="' . $lista->COD_REQUERIMIENTO . '" class="option">' . $lista->COD_REQUERIMIENTO . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div id="tablaInfra" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">
                            <table id="tbInfra" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">PRODUCTOS</th>
                                        <th class="thtitulo" scope="col">CANTIDAD TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaproductoscantidades">

                                </tbody>
                            </table>
                        </div>

                        <div class="row g-4 top-div">
                            <center><label class="title">CONTROL DE RECEPCION DE MATERIA PRIMA</label></center>
                        </div>
                        <div id="tablarecepcion" class="table-responsive" style="overflow: scroll;height: 600px; margin-top:20px;">
                            <table id="tbrecepcion" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="encabezado-especial" rowspan="2">FECHA DE INGRESO</th>
                                        <th rowspan="2">HORA</th>
                                        <th rowspan="2">PRODUCTO</th>
                                        <th rowspan="2">CÓDIGO DE LOTE</th>
                                        <th rowspan="2">F.V</th>
                                        <th rowspan="2">PROVEEDOR</th>
                                        <th colspan="3" style="width: 30px;">GUÍA/BOLETA/FACTURA</th>
                                        <th rowspan="2">N° GUÍA,BOLETA O FACTURA</th>
                                        <th colspan="2">Empaque</th>
                                        <th colspan="4">Presentación</th>
                                        <th rowspan="2">CANTIDAD (kg)</th>
                                        <th colspan="3">CONTROL DEL PRODUCTO</th>
                                        <th colspan="3">DEL PERSONAL DE TRANSPORTE</th>
                                        <th colspan="4">CONDICIONES DEL TRANSPORTE</th>
                                        <th rowspan="2">V°B°</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="vertical-text">G.Remisión</th>
                                        <th class="vertical-text">Boleta</th>
                                        <th class="vertical-text">Factura</th>
                                        <th class="vertical-text">Primario</th>
                                        <th class="vertical-text">Secundario</th>
                                        <th class="vertical-text">Saco</th>
                                        <th class="vertical-text">Caja</th>
                                        <th class="vertical-text">Cilindro</th>
                                        <th class="vertical-text">bolsa</th>
                                        <th class="vertical-text">Envase integro/ hermético</th>
                                        <th class="vertical-text">Certificado de calidad</th>
                                        <th class="vertical-text">Rotulación conforme</th>
                                        <th class="vertical-text">Aplicación de las BPD</th>
                                        <th class="vertical-text">Higiene & salud</th>
                                        <th class="vertical-text">Indumentaria completa y limpia</th>
                                        <th class="vertical-text">Limpio</th>
                                        <th class="vertical-text">Exclusivo</th>
                                        <th class="vertical-text">Hermético</th>
                                        <th class="vertical-text">Ausencia de plagas</th>
                                    </tr>
                                </thead>
                                <tbody id="tablacontrolrecepcion">

                                </tbody>
                            </table>
                        </div>
                        <button style="margin-bottom: 80px;" id="guardarrecepcion" name="guardarrecepcion" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
        </section>
    </main>
    <footer class="bg-dark p-2 mt-5 text-light position-fixed bottom-0 w-100 text-center">
        Covifarma-2023
    </footer>

    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.7.0.min.js"></script>
    <script src="./js/sweetalert2.all.min.js"></script>
    <script src="../js/menu_a.js"></script>
    <script src="./js/ajaxControlRecepcion.js"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>