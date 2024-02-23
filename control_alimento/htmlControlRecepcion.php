<?php
require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

$anioSeleccionado = $_GET['anio'];
$mesSeleccionado = $_GET['mes'];

$mostrar = new m_almacen();
$nombre = 'LBS-BPM-Fr-09';
$versionMuestraFecha = $mostrar->MostrarVersionGeneralFecha($nombre);
$fechaDateTime = new DateTime($versionMuestraFecha);
$anio = $fechaDateTime->format('Y');
$mesExtra = intval($fechaDateTime->format('m'));
// /*convierte el valor en enetero*/
// $mesNumerico = intval($mesSeleccionado);

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
// $mesConvert = $mesesEnLetras[$mesNumerico];
$mesversion = $mesesEnLetras[$mesExtra];


$datos = $mostrar->MostrarControlRecepcionPDF($anioSeleccionado, $mesSeleccionado);
$datosobservacion = $mostrar->MostrarControlRecepcionObservacionPDF($anioSeleccionado, $mesSeleccionado);
// $versionMuestra = $mostrar->VersionMostrar();
$versionMuestra = $mostrar->MostrarVersionGeneral($nombre);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="http://192.168.1.102/SISTEMA/control_alimento/images/icon/covifarma-ico.ico" type="images/png">
    <title>Control y recepcion</title>
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

        .columnafecha:nth-child(1) {
            width: 90px;
        }

        .columnarequerimiento:nth-child(2) {
            width: 80px;
        }

        .columnacodigo:nth-child(4) {
            width: 80px;
        }

        .columnaproveedor:nth-child(6) {
            width: 110px;
        }

        .columnafv:nth-child(7) {
            width: 90px !important;
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

        .checkmark {
            color: green;
            font-size: 20px;
        }

        .cross {
            color: red;
            font-size: 20px;
        }

        .imagen {
            text-align: center;
        }

        /* .vertical-text {
            writing-mode: vertical-lr;
            margin-right: -40px;
            margin-top: 100px;
            transform: rotate(270deg);

        } */
    </style>
    <!-- Table titulo-->
    <header>
        <table>
            <tbody>
                <tr>
                    <td rowspan="4" class="cabecera"><img style="text-align: center; width:160px; height:90px;" src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/img_lab.jpg')); ?>" alt=""></td>
                    <td rowspan="4" style="text-align: center; font-size:25px; font-weight:200;"> CONTROL DE RECEPCIÓN DE MATERIA PRIMA E INSUMOS </td>
                    <td>Código: LBS-BPM-FR-09</td>

                </tr>
                <tr>
                    <td>Versión: <?php echo $versionMuestra ?> </td>
                    <!-- <td>Versión: </td> -->
                </tr>
                <tr>
                    <td>Página:</td>
                </tr>

                <tr>
                    <td>Fecha: <?php echo ($mesversion . ' ' . $anio); ?> </td>
                    <!-- <td>Fecha:</td> -->
                </tr>


            </tbody>
        </table>
    </header>

    <!-- Table solucion y preparaciones-->
    <table style="margin-top: 10px; margin-bottom:20px;">
        <thead>
            <tr>
                <th rowspan="2" class="columnafecha">FECHA DE INGRESO</th>
                <th rowspan="2" class="columnarequerimiento">REQUERIMIENTO</th>
                <th rowspan="2" class="columnahora">HORA</th>
                <th rowspan="2" class="columnacodigo">CODIGO INTERNO</th>
                <th rowspan="2">PRODUCTO</th>
                <th rowspan="2" class="columnacodigo">CÓDIGO DE LOTE</th>
                <th rowspan="2" class="columnafv">F.V</th>
                <th rowspan="2" class="columnaproveedor">PROVEEDOR</th>
                <th colspan="3" class="columnap">GUÍA/BOLETA/ FACTURA</th>
                <th rowspan="2">N° GUÍA,BOLETA O FACTURA</th>
                <th colspan="2">Empaque</th>
                <th colspan="4">Presentación</th>
                <th rowspan="2">CANTIDAD (kg)</th>
                <th colspan="3">CONTROL DEL PRODUCTO</th>
                <th colspan="3">DEL PERSONAL DE TRANSPORTE</th>
                <th colspan="4">CONDICIONES DEL TRANSPORTE</th>
                <th rowspan="2" class="">V°B°</th>
            </tr>
            <tr>
                <th> <label for="" class="vertical-text">G.Remisión</label></th>
                <th class="">Boleta</th>
                <th class="">Factura</th>
                <th class="">Primario</th>
                <th class="">Secundario</th>
                <th class="">Saco</th>
                <th class="">Caja</th>
                <th class="">Cilindro</th>
                <th class="">bolsa</th>
                <th class="">Envase integro/ hermético</th>
                <th class="">Certificado de calidad</th>
                <th class="">Rotulación conforme</th>
                <th class="">Aplicación de las BPD</th>
                <th class="">Higiene & salud</th>
                <th class="">Indumentaria completa y limpia</th>
                <th class="">Limpio</th>
                <th class="">Exclusivo</th>
                <th class="">Hermético</th>
                <th class="">Ausencia de plagas</th>
            </tr>
        </thead>
        <?php $contadorF = -1; ?>

        <tbody>
            <?php
            foreach ($datos as $dato) {
                $requer = "RQ-" . (intval($dato['COD_REQUERIMIENTO']));

                $contadorF++;
                if ($contadorF == 37) {
                    echo '<tr style="page-break-before: always;">';
                } elseif ($contadorF > 37 && $contadorF % 37 == 0) {
                    echo '<tr style="page-break-before: always;">';
                } else {
                    echo '<tr>';
                }

                // echo '<tr>';
                echo '<td>' . $dato['FECHA_INGRESO'] . '</td>';
                echo '<td style="text-align:center;">' . $requer . '</td>';
                echo '<td style="text-align:center;">' . $dato['HORA'] . '</td>';
                echo '<td style="text-align:center;">' . $dato['COD_PRODUCCION'] . '</td>';
                echo '<td>' . $dato['DES_PRODUCTO'] . '</td>';
                echo '<td>' . $dato['CODIGO_LOTE'] . '</td>';
                echo '<td>' . $dato['FECHA_VENCIMIENTO'] . '</td>';
                echo '<td>' . $dato['NOM_PROVEEDOR'] . '</td>';
                if ($dato['GUIA'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td></td>';
                }
                if ($dato['BOLETA'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td></td>';
                }
                if ($dato['FACTURA'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td></td>';
                }
                echo '<td>' . $dato['GBF'] . '</td>';
                if ($dato['PRIMARIO'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td></td>';
                }
                if ($dato['SECUNDARIO'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td></td>';
                }
                if ($dato['SACO'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td></td>';
                }
                if ($dato['CAJA'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td></td>';
                }
                if ($dato['CILINDRO'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td></td>';
                }
                if ($dato['BOLSA'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td></td>';
                }
                echo '<td style="text-align:center;">' . $dato['CANTIDAD_MINIMA'] . '</td>';
                if ($dato['ENVASE'] == 'C') {
                    echo '<td class="imagen" style="width:30px!important;"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/aspa.png')) . '" alt=""></td>';
                }
                if ($dato['CERTIFICADO'] == 'C') {
                    echo '<td class="imagen" style="width:40px!important;"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/aspa.png')) . '" alt=""></td>';
                }
                if ($dato['ROTULACION'] == 'C') {
                    echo '<td class="imagen" style="width:45px!important;"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/aspa.png')) . '" alt=""></td>';
                }
                if ($dato['APLICACION'] == 'C') {
                    echo '<td class="imagen" ><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/aspa.png')) . '" alt=""></td>';
                }
                if ($dato['HIGIENE'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/aspa.png')) . '" alt=""></td>';
                }
                if ($dato['INDUMENTARIA'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/aspa.png')) . '" alt=""></td>';
                }
                if ($dato['LIMPIO'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/aspa.png')) . '" alt=""></td>';
                }
                if ($dato['EXCLUSIVO'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/aspa.png')) . '" alt=""></td>';
                }
                if ($dato['HERMETICO'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/aspa.png')) . '" alt=""></td>';
                }
                if ($dato['AUSENCIA'] == 'C') {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/check.png')) . '" alt=""></td>';
                } else {
                    echo '<td class="imagen"><img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/aspa.png')) . '" alt=""></td>';
                }
                echo '<td></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <!-- tabla de instrucciones-->
    <table style="margin-bottom: 20px;">
        <tr>
            <td style="border:none;"><strong>Colocar:Conforme:</strong><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/checkobs.png')); ?>" alt="">,
                <strong>No Conforme:</strong> <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/aspaobs.png')); ?>" alt="">, <strong>Frecuencia:</strong> Cada recepción de materia,insumos,envases y embalajes.
                Indumentaria de la empresa:Polo,camisa o casaca de la empresa,mascarilla.
                Salud: Sin enfermedades, sin cortes o heridas,
                Higiene: Cabello corto, rasurado,uñas cortas, sin objetos(anillos,aretes,etc)
            </td>
        </tr>
        <tr>
            <td style="border:none;padding-left: 85px;"><strong>ACCIÓN CORRECTIVA:</strong> Al detectar incumplimiento se procederá a corregir la observación.</td>
        </tr>
    </table>
    <!-------------------------->
    <!-- Table Observacion y otros-->
    <?php
    if (count($datosobservacion) > 0) {

        echo "<table style='margin-top: 5px;'>";
        echo "<thead>";
        echo " <tr>";
        echo "<th>FECHA</th>";
        echo "<th>OBSERVACIÓN</th>";
        echo "<th>ACCIONES CORRECTIVA</th>";
        echo "<th>SUPERVISADO POR:</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($datosobservacion as $fils) {
            echo '<tr>';
            echo '<td class="cabecera">' . convFecSistema($fils['FECHA']) . '</td>';
            echo '<td class="cabecera">' . $fils['OBSERVACION'] . '</td>';
            echo '<td class="cabecera">' . $fils['ACCION_CORRECTIVA'] . '</td>';
            // echo '<td class="cabecera">' . $fils['VERIFICACION'] . '</td>';
            echo '<td></td>';
            echo '</tr>';
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<table style='margin-top: 5px;'>";
        echo "<thead>";
        echo " <tr>";
        echo "<th>FECHA</th>";
        echo "<th>OBSERVACIÓN</th>";
        echo "<th>ACCIONES CORRECTIVA</th>";
        echo "<th>SUPERVISADO POR:</th>";
        echo "</tr>";
        echo "</thead>";
        echo "</table>";
    }
    ?>


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