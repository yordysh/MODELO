<?php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }
/*comentar en produccion */
require_once("./c_permisosmenu.php");
$controller = new c_permisosmenu();
$controller->c_permisos("1100");
/*--------------------------- */
$menu = $_SESSION["menu_c"];
$submenu = $_SESSION["submenu_c"];
$submenu2 = $_SESSION["subsub_c"];

?>
<nav class="nav">
    <div class="wave"></div>
    <i class="icon-menu navOpenBtn"></i>
    <a class="logo" href="./"><img src="./images/logo-covifarma.png" alt=""></a>

    <ul class="nav-links idex">

        <?php
        echo "<div class='icon-cross navCloseBtn'></div>";
        for ($i = 0; $i < count($menu); $i++) {
            if ($menu[$i][2] == '') {
                echo "<li>";
                echo   "<a class='phsStyle' aria-current='page'>" . $menu[$i][1] . "</a>";
                echo "<ul class='menu-vertical'>";
                for ($l = 0; $l < count($submenu); $l++) {

                    if ($menu[$i][0] == $submenu[$l][0]) {
                        echo "<li>";
                        if ($submenu[$l][2] != '') {

                            echo "<a   href='" . $submenu[$l][2] . "'>" . $submenu[$l][1] . "</a>";

                            // echo "<li><a href='" . $submenu[$l][2] . "' class='submenulista font'>" . $submenu[$l][1] . "<span class='icon-dot'></span></a>";
                        } else {
                            echo "<a>" . $submenu[$l][1] . "</a>";
                        }
                        echo "<ul class='menu-vertical-item'>";
                        for ($j = 0; $j < count($submenu2); $j++) {
                            if ($menu[$i][0] == $submenu2[$j][0] && $submenu[$l][3] == $submenu2[$j][1]) {
                                echo "<li><a href=" . $submenu2[$j][4] . ">" . $submenu2[$j][3] . "</a></li>";
                            }
                        }
                        echo "</ul>";

                        echo "</li>";
                    }
                }
                echo "</ul>";
                echo "</li>";
            } else {
                echo   " <li><a href=" . $menu[$i][2] . " class='phsStyle' aria-current='page'>" . $menu[$i][1] . "</a>";
                echo "</li>";
            }
        }

        ?>
    </ul>


    <!-- <ul class="nav-links idex">
        <div class="icon-cross navCloseBtn"></div>
        <li>
            <a class="phsStyle" aria-current="page">PHS</a>
            <ul class="menu-vertical">
                <li>
                    <a class="" href="infraestructuraAccesorios.php">LBS-PHS-FR-01</a>
                </li>
                <li>
                    <a class="" href="preparacionSolucion.php">LBS-PHS-FR-02</a>
                </li>
                <li>
                    <a class="" href="controlMaquinas.php">LBS-PHS-FR-03</a>
                </li>
                <li>
                    <a class="" href="limpiezaDesinfeccion.php">LBS-PHS-FR-04</a>
                </li>
            </ul>
        </li>

        <li>
            <a class="bpmStyle">OP</a>
            <ul class="menu-vertical">
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
                    <a class="" href="solicitaCompra.php">Solicitar compra</a>
                </li>
                <li>
                    <a class="" href="cantidadMinimaProducto.php">Cantidad mínima</a>
                </li>
                <li>
                    <a class="" href="registroEnvases.php">Producción</a>
                <li>
                    <a class="" href="verificarRegistroEnvase.php">Registros envases</a>
                </li>
            </ul>
        </li>
    </ul> -->
</nav>