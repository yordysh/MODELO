<?php
session_start();

// $codusuario = $_SESSION["cod"];
// $codanexo=$_SESSION["ane"];
$codusuario = '0004';
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
                        <div class="table-responsive" style="overflow-x: hidden;height: 200px!important; margin-top:30px;margin-bottom:20px;">
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

                        <!-- Text input fecha-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Fecha</label>
                            <input type="date" id="fecha" class="form-control" name="" disabled>
                        </div>

                        <!-- Text input empresa-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Empresa</label>
                            <input type="text" id="empresa" class="form-control" name="" disabled>
                        </div>

                        <!-- Text input personal-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Personal</label>
                            <input type="text" id="personal" class="form-control" name="" disabled>
                        </div>

                        <!-- Text input oficina-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Oficina</label>
                            <select id="selectoficina" class="form-select" aria-label="Default select example">
                                <option value="0" selected disabled>Seleccione oficina</option>
                                <option value="00011">SMP</option>
                                <option value="00026">SMP2</option>
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
                            <input type="text" id="direccion" class="form-control">
                            <input type="text" id="ruc_principal" class="form-control">
                            <input type="text" id="dni_principal" class="form-control">
                        </div>
                        <button type='button' class="custom-icon" data-bs-toggle="modal" data-bs-target="#mostrarproveedor"><i class="icon-check"></i></button>

                        <!-- Text input moneda-->
                        <div class="form-outline mb-4">
                            <label class="form-label">Moneda</label>
                            <select id="selectmoneda" class="form-select" aria-label="Default select example">
                                <option value="0" selected disabled>Seleccione moneda</option>
                                <option value="S">Soles</option>
                                <option value="D">Dolares</option>
                            </select>
                        </div>

                        <!-- Insertar nuevas cantidades -->
                        <div class="contenedor">

                            <div class="ctnBtn">
                                <input type="hidden" id="taskcodrequhiddenvalidar">
                                <button id="insertarCompraInsumos" name="calcularInsEnv" class="btn btn-primary boton-insertar">Guardar</button>
                                <input type="text" id="mensajecompleto" style="width: 270px; font-weight:bold; display:none;" value="Insumos completos en el almacen" disabled>
                                <!-- <button id="boton" type="submit" name="insert" class="btn btn-primary bt-guardar">Insertar</button> -->
                            </div>
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
</body>

</html>