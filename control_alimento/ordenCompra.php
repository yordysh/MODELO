<?php
session_start();

$codusuario = $_SESSION["cod"];
$codoficina = $_SESSION["ofi"];
// $codusuario = '0002';
// $codoficina = 'SMP2';

?>
<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataProveedores = $mostrar->MostrarProveedores();

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
    <!-- <nav class="nav">
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
            <li>
                <a class="activo">Compras realizar</a>
                <ul class="menu-vertical">
                    <li>
                        <a class="" href="solicitaCompra.php">Solicitar compra</a>
                    </li>
                    <li>
                        <a class="" href="#">Orden de compra</a>
                    </li>
                    <li>
                        <a class="" href="generarComprobante.php">Generar comprobante</a>
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
    </nav> -->
    <?php
    require_once('../menulista/index.php');
    ?>

    <main>
        <section>
            <div class="container g-4 row">
                <div class="main">
                    <form method="post" action="" id="formulariocompraorden">
                        <input type="hidden" id="codpersonal" name="codpersonal" value="<?php echo $codusuario; ?>">
                        <input type="hidden" id="vroficina" name="vroficina" value="<?php echo $codoficina; ?>">

                        <!-- Tabla total requerimiento pedido-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 150px!important; margin-top:30px;margin-bottom:20px;">
                            <div class="row g-4 top-div">
                                <center><label class="title_table">DOCUMENTOS APROBADOS</label></center>
                            </div>
                            <table id="tmostrarordencompraaprobado" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">CODIGO REQUERIMIENTO</th>
                                        <th class="thtitulo" scope="col">FECHA</th>
                                        <th class="thtitulo" scope="col">PERSONAL</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tablamostarcomprasaprobadas">

                                </tbody>
                            </table>
                        </div>

                        <!-- Tabla total insumos por comprar-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 200px!important; margin-top:30px;margin-bottom:20px;">
                            <div class="row g-4 top-div">
                                <center><label class="title_table">INSUMOS POR COMPRAR</label></center>
                            </div>
                            <table id="tinsumoscomprar" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">MATERIAL</th>
                                        <th class="thtitulo" scope="col">CANTIDAD</th>
                                        <!-- <th class="thtitulo" scope="col">PRECIO</th> -->
                                        <th class="thtitulo" scope="col">SELECCIONAR</th>
                                    </tr>
                                </thead>
                                <tbody id="tablainsumoscomprar">

                                </tbody>
                            </table>
                        </div>


                        <div class="row g-4 top-div">
                            <center><label class="title_table">GENERAR ORDEN DE COMPRAR</label></center>
                        </div>
                        <div class="estiloordencompra">
                            <!-- Text input fecha-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Fecha</label>
                                <input type="date" id="fecha" class="form-control">
                            </div>

                            <!-- Text input empresa-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Empresa</label>
                                <select id="selectempresa" class="form-select" aria-label="Default select example">
                                    <option value="00003" selected>LABSABELL</option>
                                    <option value="00004">COVIFARMA</option>

                                </select>
                            </div>

                            <!-- Text input personal-->
                            <div class="form-outline mb-4 custom-input">
                                <label class="form-label">Personal</label>
                                <input type="text" id="personal" class="form-control" disabled>
                            </div>
                        </div>

                        <!-- Text input oficina-->
                        <div class="form-outline mb-4" style="display: none;">
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
                        </div>
                        <div class="estiloordencompra">
                            <!-- Text input proveedor-->
                            <div class="form-outline mb-4 estiloproveedor">
                                <div class="estiloordencompra">
                                    <div class="estiloproveedor">
                                        <label class="form-label">Proveedor</label>
                                        <input type="text" id="proveedor" class="form-control" disabled>
                                        <input type="hidden" id="direccion" class="form-control">
                                        <input type="hidden" id="ruc_principal" class="form-control">
                                        <input type="hidden" id="dni_principal" class="form-control">
                                    </div>
                                    <div class="buttonproveedor">
                                        <button type='button' class="custom-icon" data-bs-toggle="modal" data-bs-target="#mostrarproveedor"><i class="icon-add-user"></i></button>
                                    </div>
                                </div>
                            </div>

                            <!-- Text input FORMA DE PAGO-->
                            <div class="form-outline mb-4 estiloselect">
                                <label class="form-label">F.pago</label>
                                <select id="selectformapago" class="form-select" aria-label="Default select example">
                                    <option value="E" selected>EFECTIVO</option>
                                    <option value="D">DEPOSITO</option>
                                </select>
                            </div>

                            <!-- Text input moneda-->
                            <div class="form-outline mb-4 estiloselect">
                                <label class="form-label">Moneda</label>
                                <select id="selectmoneda" class="form-select" aria-label="Default select example">
                                    <option value="S" selected>SOLES</option>
                                    <option value="D">DOLARES</option>
                                </select>
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
                                <center><label class="title_table">DETALLE DE COMPRA</label></center>
                            </div>
                            <table id="tinsumoscomprarprecio" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">MATERIAL</th>
                                        <th class="thtitulo" scope="col">CANTIDAD</th>
                                        <th class="thtitulo" scope="col">PRECIO</th>
                                    </tr>
                                </thead>
                                <tbody id="tablainsumoscomprarprecio">

                                </tbody>
                            </table>
                        </div>

                        <!-- Insertar nuevas cantidades -->
                        <div class="contenedorpdf">
                            <div class="">
                                <button id="insertarOrdenCompraInsumos" class="btn btn-primary boton-insertar">Guardar</button>
                            </div>
                            <div class="estilorequerimiento">
                                <input id="idrequerimientotemp" type="number" class="form-control" name="id" />
                            </div>
                            <div>
                                <a class="btn btn-success" href="#" onclick="generarPDF()">Generar PDF</a>
                            </div>
                        </div>
                </div>
        </section>
    </main>
    <footer class="bg-dark p-2 mt-5 text-light position-fixed bottom-0 w-100 text-center">
        Covifarma-2023
    </footer>
    <?php
    require_once "modalproveedor.php";
    ?>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.7.0.min.js"></script>
    <script src="./js/sweetalert2.all.min.js"></script>
    <script src="./js/ajaxOrdenCompra.js?v=0.001"></script>
    <script src="../js/menu.js"></script>
    <script src="./js/select2.min.js"></script>
    <script>
        function generarPDF() {
            var seleccion = document.getElementById("idrequerimientotemp").value;
            // Enviar los valores a tu script de generación de PDF
            var url =
                "pdf-factura-orden.php?requerimiento=" +
                seleccion;
            window.open(url, "_blank");
        }
    </script>
</body>

</html>