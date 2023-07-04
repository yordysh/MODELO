<?php
require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

$anioSeleccionado = $_GET['anio'];
$mesSeleccionado = $_GET['mes'];
/*convierte el valor en enetero*/
$mesNumerico = intval($mesSeleccionado);

$mesesEnLetras = array(
    1 => "ENERO",
    2 => "FEBRERO",
    3 => "MARZO",
    4 => "ABRIL",
    5 => "MAYO",
    6 => "JUNIO",
    7 => "JULIO",
    8 => "AGOSTO",
    9 => "SETIEMBRE",
    10 => "OCTUBRE",
    11 => "NOVIEMBRE",
    12 => "DICIEMBRE",
);
$mesConvert = $mesesEnLetras[$mesNumerico];

$mostrar = new m_almacen();
$datos = $mostrar->MostrarPreparacionSolucionPDF($anioSeleccionado, $mesSeleccionado);
$versionMuestra = $mostrar->VersionMostrar();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preparacion y soluciones</title>
</head>

<body>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            width: 100%;
        }

        thead th {
            border: 1px solid black;
        }

        tbody td {
            border: 1px solid black;
        }

        .cabecera-fila {
            background-color: #EEB4F5;
            text-align: center;
        }

        .cabecera-valores {
            background-color: #cee6ba;
            text-align: center;
        }

        .cabecera-fila td,
        .cabecera {
            text-align: center;
        }

        .column-1:nth-child(1),
        .column-2:nth-child(2) {
            width: 320px;

        }

        .mover-derecha {
            padding-left: 20px;
        }

        td.cabecera-fila {
            width: 30px;
            height: 30px;
        }
    </style>
    <!-- Table titulo-->
    <table style="margin-bottom: 50px;">
        <tbody>
            <tr>
                <td rowspan="4" class="cabecera"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/MASTER/images/logo-covifarmaRecorte.png" alt=""></td>
                <td rowspan="4" style="text-align: center;">PREPARACIÓN DE SOLUCIÓN DE LIMPIEZA Y DESINFECCIÓN - <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                <td>LBS-PHS-FR-02</td>

            </tr>
            <tr>
                <?php foreach ($versionMuestra as $version) { ?>
                    <td>Versión: <?php echo $version['VERSION'] ?> </td>
                <?php
                }
                ?>

            </tr>
            <tr>
                <td>Página:01</td>
            </tr>
            <tr>
                <td>Fecha: <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
            </tr>


        </tbody>
    </table>

    <!-- Table solucion y preparaciones-->
    <table>
        <tbody>

            <tr>
                <td rowspan='4' class="cabecera-fila">FECHA DE PREPARACIÓN</td>
                <td colspan="10" class="cabecera-fila">Detergente</td>
                <td colspan="18" class="cabecera-fila">Desinfectante</td>
                <td rowspan="6" class="cabecera-fila">RESPONSABLE DE LA EJECUCIÓN</td>
            </tr>
            <tr>
                <td colspan="3" class="cabecera-fila">Alcalino</td>
                <td colspan="3" class="cabecera-fila">Ácido</td>
                <td colspan="4" class="cabecera-fila">En polvo</td>
                <td colspan="15" class="cabecera-fila">Hipoclorito de Sodio 7.5%</td>
                <td colspan="3" class="cabecera-fila">Amonio cuaternario 11.59%</td>
            </tr>
            <tr>
                <td colspan="3" class="cabecera-valores">5%</td>
                <td colspan="3" class="cabecera-valores">3.90%</td>
                <td colspan="4" rowspan="2" class="cabecera-valores">N° de preparaciones</td>
                <td colspan="3" class="cabecera-valores">50 ppm</td>
                <td colspan="3" class="cabecera-valores">100 ppm</td>
                <td colspan="3" class="cabecera-valores">200 ppm</td>
                <td colspan="3" class="cabecera-valores">300 ppm</td>
                <td colspan="3" class="cabecera-valores">400 ppm</td>
                <td colspan="3" class="cabecera-valores">200 ppm</td>
            </tr>
            <tr>
                <td colspan="6" class="cabecera-valores">N° de preparaciones</td>
                <td colspan="15" class="cabecera-valores">N° de preparaciones</td>
                <td colspan="3" class="cabecera-valores">N° de preparaciones</td>
            </tr>
            <tr>
                <td class="cabecera-fila">Hipoclorito de Sodio/Detergente/Desinfectante</td>
                <td class="cabecera-valores">50ml</td>
                <td class="cabecera-valores">250ml</td>
                <td class="cabecera-valores">500ml</td>
                <td class="cabecera-valores">39ml</td>
                <td class="cabecera-valores">195ml</td>
                <td class="cabecera-valores">390ml</td>
                <td class="cabecera-valores">75g</td>
                <td class="cabecera-valores">150g</td>
                <td class="cabecera-valores">300g</td>
                <td class="cabecera-valores">400g</td>
                <td class="cabecera-valores">0.7ml </td>
                <td class="cabecera-valores">3.3ml</td>
                <td class="cabecera-valores">6.7ml</td>
                <td class="cabecera-valores">1.3ml</td>
                <td class="cabecera-valores">6.7ml</td>
                <td class="cabecera-valores">13.3ml</td>
                <td class="cabecera-valores">2.7ml</td>
                <td class="cabecera-valores">13.3ml</td>
                <td class="cabecera-valores">26.7ml</td>
                <td class="cabecera-valores">4ml</td>
                <td class="cabecera-valores">20ml</td>
                <td class="cabecera-valores">40ml</td>
                <td class="cabecera-valores">5.3ml</td>
                <td class="cabecera-valores">26.7ml</td>
                <td class="cabecera-valores">53.3ml</td>
                <td class="cabecera-valores">1.7ml</td>
                <td class="cabecera-valores">8.6ml</td>
                <td class="cabecera-valores">17.2ml</td>
            </tr>
            <tr>
                <td class="cabecera-fila">Agua(L)</td>
                <td class="cabecera-valores">1L</td>
                <td class="cabecera-valores">5L</td>
                <td class="cabecera-valores">10L</td>
                <td class="cabecera-valores">1L</td>
                <td class="cabecera-valores">5L</td>
                <td class="cabecera-valores">10L</td>
                <td class="cabecera-valores">5L</td>
                <td class="cabecera-valores">10L</td>
                <td class="cabecera-valores">20L</td>
                <td class="cabecera-valores">40L</td>
                <td class="cabecera-valores">1L</td>
                <td class="cabecera-valores">5L</td>
                <td class="cabecera-valores">10L</td>
                <td class="cabecera-valores">1L</td>
                <td class="cabecera-valores">5L</td>
                <td class="cabecera-valores">10L</td>
                <td class="cabecera-valores">1L</td>
                <td class="cabecera-valores">5L</td>
                <td class="cabecera-valores">10L</td>
                <td class="cabecera-valores">1L</td>
                <td class="cabecera-valores">5L</td>
                <td class="cabecera-valores">10L</td>
                <td class="cabecera-valores">1L</td>
                <td class="cabecera-valores">5L</td>
                <td class="cabecera-valores">10L</td>
                <td class="cabecera-valores">1L</td>
                <td class="cabecera-valores">5L</td>
                <td class="cabecera-valores">10L</td>
            </tr>
            <?php
            foreach ($datos as $filas) {
                echo '<tr>';
                echo '<td style="text-align:center;">' . convFecSistema($filas['FECHA']) . '</td>';
                for ($i = 0; $i < 28; $i++) {
                    if ($i == 0 && $filas['CANTIDAD_MILILITROS'] == '50ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 1 && $filas['CANTIDAD_MILILITROS'] == '250ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 2 && $filas['CANTIDAD_MILILITROS'] == '500ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 3 && $filas['CANTIDAD_MILILITROS'] == '39ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 4 && $filas['CANTIDAD_MILILITROS'] == '195ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 5 && $filas['CANTIDAD_MILILITROS'] == '390ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 6 && $filas['CANTIDAD_MILILITROS'] == '75g') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 7 && $filas['CANTIDAD_MILILITROS'] == '150g') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 8 && $filas['CANTIDAD_MILILITROS'] == '300g') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 9 && $filas['CANTIDAD_MILILITROS'] == '400g') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 10 && $filas['CANTIDAD_MILILITROS'] == '0.7ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 11 && $filas['CANTIDAD_MILILITROS'] == '3.3ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 12 && $filas['CANTIDAD_MILILITROS'] == '6.7ml' && $filas['CANTIDAD_LITROS'] == '10L') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 13 && $filas['CANTIDAD_MILILITROS'] == '1.3ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 14 && $filas['CANTIDAD_MILILITROS'] == '6.7ml' && $filas['CANTIDAD_LITROS'] == '5L') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 15 && $filas['CANTIDAD_MILILITROS'] == '13.3ml' && $filas['CANTIDAD_LITROS'] == '10L') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 16 && $filas['CANTIDAD_MILILITROS'] == '2.7ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 17 && $filas['CANTIDAD_MILILITROS'] == '13.3ml' && $filas['CANTIDAD_LITROS'] == '5L') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 18 && $filas['CANTIDAD_MILILITROS'] == '26.7ml' && $filas['CANTIDAD_LITROS'] == '10L') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 19 && $filas['CANTIDAD_MILILITROS'] == '4ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 20 && $filas['CANTIDAD_MILILITROS'] == '20ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 21 && $filas['CANTIDAD_MILILITROS'] == '40ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 22 && $filas['CANTIDAD_MILILITROS'] == '5.3ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 23 && $filas['CANTIDAD_MILILITROS'] == '26.7ml' && $filas['CANTIDAD_LITROS'] == '5L') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 24 && $filas['CANTIDAD_MILILITROS'] == '53.3ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 25 && $filas['CANTIDAD_MILILITROS'] == '1.7ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 26 && $filas['CANTIDAD_MILILITROS'] == '8.6ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else if ($i == 27 && $filas['CANTIDAD_MILILITROS'] == '17.2ml') {
                        echo '<td style="text-align:center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/MASTER/images/check.png" alt=""></td>';
                    } else {
                        echo '<td style="text-align:center;"></td>';
                    }
                }
                echo '<td style="text-align:center;">USUARIO</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <!-- Table Observacion y otros-->
    <table style="margin-top: 50px;">
        <thead>
            <tr>

                <th>FECHA</th>
                <th>OBSERVACIONES</th>
                <th>ACCIONES CORRECTIVAS</th>
                <th>VERIFICACION</th>
                <th>V°B°</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($datos as $fils) {
                echo '<tr>';
                echo '<td class="cabecera">' . convFecSistema($fils['FECHA']) . '</td>';
                echo '<td class="cabecera">' . $fils['OBSERVACION'] . '</td>';
                echo '<td class="cabecera">' . $fils['ACCION_CORRECTIVA'] . '</td>';
                echo '<td class="cabecera">' . $fils['VERIFICACION'] . '</td>';
                echo '<td></td>';
                echo '</tr>';
            }
            ?>

        </tbody>
    </table>
    <!-- Table firma y fecha-->
    <table style="margin-top: 50px; border:none;">
        <tr>
            <td style="padding-left: 200px; border:none;"></td>
            <td style="border: none;"></td>
            <td style="padding-left: 400px; border:none;">Fecha:</td>
            <td style="padding-left: 400px; border:none;"></td>
            <td style="padding-left: 800px; border:none;"></td>

        </tr>
        <tr>
            <td style="padding-left: 200px; border:none;"></td>
            <td style="border-left: none; border-bottom:none; border-right: none;">Firma del jefe de Aseguramiento de la calidad</td>
            <td style="padding-left: 400px; border:none;"></td>
            <td style="padding-left: 400px;border-left: none; border-bottom:none; border-right: none;"></td>
            <td style="padding-left: 800px; border:none;"></td>

        </tr>
    </table>
</body>

</html>