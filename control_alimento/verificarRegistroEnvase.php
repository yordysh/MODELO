<?php
session_start();

// $codusuario = $_SESSION["cod"];
// $oficina = $_SESSION["ofi"];
$codusuario = "00004";

?>

<?php
require_once "m_almacen.php";
require_once "m_consulta_personal.php";

$mostrar = new m_almacen();
$personal = new m_almacen_consulta($oficina);
$dataProducto = $mostrar->MostrarProductoRegistroEnvase();
$dataNumeroProduccion = $mostrar->MostrarProduccionEnvase();
// $dataPersonal = $personal->MostrarDatosPersonal();
$dataPersonal = $mostrar->MostrarPersonal();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../librerias/jquery_ajax/js/ajax_libs_jquery_3.3.1_jquery.min.js"></script>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/responsivePO.css">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="./images/icon/covifarma-ico.ico" type="images/png">

    <!--====== Estilo de ICON ======-->
    <link rel="stylesheet" href="./styleIcons/style.css">
    <link rel="stylesheet" href="./css/select2.min.css">
    <title>Covifarma</title>
    <!-- Agregar la librería jsPDF -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="./js/jsdosimetria.js"></script>

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
    <?php
    require_once('../menulista/index.php');
    ?>
    <main>
        <section>
            <div class="container g-4 row">
                <div class="row g-4 top-div">
                    <center><label class="title">REGISTRO DE REQUERIMIENTO</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formularioRegistroProduccion" class="formSpaceVerificar">
                        <input type="hidden" id="codpersonal" name="codpersonal" value="<?php echo $codusuario; ?>">
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
                        </div>

                        <!--Combo Productos -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Producto</label>
                            <input type="hidden" id="hiddenproducto">
                            <select id="selectProductoCombo" class="form-select selectProducto" aria-label="Default select example">
                                <option value="none" selected disabled>Seleccione producto</option>
                                <?php foreach ($dataProducto as  $lis) { ?>
                                    <option id_reque="<?php echo $lis['COD_REQUERIMIENTO'] ?>" value="<?php echo $lis['COD_PRODUCTO']; ?>" class="option"><?php echo $lis['COD_REQUERIMIENTO'] . " "; ?><?php echo $lis['ABR_PRODUCTO']; ?><?php echo $lis['DES_PRODUCTO'] . " "; ?><?php echo ($lis['PESO_NETO'] / 1000) . " KG" ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <!--Combo Produccion -->
                        <div class="form-outline mb-4 ">
                            <label class="form-label">N° produccion</label>
                            <input type="hidden" id="hiddenproduccion">
                            <select id="selectNumProduccion" class="form-select selectNumProduccion" aria-label="Default select example">
                                <option value="none" selected disabled>Seleccione produccion</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Cantidad en kilogramos</label>
                                <input type="hidden" id='hiddencantidad'>
                                <input type="text" id="cantidad" class="form-control" name="cantidad" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total unidades estimada</label>
                                <input type="text" class="form-control form-control-sm" id="txtcantidadproductos" name="txtcantidadproductos" readonly />
                            </div>
                            <!-- <div class="btncalcular"> -->
                            <div class="col-md-4 botoncalculo">
                                <button class="custom-icon-calcular" name="calcular" id="botonCalcularregistros"><i class="icon-circle-with-plus"></i></button>
                                <!-- <button id="botonCalcularInsumoEnvase" name="calcular" class="btn btn-success">Insertar</button> -->
                            </div>
                            <div class="col-md-4 operario">
                                <label class="form-label">Operario</label>
                                <!-- <input type="hidden" id="hidden"> -->
                                <select id="selectOperario" class="form-select selectProducto" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione operario</option>
                                    <?php foreach ($dataPersonal as  $personal) { ?>
                                        <option value="<?php echo $personal->COD_PERSONAL ?>" class="option"><?php echo $personal->NOM_PERSONAL; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div id="tablaRE" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">
                            <table id="tbRE" class="table table-sm mb-3 table-hover">
                                <div class="row g-4 top-div">
                                    <label class="title_table">TOTAL DE PRODUCTOS</label>
                                </div>
                                <thead>
                                    <tr>
                                        <th class="" scope="col">MATERIALES</th>
                                        <th class="" scope="col">CANTIDAD</th>
                                        <th class="" scope="col">LOTE</th>
                                    </tr>
                                </thead>
                                <tbody id="tablacalculoregistroenvase">

                                </tbody>
                            </table>
                        </div>

                        <div id="tablainsumosavance" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px; margin-bottom:10px;">
                            <table id="tbinsumosavance" class="table table-sm mb-3 table-hover">
                                <div class="row g-4 top-div">
                                    <label class="title_table">TOTAL DE INSUMOS</label>
                                </div>
                                <thead>
                                    <tr>
                                        <th class="" scope="col">INSUMOS</th>
                                        <th class="" scope="col">CANTIDAD</th>
                                        <th class="" scope="col">LOTE</th>
                                    </tr>
                                </thead>
                                <tbody id="tablainsumosavancetotal">

                                </tbody>
                            </table>
                        </div>

                        <!-- Crear PDF -->
                        <div class="contenedorpdfverificar">
                            <div class="separacion">
                                <label for="mes">Seleccione el año:</label>
                                <input class="aniov" type="number" id="anio" name="anio" min="1900" max="2100" value="2023">
                            </div>
                            <div class="separacion">
                                <label for="mes">Seleccione el mes:</label>
                                <select class="mesv" id="mes" name="mes">
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

                            <div class="botonpdfregistro">
                                <a class="btn btn-danger estilopdfregistro" href="#" onclick="generarPDF()">AVANCE</a>
                            </div>
                            <div class="dosimetria">
                                <button id="generarPDF" class="btn btn-success estilodosimetria">DOSIMETRIA</button>
                            </div>
                        </div>

                        <div class="estiloguardar">
                            <button id="botonguardarregistro" type="submit" name="insert" class="btn btn-primary estiloguardar">Guardar </button>
                        </div>
                    </form>

                </div>


            </div>
            </div>
        </section>
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
    <script src="./js/ajaxVerificarRegistroEnvase.js?v=0.001"></script>
    <!-- <script src="./js/jsdosimetria.js"></script> -->
    <script src="../js/menu_a.js"></script>
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
            var url = "pdf-registro-produccion.php?anio=" + anioSeleccionado + "&mes=" + mesSeleccionado;
            window.open(url, "_blank");
        }
    </script>
</body>

</html>