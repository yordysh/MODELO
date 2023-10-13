<?php
session_start();

// $codusuario = $_SESSION["cod"];
// $codanexo=$_SESSION["ane"];
$codusuario = '00001';
// $codanexo = '1010';

?>
<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
// $dataProducto = $mostrar->MostrarProductoComboRegistro();
$dataProductoTerminado = $mostrar->MostrarProductoTerminado();

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
    <nav class="nav">
        <div class="wave"></div>
        <i class="icon-menu navOpenBtn"></i>
        <a class="logo" href="./"><img src="./images/logo-covifarma.png" alt=""></a>
        <ul class="nav-links">
            <div class="icon-cross navCloseBtn"></div>
            <li>
                <a class="" href="formulacionEnvases.php">Formulación</a>
            </li>
            <li>
                <a class="" href="requerimientoProducto.php">Requerimiento</a>
            </li>
            <li>
                <a class="" href="pedidoRequerimiento.php">Confirmación de requerimiento</a>
            </li>
            <!-- <li>
                <a class="activo" href="#">Solicitar compra</a>
            </li> -->
            <li>
                <a class="activo">Compras realizar</a>
                <ul class="menu-vertical">
                    <li>
                        <a class="" href="solicitaCompra.php">Solicitar compra</a>
                    </li>
                    <li>
                        <a class="" href="#">Generar comprobante</a>
                    </li>
                    <li>
                        <a class="" href="ordenCompra.php">Orden de compra</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="" href="cantidadMinimaProducto.php">Cantidad mínima</a>
            </li>
            <li>
                <a class="" href="produccionRequerimiento.php">Producción</a>
            </li>
            <li>
                <a class="" href="verificarRegistroEnvase.php">Avance producción</a>
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
                <div class="main">
                    <form method="post" action="" id="formulariocompraorden">
                        <input type="hidden" id="codpersonal" name="codpersonal" value="<?php echo $codusuario; ?>">
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
                        </div>

                        <!-- Tabla total requerimiento pedido-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 200px!important; margin-top:30px;margin-bottom:20px;">
                            <div class="row g-4 top-div">
                                <center><label class="title_table">ORDENES DE COMPRA</label></center>
                            </div>
                            <table id="tmostrarcomprobante" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">ORDEN</th>
                                        <th class="thtitulo" scope="col">FECHA</th>
                                        <th class="thtitulo" scope="col">PROVEEDOR</th>
                                        <th class="thtitulo" scope="col">EMPRESA</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tablamostarcomprobante">

                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" id="codigoorden" class="form-control">
                        <div class="row g-4 top-div">
                            <center><label class="title_table">REGISTRAR COMPROBANTE</label></center>
                        </div>

                        <div class="estiloordencompra">
                            <!-- Text input empresa-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Empresa</label>
                                <select id="selectempresa" class="form-select" aria-label="Default select example">
                                    <option value="00003" selected>LABSABELL</option>
                                    <option value="00004">COVIFARMA</option>

                                </select>
                            </div>

                            <!-- Text input fecha-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Fecha emisión</label>
                                <input type="date" id="fecha_emision" class="form-control">
                            </div>

                            <!-- Text input hora-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Hora emisión</label>
                                <input type="text" id="hora" class="form-control" disabled>
                            </div>

                            <!-- Text input fecha entrega-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Fecha entrega</label>
                                <input type="date" id="fecha_entrega" class="form-control">
                            </div>
                        </div>

                        <div class="estiloordencompra">
                            <!-- Text input personal-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Personal</label>
                                <input type="text" id="personal" class="form-control" disabled>
                            </div>

                            <!-- Text input proveedor-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Proveedor</label>
                                <input type="text" id="proveedor" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="estiloordencompra">
                            <!-- Text input tipo comprobante-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Tipo</label>
                                <select id="selecttipocompro" class="form-select" aria-label="Default select example">
                                    <option value="none" selected>Seleccione comprobante</option>
                                    <option value="F">FACTURA</option>
                                    <option value="B">BOLETA</option>
                                    <option value="R">RECIBO</option>
                                    <option value="T">TICKET</option>
                                    <option value="H">RECIBO POR HONORARIO</option>
                                </select>
                            </div>

                            <!-- Text input serie-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Serie</label>
                                <input type="text" id="serie" class="form-control" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57">
                            </div>

                            <!-- Text input correlativo-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Correlativo</label>
                                <input type="text" id="correlativo" class="form-control" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57">
                            </div>
                        </div>
                        <!-- Text input oficina-->
                        <!-- <div class="form-outline mb-4">
                            <label class="form-label">Oficina</label>
                            <select id="selectoficina" class="form-select" aria-label="Default select example">
                                <option value="00011">SMP</option>
                                <option value="00026" selected>SMP2</option>
                                <option value="00029">SMP4</option>
                                <option value="00030">SMP5</option>
                                <option value="00031">SMP6</option>
                                <option value="00038">SMP7</option>
                                <option value="00039">SMP8</option>
                                <option value="00040">SMP9</option>
                                <option value="00041">SMP10</option>
                            </select>
                        </div> -->
                        <div class="estiloordencompra">
                            <!-- Text input FORMA DE PAGO-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">F.pago</label>
                                <select id="selectformapago" class="form-select" aria-label="Default select example">
                                    <option value="E" selected>EFECTIVO</option>
                                    <option value="D">DEPOSITO</option>
                                </select>
                            </div>

                            <!-- Text input moneda-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Moneda</label>
                                <select id="selectmoneda" class="form-select" aria-label="Default select example">
                                    <option value="S" selected>SOLES</option>
                                    <option value="D">DOLARES</option>
                                </select>
                            </div>

                            <!-- Text input tipo de cambio-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Tipo cambio</label>
                                <input type="text" id="tipocambio" class="form-control" disabled placeholder="0.000">
                            </div>
                        </div>

                        <div class="estiloordencompra">
                            <!-- Text input tipo de cambio sunat-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">TIPO CAMBIO SUNAT</label>
                                <input type="text" id="tipocambiosunat" class="form-control" value="3.823" disabled>
                            </div>

                            <!-- Text input numero operacion-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">N° OPERACIÓN</label>
                                <input type="text" id="numoperacion" class="form-control" value="0.000" disabled>
                            </div>

                            <!-- Text input numero operacion referencial-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">N° OPERACIÓN REFERENCIAL</label>
                                <input type="text" id="numoperacion" class="form-control" value="0.000" disabled>
                            </div>


                            <!-- Text input IGV-->
                            <div class="custom-input">
                                <div class="form-outline mb-4 ">
                                    <label class="form-label">INCLUYE IGV</label>
                                </div>
                                <div class="form-outline mb-4 ">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="radioigvsi" checked>
                                    <label class="form-check-label">SI</label>
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="radioigvno">
                                    <label class="form-check-label">NO</label>
                                </div>
                            </div>
                        </div>

                        <!-- Text observacion-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Observación</label>
                            <textarea class="form-control" id="observacion" rows="3"></textarea>
                        </div>

                        <!-- Tabla total insumos por comprar-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 200px!important; margin-top:30px;margin-bottom:20px;">
                            <div class="row g-4 top-div">
                                <center><label class="title_table">INSUMOS POR COMPRAR</label></center>
                            </div>
                            <table id="tinsumoscomprarfactura" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">NOMBRE</th>
                                        <th class="thtitulo" scope="col">CANTIDAD</th>
                                        <th class="thtitulo" scope="col">PRECIO</th>
                                        <!-- <th class="thtitulo" scope="col">LOTE</th> -->
                                        <!-- <th class="thtitulo" scope="col">SELECCIONAR</th> -->
                                    </tr>
                                </thead>
                                <tbody id="tablainsumoscomprarfactura">

                                </tbody>
                            </table>
                        </div>
                        <?php
                        require_once "modalfacturasubir.php";
                        ?>
                        <!-- Insertar nuevas cantidades -->
                        <div class="contenedor">
                            <div class="ctnBtn">
                                <button id="guardarfacturaorden" class="btn btn-primary boton-insertar" data-bs-toggle="modal" data-bs-target="#mostrarfacturasubir">Guardar</button>
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
    <!-- <script src="./js/ajaxGenerarComprobante.js"></script> -->
    <script src="./js/ajaxGenerarComprobante.js?v=0.001"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>