<?php

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

    <ul class="nav-links">
        <?php
        echo "<div class='icon-cross navCloseBtn'></div>";
        for ($i = 2; $i < count($menu); $i++) {
            if ($menu[$i][2] == '') {
                echo "<li>";
                echo   "<a   href='" . $menu[$i][2] . "'>" . $menu[$i][1] . "</a>";
                // echo "<ul class='menu-vertical'>";
                // for ($l = 0; $l < count($submenu); $l++) {

                //     if ($menu[$i][0] == $submenu[$l][0]) {
                //         echo "<li>";
                //         if ($submenu[$l][2] != '') {

                //             echo "<a   href='" . $submenu[$l][2] . "'>" . $submenu[$l][1] . "</a>";

                //             // echo "<li><a href='" . $submenu[$l][2] . "' class='submenulista font'>" . $submenu[$l][1] . "<span class='icon-dot'></span></a>";
                //         } else {
                //             echo "<a>" . $submenu[$l][1] . "</a>";

                //             // echo "<li><a class='submenulista font'>" . $submenu[$l][1] . "<span class='icon-dot'></span></a>";
                //         }

                //         echo "</li>";
                //     }
                // }
                // echo "</ul>";
                echo "</li>";
            } else {
                echo "<li><a href=" . $menu[$i][2] . " >" . $menu[$i][1] . "</a>";
                echo "</li>";
            }
        }

        ?>

        <!-- <ul class="nav-links">
        <div class="icon-cross navCloseBtn"></div> -->
        <!-- <li>
            <a class="" href="#">LBS-PHS-FR-01</a>
        </li>
        <li>
            <a class="" href="preparacionSolucion.php">LBS-PHS-FR-02</a>
        </li>
        <li>
            <a class="" href="controlMaquinas.php">LBS-PHS-FR-03</a>
        </li>
        <li>
            <a class="" href="limpiezaDesinfeccion.php">LBS-PHS-FR-04</a>
        </li> -->

        <!-- </ul> -->
        <i class="icon-magnifying-glass search-icon" id="searchIcon"></i>
        <div class="search-box">
            <i class="icon-magnifying-glass search-icon"></i>
            <input type="search" id="search" placeholder="Buscar . . ." class="form-control me-2">
        </div>
</nav>