<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Lima');
require_once("m_menu.php");
require_once("./funciones/f_funcion.php");

/*$permisos = new c_permisosmenu();
    session_start();
    $permisos->c_permisos('9002');*/

class c_permisosmenu
{
    public function c_permisos($anexo)
    {
        $menu_c = array();
        $sub_c = array();
        $subSub_c = array();
        $contM = 0;
        $m_login = new m_menu();

        $contS = 0;
        $contS2 = 0;
        $Arrmenu_c = array();
        $ArrSubmenu_c = array();
        $ArrSubmenu2_c = array();
        $permisos_c = $m_login->m_permisos($anexo);
        if (count($permisos_c) > 0) {
            for ($i = 0; $i < count($permisos_c); $i++) {
                if (!in_array($permisos_c[$i][2], $Arrmenu_c)) {
                    array_push($Arrmenu_c, $permisos_c[$i][2]);
                    $cabmenu = $m_login->m_listarmenu($permisos_c[$i][2]);

                    for ($l = 0; $l < count($cabmenu); $l++) {
                        $menu_c[$contM] = [$cabmenu[$l][0], $cabmenu[$l][1], $cabmenu[$l][2]];
                        $contM++;
                    }
                }

                if (!in_array(array($permisos_c[$i][2], $permisos_c[$i][3]), $ArrSubmenu_c)) {
                    array_push($ArrSubmenu_c, array($permisos_c[$i][2], $permisos_c[$i][3]));
                    $submenu = $m_login->m_listasubmenus($permisos_c[$i][2], $permisos_c[$i][3]);
                    for ($k = 0; $k < count($submenu); $k++) {
                        $sub_c[$contS] = [$submenu[$k][1], $submenu[$k][3], $submenu[$k][4], $submenu[$k][2]];
                        $contS++;
                    }
                }

                if (!in_array(array($permisos_c[$i][2], $permisos_c[$i][3], $permisos_c[$i][4]), $ArrSubmenu2_c)) {
                    array_push($ArrSubmenu2_c, array($permisos_c[$i][2], $permisos_c[$i][3], $permisos_c[$i][4]));
                    $submenu2 = $m_login->m_listasubmenus2($permisos_c[$i][2], $permisos_c[$i][3], $permisos_c[$i][4]);

                    for ($j = 0; $j < count($submenu2); $j++) {
                        $subSub_c[$contS2] = [$submenu2[$j][0], $submenu2[$j][1], $submenu2[$j][1], $submenu2[$j][3], $submenu2[$j][4]];
                        $contS2++;
                    }
                }
            }

            session_start();
            $_SESSION["menu_c"] = $menu_c;
            $_SESSION["submenu_c"] = $sub_c;
            $_SESSION["subsub_c"] = $subSub_c;

            // echo "<script>location.href='menu/index.php';</script>";
            header('Location: principal/index.php');
            exit;
        } else {
            print_r("No tiene permiso");
        }
    }
}
