<?php
session_start();
// $codusuario = $_SESSION["cod"];
$oficina = 'SMP2';
$codusuario = "0356";

?>

<?php
require_once "m_almacen.php";
require_once "m_consulta_personal.php";

$personal = new m_almacen_consulta($oficina);
$mostrar = new m_almacen();

$dataProducto = $mostrar->MostrarProductoRegistroEnvase();
$dataPersonal = $personal->MostrarDatosPersonal();
$fechaactual = $mostrar->c_horaserversql('F');
// $productoavance =$mostrar
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
    <script src="./js/jsEnvasadoEncajado.js?v=0.001"></script>
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
                    <center><label class="title">CONTROL DE ENVASADO Y ENCAJADO</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formularioControlEnvasado">
                        <input type="hidden" id="codpersonal" name="codpersonal" value="<?php echo $codusuario; ?>">


                        <div class="row">
                            <!-- Producto -->
                            <div class="col-md-4 form-outline mb-4">
                                <label class="form-label">Producto</label>
                                <select id="selectProducto" class="form-select" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione producto</option>
                                    <?php foreach ($dataProducto as  $producto) { ?>
                                        <option id_reque="<?php echo $producto['COD_REQUERIMIENTO'] ?>" value="<?php echo $producto['COD_PRODUCTO']; ?>" class="option"><?php echo $producto['COD_REQUERIMIENTO'] . " "; ?><?php echo $producto['ABR_PRODUCTO']; ?><?php echo $producto['DES_PRODUCTO'] . " "; ?><?php echo ($producto['PESO_NETO'] / 1000) . " KG" ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- Lote -->
                            <div class="col-md-4 operario">
                                <label class="form-label">Lote producción</label>
                                <input type="hidden" id="hiddenproduccion">
                                <select id="selectNumProduccion" class="form-select selectNumProduccion" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione produccion</option>
                                </select>
                            </div>
                            <!-- fecha envasado-->
                            <div class=" col-md-4 form-outline mb-4">
                                <label class="form-label">Fecha envasado</label>
                                <input type="text" id="fechaenvasado" class="form-control" name="" value="<?php echo $fechaactual; ?>" disabled>
                            </div>

                            <!-- Fecha cernido -->
                            <div class=" col-md-4 form-outline mb-4">
                                <label class="form-label">Fecha cernido</label>
                                <input type="text" id="fechacernido" class="form-control" name="" disabled>
                            </div>
                            <!-- Cantidad de envases -->
                            <div class=" col-md-4 form-outline mb-4">
                                <label class="form-label">Cantidad envases</label>
                                <input type="text" id="cantidadenvases" class="form-control" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57">
                            </div>
                            <div class="col-md-4 ">
                                <button class="custom-icon-calcular" name="calcular" id="botonCalcularEnvases"><i class="icon-circle-with-plus"></i></button>
                                <!-- <button id="botonCalcularInsumoEnvase" name="calcular" class="btn btn-success">Insertar</button> -->
                            </div>
                        </div>
                        <div id="tablaenvases" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">
                            <table id="tbenvases" class="table table-sm mb-3 table-hover">
                                <div class="row g-4 top-div">
                                    <label class="title_table">TOTAL DE PRODUCTOS</label>
                                </div>
                                <thead>
                                    <tr>
                                        <th class="" scope="col">MATERIALES</th>
                                        <th class="" scope="col">CANTIDAD</th>
                                        <th class="" scope="col">CANTIDAD MERMA</th>
                                        <th class="" scope="col">LOTE</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaenvasecalculado">

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <!----------------Operario---------->
                            <div class="col-md-4 operario">
                                <label class="form-label">Operario</label>
                                <!-- <input type="hidden" id="hidden"> -->
                                <select id="selectOperador" class="form-select" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione operario</option>
                                    <?php foreach ($dataPersonal as  $personal) { ?>
                                        <option value="<?php echo $personal->COD_PERSONAL ?>" class="option"><?php echo $personal->NOM_PERSONAL1; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- Opciones -->
                            <div class="col-md-4 operario">
                                <label class="form-label">Operaciones</label>
                                <!-- <input type="hidden" id="hidden"> -->
                                <select id="selectOpciones" class="form-select" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione</option>
                                    <option value="1">Llenado</option>
                                    <option value="2">Pesado, colocación de cucharita y alupol</option>
                                    <option value="3">Pre-Limpiado</option>
                                    <option value="4">Sellado</option>
                                    <option value="5">Codificado</option>
                                    <option value="6">Tapado</option>
                                    <option value="7">Limpiado</option>
                                    <option value="8">Etiquetado</option>
                                </select>
                            </div>
                        </div>


                        <!-- Text input Observacion-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" id="textAreaObservacion" rows="3"></textarea>
                        </div>
                        <!-- Insertar produccion por requerimiento -->
                        <div class="contenedor">

                            <div class="ctnBtn">
                                <input type="hidden" id="taskcodrequerimiento">
                                <button id="insertarProduccionRequerimiento" name="produccionrequerimiento" class="btn btn-primary bt-insert">Guardar</button>
                            </div>
                            <div class="envasado">
                                <button id="generarPDF" class="btn btn-success">ENVASADO</button>
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
    <script src="./js/ajaxControlEnvasado.js?v=0.001"></script>

    <script src="../js/menu_a.js"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>