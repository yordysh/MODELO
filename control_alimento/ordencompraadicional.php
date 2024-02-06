<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();

// $dataproductosproveedor = $mostrar->MostrarProductoProveedores();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/responsivePedido.css">
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
        .form-select {
            width: auto;
        }
    </style>
    <main>
        <section>
            <div class="container g-4 row">

                <div class="main">
                    <!-- Tabla total a comprar insumos-->
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: auto;height: 500px !important; margin-top:20px;">
                        <div class="row g-4 top-div">
                            <center><label class="title_table">INSUMOS Y ENVASES DE LA ORDEN</label></center>
                        </div>
                        <table id="tTotalinsumoscomprar" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <th class="thtitulo" scope="col">PROVEEDOR</th>
                                    <th class="thtitulo" scope="col">PRODUCTO</th>
                                    <th class="thtitulo" scope="col">CANTIDAD COMPRADA</th>
                                    <th class="thtitulo" scope="col">PRECIO TOTAL</th>
                                    <th class="thtitulo" scope="col">FECHA ENTREGA</th>
                                    <th class="thtitulo" scope="col">F.PAGO</th>
                                    <th class="thtitulo" scope="col">IMAGEN</th>
                                    <th class="thtitulo" scope="col">PRECIO</th>
                                    <th class="thtitulo" scope="col">OTRAS CANTIDADES</th>
                                </tr>
                            </thead>
                            <tbody id="tablainsumosenvasesadicional">

                            </tbody>
                        </table>
                    </div>

                    <!-- Tabla de imagenes -->
                    <div class="table-responsive" style="overflow-x: hidden;height: 200px!important; margin-top:30px;margin-bottom:20px;">
                        <div class="row g-4 top-div">
                            <center><label class="title_table">DEPOSITO</label></center>
                        </div>
                        <table id="tbimagenes" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <th class="thtitulo" scope="col">ACCION</th>
                                    <th class="thtitulo" scope="col">PROVEEDOR</th>
                                    <th class="thtitulo" scope="col">SUBIR IMAGEN</th>
                                    <th class="thtitulo" scope="col">VISUALIZAR</th>
                                </tr>
                            </thead>
                            <tbody id="tablaimagenes">

                            </tbody>
                        </table>
                    </div>

                    <button id="guardarordencompraadional" name="calcularInsEnv" class="btn btn-primary boton-insertar">Guardar</button>


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
    <script src="./js/ajaxOrdencompraAdicional.js?v=0.001"></script>
    <script src="../js/menu_a.js"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>