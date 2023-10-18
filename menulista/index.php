<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// $controller = new c_permisosmenu();
// $controller->c_permisos("1100");
/*--------------------------- */
$menu = $_SESSION["menu_c"];
$submenu = $_SESSION["submenu_c"];
$submenu2 = $_SESSION["subsub_c"];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/menu.css">

</head>

<body>
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
                            echo "<ul class='menu-vertical'>";
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

        <i class="icon-magnifying-glass search-icon" id="searchIcon"></i>
        <div class="search-box">
            <i class="icon-magnifying-glass search-icon"></i>
            <input type="search" id="search" placeholder="Buscar . . ." class="form-control me-2">
        </div>
    </nav>
</body>

</html>