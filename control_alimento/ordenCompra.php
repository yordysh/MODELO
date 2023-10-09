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
            <li>
                <a class="activo" href="#">Solicitar compra</a>
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
                <!-- <div class="row g-4 top-div">
                    <center><label class="title">DOCUMENTOS APROBADOS</label></center>
                </div> -->
                <div class="main">
                    <form method="post" action="" id="formulariocompraorden">
                        <input type="hidden" id="codpersonal" name="codpersonal" value="<?php echo $codusuario; ?>">
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input id="id" type="hidden" class="form-control" name="id" />
                        </div>

                        <!-- Tabla total requerimiento pedido-->
                        <div class="table-responsive" style="overflow-x: hidden;height: 150px!important; margin-top:30px;margin-bottom:20px;">
                            <div class="row g-4 top-div">
                                <center><label class="title_table">DOCUMENTOS APROBADOS</label></center>
                            </div>
                            <table id="tmostrarordencompraaprobado" class="table table-sm mb-3 table-hover">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">CODIGO</th>
                                        <th class="thtitulo" scope="col">FECHA</th>
                                        <th class="thtitulo" scope="col">PERSONAL</th>
                                        <!-- <th class="thtitulo" scope="col">MOTIVO</th> -->

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
                                        <th class="thtitulo" scope="col">PRECIO</th>
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
                        <!-- Text input fecha-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Fecha</label>
                            <input type="date" id="fecha" class="form-control">
                        </div>

                        <!-- Text input empresa-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Empresa</label>
                            <select id="selectempresa" class="form-select" aria-label="Default select example">
                                <option value="00003" selected>LABSABELL</option>
                                <option value="00004">COVIFARMA</option>

                            </select>
                        </div>

                        <!-- Text input personal-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Personal</label>
                            <input type="text" id="personal" class="form-control" disabled>
                        </div>

                        <!-- Text input oficina-->
                        <div class="form-outline mb-4">
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
                        <!-- Text input proveedor-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Proveedor</label>
                            <input type="text" id="proveedor" class="form-control" disabled>
                            <input type="hidden" id="direccion" class="form-control">
                            <input type="hidden" id="ruc_principal" class="form-control">
                            <input type="hidden" id="dni_principal" class="form-control">
                        </div>
                        <button type='button' class="custom-icon" data-bs-toggle="modal" data-bs-target="#mostrarproveedor"><i class="icon-add-user"></i></button>

                        <!-- Text input FORMA DE PAGO-->
                        <div class="form-outline mb-4">
                            <label class="form-label">F.pago</label>
                            <select id="selectformapago" class="form-select" aria-label="Default select example">
                                <option value="E" selected>EFECTIVO</option>
                                <option value="D">DEPOSITO</option>
                            </select>
                        </div>

                        <!-- Text input moneda-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Moneda</label>
                            <select id="selectmoneda" class="form-select" aria-label="Default select example">
                                <option value="S" selected>SOLES</option>
                                <option value="D">DOLARES</option>
                            </select>
                        </div>
                        <!-- Text observacion-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Observación</label>
                            <textarea class="form-control" id="observacion" rows="3"></textarea>
                        </div>


                        <!-- Insertar nuevas cantidades -->
                        <div class="contenedor">
                            <div class="ctnBtn">
                                <button id="insertarOrdenCompraInsumos" class="btn btn-primary boton-insertar">Guardar</button>
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
    <script src="./js/ajaxOrdenCompra.js"></script>
    <script src="./js/select2.min.js"></script>
    <script>
        function generarPDF() {
            var anioSeleccionado = document.getElementById("anio").value;
            var mesSeleccionado = document.getElementById("mes").value;

            // Enviar los valores a tu script de generación de PDF
            var url =
                "pdf-factura-orden.php?anio=" +
                anioSeleccionado +
                "&mes=" +
                mesSeleccionado;
            window.open(url, "_blank");
        }
    </script>
</body>

</html>