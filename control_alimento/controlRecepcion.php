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
                                $uniqueRequerimientos = array();
                                foreach ($dataRequerimiento as $lista) {
                                    if (!in_array($lista->COD_REQUERIMIENTO, $uniqueRequerimientos)) {
                                        echo '<option value="' . $lista->COD_REQUERIMIENTO . '" class="option">' . $lista->COD_REQUERIMIENTO . '</option>';
                                        $uniqueRequerimientos[] = $lista->COD_REQUERIMIENTO;
                                    }
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