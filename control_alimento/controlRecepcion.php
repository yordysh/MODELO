<?php
session_start();

$codusuario = $_SESSION["cod"];
// $codoficina = $_SESSION["ofi"];

// $codanexo=$_SESSION["ane"];
// $codusuario = '0002';
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
    <link rel="stylesheet" href="./css/responsiveRecepcionControl.css">
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


        .theadborder {
            border-bottom: 2px solid #000;
        }

        .thborder {
            border: 1px solid #000;
            /* padding: 10px; */
        }

        th.vertical-text.thborder.padding-grf {
            padding-left: 18px !important;
        }

        input#primario,
        .secundario,
        .saco,
        .caja,
        .cilindro,
        .bolsa {
            margin-left: 12px;
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
                            <center><label class="title_table">LBS-BPM-FR-09</label></center>
                        </div>


                        <!-- Text input empresa-->
                        <div class="form-outline mb-4 custom-input">
                            <label class="form-label">Requerimiento</label>
                            <select name="select_requerimiento" id="idrequerimientoorden">
                                <option value="none" selected disabled>Seleccione requerimiento</option>
                                <?php

                                foreach ($dataRequerimiento as $lista) {
                                    echo '<option value="' . $lista->COD_REQUERIMIENTO . '" class="option">' . $lista->COD_REQUERIMIENTO . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div id="tablaInfra" class="" style="overflow: scroll;height: 200px; margin-top:20px;">
                            <table id="tbInfra" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">PRODUCTOS</th>
                                        <th class="thtitulo" scope="col">CANTIDAD (KG)</th>
                                        <th class="thtitulo" scope="col">UNIDADES</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaproductoscantidades">

                                </tbody>
                            </table>
                        </div>

                        <div class="row g-4 top-div">
                            <center><label class="title">CONTROL DE RECEPCION DE MATERIA PRIMA</label></center>
                        </div>
                        <div id="tablarecepcion" class="" style="overflow: scroll;height: 600px;width: 1300px!important; margin-top:20px;">
                            <table id="tbrecepcion" class="table table-sm mb-3 table-fixed">
                                <thead class="theadborder fixed-header">
                                    <tr>
                                        <th style="padding:40px 0;" class="thborder" rowspan="2">ITEM</th>
                                        <th class="encabezado-especial thborder" rowspan="2" style="padding:40px 0;">FECHA DE INGRESO</th>
                                        <th rowspan="2" style="padding:40px 0; text-align:center;" class="thborder">REQUERIMIENTO</th>
                                        <th rowspan="2" style="padding:40px 0; text-align:center;" class="thborder">HORA</th>
                                        <th rowspan="2" style="padding:40px 0; text-align:center;" class="thborder">CÓDIGO INTERNO</th>
                                        <th rowspan="2" style="padding:40px 0; text-align:center;" class="thborder">PRODUCTO</th>
                                        <th rowspan="2" style="padding:40px 0; text-align:center;" class="thborder">CÓDIGO DE LOTE</th>
                                        <th rowspan="2" style="padding:40px 0; text-align:center;" class="thborder">F.V</th>
                                        <th rowspan="2" style="padding:40px 0; text-align:center;" class="thborder">PROVEEDOR</th>
                                        <th colspan="3" style="width: 30px;" class="thborder">GUÍA/BOLETA/FACTURA</th>
                                        <th rowspan="2" class="thborder">N° GUÍA,BOLETA O FACTURA</th>
                                        <th colspan="2" class="thborder">Empaque</th>
                                        <th colspan="4" class="thborder">Presentación</th>
                                        <th rowspan="2" class="thborder">CANTIDAD (kg)</th>
                                        <th colspan="3" class="thborder">CONTROL DEL PRODUCTO</th>
                                        <th colspan="3" class="thborder">DEL PERSONAL DE TRANSPORTE</th>
                                        <th colspan="4" class="thborder">CONDICIONES DEL TRANSPORTE</th>
                                        <!-- <th rowspan="2" class="thborder">V°B°</th> -->
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="vertical-text thborder padding-grf">G.Remisión</th>
                                        <th class="vertical-text thborder padding-grf">Boleta</th>
                                        <th class="vertical-text thborder padding-grf">Factura</th>
                                        <th class="vertical-text thborder" class="thborder">Primario</th>
                                        <th class="vertical-text thborder" class="thborder">Secundario</th>
                                        <th class="vertical-text thborder">Saco</th>
                                        <th class="vertical-text thborder">Caja</th>
                                        <th class="vertical-text thborder">Cilindro</th>
                                        <th class="vertical-text thborder">bolsa</th>
                                        <th class="vertical-text thborder">Envase integro/ hermético</th>
                                        <th class="vertical-text thborder">Certificado de calidad</th>
                                        <th class="vertical-text thborder">Rotulación conforme</th>
                                        <th class="vertical-text thborder">Aplicación de las BPD</th>
                                        <th class="vertical-text thborder">Higiene & salud</th>
                                        <th class="vertical-text thborder">Indumentaria completa y limpia</th>
                                        <th class="vertical-text thborder">Limpio</th>
                                        <th class="vertical-text thborder">Exclusivo</th>
                                        <th class="vertical-text thborder">Hermético</th>
                                        <th class="vertical-text thborder">Ausencia de plagas</th>
                                    </tr>
                                </thead>
                                <tbody id="tablacontrolrecepcion">

                                </tbody>
                            </table>
                        </div>

                        <div class="row g-4 top-div">
                            <center><label class="title">OBSERVACIONES</label></center>
                        </div>
                        <div id="tablarecepcionobservacion" class="" style="overflow: scroll;height: 300px; margin-top:20px;">
                            <table id="tbrecepcionobservacion" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo">PRODUCTO</th>
                                        <th class="thtitulo">FECHA</th>
                                        <th class="thtitulo">OBSERVACIÓN</th>
                                        <th class="thtitulo">ACCIÓN CORRECTIVA</th>
                                    </tr>
                                </thead>
                                <tbody id="tablacontrolrecepcionobservacion">

                                </tbody>
                            </table>
                        </div>
                        <button style="margin-bottom: 80px;" id="guardarrecepcion" name="guardarrecepcion" class="btn btn-primary">Guardar</button>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="mes">Seleccione el año:</label>
                                <input type="number" id="anio" name="anio" min="1900" max="2100" value="<?php echo date('Y') ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="mes">Seleccione el mes:</label>
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
                            <div class="col-md-4">
                                <a class="btn btn-success style='witdh:40px !important;'" href="#" onclick="generarPDF()">PDF</a>
                            </div>
                        </div>
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
    <script src="./js/ajaxControlRecepcion.js?v=0.001"></script>
    <script src="./js/select2.min.js"></script>
    <script>
        function generarPDF() {
            var anioSeleccionado = document.getElementById("anio").value;
            var mesSeleccionado = document.getElementById("mes").value;

            if (!mesSeleccionado) {
                Swal.fire({
                    title: "¡Error!",
                    text: "Seleccionar un mes",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                });
                return;
            }
            // Enviar los valores a tu script de generación de PDF
            var url = "pdf-control-recepcion.php?anio=" + anioSeleccionado + "&mes=" + mesSeleccionado;
            window.open(url, "_blank");
        }
    </script>
</body>

</html>