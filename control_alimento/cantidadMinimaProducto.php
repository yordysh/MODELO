<?php
require_once "m_almacen.php";

$mostrar = new m_almacen();
$dataCantidadMinima = $mostrar->MostrarProductoComboRegistro();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/responsivePO.css">
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
    <main>
        <section>
            <div class="container g-4 row">
                <div class="row g-4 top-div">
                    <center><label class="title">CANTIDAD MINIMA DE COMPRA</label></center>
                </div>
                <div class="main">
                    <form method="post" action="" id="formulariocantidadminima">

                        <!-- Insertar nuevas cantidades -->
                        <div class="contenedor">
                            <div class="mb-3">
                                <label class="form-label">Productos</label>
                                <select id="selectCantidadminima" class="form-select" aria-label="Default select example">
                                    <option value="none" selected disabled>Seleccione producto</option>
                                    <?php foreach ($dataCantidadMinima as $lis) {
                                    ?>
                                        <option value="<?php echo $lis['COD_PRODUCTO']; ?>" class="option"><?php echo $lis['ABR_PRODUCTO'] . " "; ?> <?php echo $lis['DES_PRODUCTO']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cantidad minima</label>
                                <input class="form-control" type="number" id="cantidadMinima" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57" required></input>
                            </div>
                        </div>
                        <div class="">
                            <input type="hidden" id="taskId">
                            <button id="botonminimo" type="submit" name="insert" class="btn btn-primary bt-insert">Guardar </button>
                        </div>
                    </form>
                    <!-- Tabla de insumos que se requiere-->
                    <div class="table-responsive" style="overflow: scroll;height: 300px; margin-top:20px;">
                        <table id="tcantidadminima" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <th class="" scope="col">INSUMOS</th>
                                    <th class="" scope="col">CANTIDAD</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tablacantidadminima">

                            </tbody>
                        </table>
                    </div>




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
    <script src="./js/ajaxCantidadMinima.js"></script>
    <script src="../js/menu_a.js"></script>
    <script src="./js/select2.min.js"></script>
</body>

</html>