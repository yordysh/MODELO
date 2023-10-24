<?php
require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

$anioSeleccionado = $_GET['anio'];
$mesSeleccionado = $_GET['mes'];

$mostrar = new m_almacen();
$nombre = 'LBS-PHS-FR-02';
// $versionMuestraFecha = $mostrar->MostrarVersionGeneralFecha($nombre);
// $fechaDateTime = new DateTime($versionMuestraFecha);
// $anio = $fechaDateTime->format('Y');
// $mesExtra = intval($fechaDateTime->format('m'));
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
// $mesversion = $mesesEnLetras[$mesExtra];


$datos = $mostrar->MostrarPreparacionSolucionPDF($anioSeleccionado, $mesSeleccionado);
// $versionMuestra = $mostrar->VersionMostrar();
// $versionMuestra = $mostrar->MostrarVersionGeneral($nombre);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="http://192.168.1.102/SISTEMA/control_alimento/images/icon/covifarma-ico.ico" type="images/png">
    <title>Preparación y soluciones</title>
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
            font-weight: 200;
            font-size: 20px;
        }

        .cabecera-valores {
            background-color: #cee6ba;
            text-align: center;
            font-weight: 200;
            font-size: 20px;
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

        .tdFecha::after {
            content: '';
            position: absolute;
            width: 120px;
            height: 0.5px;
            background-color: black;
            margin-top: 15px;
        }

        body {
            margin: 40mm 8mm 2mm 8mm;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        .cabeceraPreparacion {
            text-align: center;
            max-width: 10px;
        }
    </style>
    <!-- Table titulo-->
    <header>
        <table>
            <tbody>
                <tr>
                    <td rowspan="4" class="cabecera"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/logo-covifarmaRecorte.png')); ?>" alt=""></td>
                    <!-- <td rowspan="4" class="cabecera"><img src="http://192.168.1.102/SISTEMA/control_alimento/images/logo-covifarmaRecorte.png" alt=""></td> -->
                    <td rowspan="4" style="text-align: center; font-size:25px; font-weigth:200;">PREPARACIÓN DE SOLUCIÓN DE LIMPIEZA Y DESINFECCIÓN - <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                    <td>LBS-PHS-FR-02</td>

                </tr>
                <tr>
                    <!-- <td>Versión: <?php echo $versionMuestra ?> </td> -->
                </tr>
                <tr>
                    <td>Página:</td>
                </tr>

                <tr>
                    <!-- <td>Fecha: <?php echo ($mesversion . ' ' . $anio); ?> </td> -->
                </tr>


            </tbody>
        </table>
    </header>

    <!-- Table solucion y preparaciones-->
    <table style="margin-top: 10px;">
        <thead>
            <tr>
                <th rowspan='4' class="cabecera-fila">FECHA DE PREPARACIÓN</th>
                <th colspan="10" class="cabecera-fila">Detergente</th>
                <th colspan="18" class="cabecera-fila">Desinfectante</th>
                <th rowspan="6" class="cabecera-fila">RESPONSABLE DE LA EJECUCIÓN</th>
            </tr>
            <tr>
                <th colspan="3" class="cabecera-fila">Alcalino</th>
                <th colspan="3" class="cabecera-fila">Ácido</th>
                <th colspan="4" class="cabecera-fila">En polvo</th>
                <th colspan="15" class="cabecera-fila">Hipoclorito de Sodio 7.5%</th>
                <th colspan="3" class="cabecera-fila">Amonio cuaternario 11.59%</th>
            </tr>
            <tr>
                <th colspan="3" class="cabecera-valores">5%</th>
                <th colspan="3" class="cabecera-valores">3.90%</th>
                <th colspan="4" rowspan="2" class="cabecera-valores">N° de preparaciones</th>
                <th colspan="3" class="cabecera-valores">50 ppm</th>
                <th colspan="3" class="cabecera-valores">100 ppm</th>
                <th colspan="3" class="cabecera-valores">200 ppm</th>
                <th colspan="3" class="cabecera-valores">300 ppm</th>
                <th colspan="3" class="cabecera-valores">400 ppm</th>
                <th colspan="3" class="cabecera-valores">200 ppm</th>
            </tr>
            <tr>
                <th colspan="6" class="cabecera-valores">N° de preparaciones</th>
                <th colspan="15" class="cabecera-valores">N° de preparaciones</th>
                <th colspan="3" class="cabecera-valores">N° de preparaciones</th>
            </tr>
            <tr>
                <th class="cabecera-fila">Hipoclorito de Sodio/Detergente/Desinfectante</th>
                <th class="cabecera-valores">50ml</th>
                <th class="cabecera-valores">250ml</th>
                <th class="cabecera-valores">500ml</th>
                <th class="cabecera-valores">39ml</th>
                <th class="cabecera-valores">195ml</th>
                <th class="cabecera-valores">390ml</th>
                <th class="cabecera-valores">75g</th>
                <th class="cabecera-valores">150g</th>
                <th class="cabecera-valores">300g</th>
                <th class="cabecera-valores">400g</th>
                <th class="cabecera-valores">0.7ml </th>
                <th class="cabecera-valores">3.3ml</th>
                <th class="cabecera-valores">6.7ml</th>
                <th class="cabecera-valores">1.3ml</th>
                <th class="cabecera-valores">6.7ml</th>
                <th class="cabecera-valores">13.3ml</th>
                <th class="cabecera-valores">2.7ml</th>
                <th class="cabecera-valores">13.3ml</th>
                <th class="cabecera-valores">26.7ml</th>
                <th class="cabecera-valores">4ml</th>
                <th class="cabecera-valores">20ml</th>
                <th class="cabecera-valores">40ml</th>
                <th class="cabecera-valores">5.3ml</th>
                <th class="cabecera-valores">26.7ml</th>
                <th class="cabecera-valores">53.3ml</th>
                <th class="cabecera-valores">1.7ml</th>
                <th class="cabecera-valores">8.6ml</th>
                <th class="cabecera-valores">17.2ml</th>
            </tr>
            <tr>
                <th class="cabecera-fila">Agua(L)</th>
                <th class="cabecera-valores">1L</th>
                <th class="cabecera-valores">5L</th>
                <th class="cabecera-valores">10L</th>
                <th class="cabecera-valores">1L</th>
                <th class="cabecera-valores">5L</th>
                <th class="cabecera-valores">10L</th>
                <th class="cabecera-valores">5L</th>
                <th class="cabecera-valores">10L</th>
                <th class="cabecera-valores">20L</th>
                <th class="cabecera-valores">40L</th>
                <th class="cabecera-valores">1L</th>
                <th class="cabecera-valores">5L</th>
                <th class="cabecera-valores">10L</th>
                <th class="cabecera-valores">1L</th>
                <th class="cabecera-valores">5L</th>
                <th class="cabecera-valores">10L</th>
                <th class="cabecera-valores">1L</th>
                <th class="cabecera-valores">5L</th>
                <th class="cabecera-valores">10L</th>
                <th class="cabecera-valores">1L</th>
                <th class="cabecera-valores">5L</th>
                <th class="cabecera-valores">10L</th>
                <th class="cabecera-valores">1L</th>
                <th class="cabecera-valores">5L</th>
                <th class="cabecera-valores">10L</th>
                <th class="cabecera-valores">1L</th>
                <th class="cabecera-valores">5L</th>
                <th class="cabecera-valores">10L</th>
            </tr>
        </thead>
        <?php
        $contadorN = 0;

        foreach ($datos as $filas) {
            if (isset($filas['CANTIDAD_DIFERENTE'])) {
                $valordiferente = intval($filas['CANTIDAD_DIFERENTE']);
                $multiplo = ($valordiferente % 5);
                $multiplo1 = ($valordiferente % 10);
            }
            $porcentaje = $filas['CANTIDAD_PORCENTAJE'];
            $contadorN++;
            echo '<tbody>';
            echo '<tr>';
            // echo '<td style="text-align:center;">' . convFecSistema($filas['FECHA']) . '</td>';
            echo '<td></td>';
            $arreglo = [0, 0, 0];
            $r = 1;
            while ($r <= 3) {
                if ($valordiferente >= 10) {
                    $valordiferente = $valordiferente % 10;
                    $arreglo[2] = 1;
                } elseif ($valordiferente >= 5) {
                    $valordiferente = $valordiferente % 5;
                    $arreglo[1] = 1;
                } elseif ($valordiferente >= 1) {
                    $arreglo[0] = 1;
                }
                $r++;
            }
            for ($i = 0; $i < 28; $i++) {

                if ($i == 0 && $filas['CANTIDAD_MILILITROS'] == '50ml') {
                    for ($j = 0; $j < count($arreglo); $j++) {
                        if ($arreglo[$j] == 1) {
                            echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                        } else {
                            echo '<td class="cabeceraPreparacion" style="text-align:center;"></td>';
                        }
                    }
                    // if ($filas['CANTIDAD_MILILITROS'] == '50ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // }
                    // elseif ($porcentaje == '5%') {
                    //     if (($valordiferente > 1 && $valordiferente < 5) || $multiplo > 0 && $multiplo < 5) {
                    //         echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    //     }
                    // }
                } else if ($i == 1 && $filas['CANTIDAD_MILILITROS'] == '250ml') {
                    // if ($filas['CANTIDAD_MILILITROS'] == '250ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // }
                    //  elseif ($porcentaje == '5%') {
                    //     if (($valordiferente > 5 && $valordiferente < 10) || $multiplo > 0 && $multiplo < 5 || $multiplo1 >= 5 && $multiplo1 < 10) {
                    //         echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    //     }
                    // }
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 2 && $filas['CANTIDAD_MILILITROS'] == '500ml') {
                    // if ($filas['CANTIDAD_MILILITROS'] == '500ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // }
                    //  elseif ($porcentaje == '5%') {

                    //     if (($valordiferente > 10) || $multiplo1 == 0) {
                    //         echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    //     }
                    // }
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 3 && $filas['CANTIDAD_MILILITROS'] == '39ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 4 && $filas['CANTIDAD_MILILITROS'] == '195ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 5 && $filas['CANTIDAD_MILILITROS'] == '390ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 6 && $filas['CANTIDAD_MILILITROS'] == '75g') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 7 && $filas['CANTIDAD_MILILITROS'] == '150g') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 8 && $filas['CANTIDAD_MILILITROS'] == '300g') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 9 && $filas['CANTIDAD_MILILITROS'] == '400g') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 10 && $filas['CANTIDAD_MILILITROS'] == '0.7ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 11 && $filas['CANTIDAD_MILILITROS'] == '3.3ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 12 && $filas['CANTIDAD_MILILITROS'] == '6.7ml' && $filas['CANTIDAD_LITROS'] == '10L') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 13 && $filas['CANTIDAD_MILILITROS'] == '1.3ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 14 && $filas['CANTIDAD_MILILITROS'] == '6.7ml' && $filas['CANTIDAD_LITROS'] == '5L') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 15 && $filas['CANTIDAD_MILILITROS'] == '13.3ml' && $filas['CANTIDAD_LITROS'] == '10L') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 16 && $filas['CANTIDAD_MILILITROS'] == '2.7ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 17 && $filas['CANTIDAD_MILILITROS'] == '13.3ml' && $filas['CANTIDAD_LITROS'] == '5L') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 18 && $filas['CANTIDAD_MILILITROS'] == '26.7ml' && $filas['CANTIDAD_LITROS'] == '10L') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 19 && $filas['CANTIDAD_MILILITROS'] == '4ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 20 && $filas['CANTIDAD_MILILITROS'] == '20ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 21 && $filas['CANTIDAD_MILILITROS'] == '40ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 22 && $filas['CANTIDAD_MILILITROS'] == '5.3ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 23 && $filas['CANTIDAD_MILILITROS'] == '26.7ml' && $filas['CANTIDAD_LITROS'] == '5L') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 24 && $filas['CANTIDAD_MILILITROS'] == '53.3ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 25 && $filas['CANTIDAD_MILILITROS'] == '1.7ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 26 && $filas['CANTIDAD_MILILITROS'] == '8.6ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else if ($i == 27 && $filas['CANTIDAD_MILILITROS'] == '17.2ml') {
                    echo '<td class="cabeceraPreparacion"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                    // echo '<td class="cabeceraPreparacion" ><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt=""></td>';
                } else {
                    echo '<td class="cabeceraPreparacion" style="text-align:center;"></td>';
                }
            }

            echo '<td style="text-align:center;">USUARIO</td>';
            echo '</tr>';
            if ($contadorN % 26 == 0) {
                // if ($contadorN % 15 == 0) {
                echo '<tr>';
                for ($i = 0; $i < 30; $i++) {
                    echo '<td style="text-align:center;height:10.5rem;border-left:none; border:rght:none;"></td>';
                }
                echo '</tr>';
            }
            if ($contadorN % count($datos) == 0) {
                echo '<tr>';
                for ($i = 0; $i < 30; $i++) {
                    echo '<td style="text-align:center;height:20rem;border-left:none; border:right:none;"></td>';
                }
                echo '</tr>';
            }
            echo '</tbody>';
        }

        // printf('<tr><td>Total de filas: ' . count($datos) . '</td></tr>');
        ?>


    </table>
    <!-- Table Observacion y otros-->
    <table style="margin-top: 5px;">
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
            <td style="padding-left: 500px; border:none;"></td>
            <td style="padding-left: 200px; border:none;"></td>
            <td style="padding-left: 200px; border-left: none; border-bottom:none; border-right: none; font-weight: 300; font-size:17px;">JEFE DE ASEGURAMIENTO DE LA CALIDAD</td>
            <td style="padding-left: 700px; border:none;"></td>
        </tr>
        <tr>
            <td style="padding-left: 500px; border:none;"></td>
            <td style="padding-left: 200px; border:none;"></td>
            <td class="tdFecha" style="margin-top:10px; padding-left: 300px; border:0; display:inline-block; font-weight: 300; font-size:17px;">Fecha: </td>
            <td style="padding-left: 700px; border:none;"></td>
        </tr>
    </table>
</body>

</html>