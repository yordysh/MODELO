<?php
ob_start();
?>
<?php
require_once "../php/m_almacen.php";

$anioSeleccionado = $_GET['anio'];
$mesSeleccionado = $_GET['mes'];
/*convierte el valor en enetero*/
$mesNumerico = intval($mesSeleccionado);

$mesesEnLetras = array(
    1 => "Enero",
    2 => "Febrero",
    3 => "Marzo",
    4 => "Abril",
    5 => "Mayo",
    6 => "Junio",
    7 => "Julio",
    8 => "Agosto",
    9 => "Setiembre",
    10 => "Octubre",
    11 => "Noviembre",
    12 => "Diciembre",
);
$mesConvert = $mesesEnLetras[$mesNumerico];

$mostrar = new m_almacen();
// $datos = $mostrar->MostrarAlertapd();
$datos = $mostrar->MostrarInfraestructuraPDF($anioSeleccionado, $mesSeleccionado);
$versionMuestra = $mostrar->VersionMostrar();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
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
            background-color: #9dcdec;
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

        td.estado-vacio {
            background-color: #f2f2f2;

        }

        td.estado-R {
            background-color: #0a5e9c;
            color: #f2f2f2;
            text-align: center;

        }

        td.estado-NR {
            background-color: #E72b3c;
            color: #f2f2f2;
            text-align: center;
        }

        td.estado-O {
            background-color: #F39A11;
            color: #f2f2f2;
            text-align: center;
        }

        .mover-derecha {
            padding-left: 20px;
        }

        .ancho {
            padding-left: 10px;
            border: none;
        }

        .borde {
            border-right: 2.4px solid #000;

        }
    </style>
    <!-- Table titulo-->
    <table style="margin-bottom: 50px;">
        <tbody>
            <tr>
                <td rowspan="4"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/MASTER/assets/images/logo-covifarmaRecorte.png" alt=""></td>
                <td rowspan="4" style="text-align: center;">MONITOREO DE L & D DE ESTRUCTURAS FISICAS Y ACCESORIOS - MES DE <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                <td>LBS-PHS-FR-01</td>

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
    <!-- Table calendario-->
    <table>
        <tbody>
            <?php


            $grupos = array();

            foreach ($datos as $fila) {
                $nombreZona = $fila['NOMBRE_T_ZONA_AREAS'];
                $nombreInfraestructura = $fila['NOMBRE_INFRAESTRUCTURA'];
                $ndiaspos = $fila['N_DIAS_POS'];
                $estado = $fila['ESTADO'];
                $fechaTotal = $fila['FECHA_TOTAL'];

                if (!isset($grupos[$nombreZona])) {
                    $grupos[$nombreZona] = array();
                }

                $existingIndex = -1;
                foreach ($grupos[$nombreZona] as $index => $value) {
                    if ($value['nombreInfraestructura'] === $nombreInfraestructura) {
                        $existingIndex = $index;
                        break;
                    }
                }

                if ($existingIndex !== -1) {
                    $grupos[$nombreZona][$existingIndex]['estados'][$fechaTotal] = $estado;
                } else {
                    $grupos[$nombreZona][] = array(
                        'nombreInfraestructura' => $nombreInfraestructura,
                        'estados' => array($fechaTotal => $estado),
                        'ndiaspos' => $ndiaspos,
                        'fechaTotal' => $fechaTotal
                    );
                }
            }

            $numeroDiasMe = date('t', strtotime($fechaTotal));
            $columnasFechaTotales = $numeroDiasMe;

            echo '<tr>';
            echo '<td class="cabecera-fila column-1" rowspan="2">Zonas/areas</td>';
            echo '<td class="cabecera-fila column-2" rowspan="2">Infraestructura, accesorios complementarios</td>';
            echo '<td class="cabecera-fila" rowspan="2">Frecuencia</td>';
            echo '<td class="cabecera-fila" colspan="' . $columnasFechaTotales . '">Dias</td>';
            echo '<td class="cabecera-fila" rowspan="2">Responsable de ejecucion</td>';
            echo '</tr>';

            echo '<tr>';

            for ($l = 1; $l <= $columnasFechaTotales; $l++) {
                if ($l == $columnasFechaTotales) {
                    echo '<td class="cabecera-fila borde">' . $l . '</td>';
                } else {
                    echo '<td class="cabecera-fila">' . $l . '</td>';
                }
            }

            echo '</tr>';


            foreach ($grupos as $nombreZona => $valores) {
                echo '<tr">';
                echo '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';

                foreach ($valores as $index => $valor) {
                    if ($index !== 0) {
                        echo '<tr>';
                    }

                    echo '<td class="cabecera">' . $valor['nombreInfraestructura'] . '</td>';
                    if ($valor['ndiaspos'] == 1) {
                        echo '<td class="cabecera">Diaria</td>';
                    } elseif ($valor['ndiaspos'] == 2) {
                        echo '<td class="cabecera">Interdiaria</td>';
                    } elseif ($valor['ndiaspos'] == 7) {
                        echo '<td class="cabecera">Semanal</td>';
                    } elseif ($valor['ndiaspos'] == 15) {
                        echo '<td class="cabecera">Quincenal</td>';
                    } elseif ($valor['ndiaspos'] == 30) {
                        echo '<td class="cabecera">Mensual</td>';
                    } else {
                        echo '<td class="cabecera">' . $valor['ndiaspos'] . '</td>';
                    }

                    // Crear array con columnas de acuerdo a la FECHA_TOTAL
                    $fechaTotal = $valor['fechaTotal'];
                    $numeroDiasMes = date('t', strtotime($fechaTotal));
                    $columnasFechaTotal = $numeroDiasMes;
                    $dias = date('d', strtotime($fechaTotal));

                    $columnas = array();
                    for ($i = 1; $i <= $columnasFechaTotal; $i++) {

                        if ($i == $dias) {
                            $columnas[$i] = '';
                            error_log(" $columnas[$i]");
                        } else {
                            $columnas[$i] = 'x';
                        }
                    }

                    // Agregar columna en blanco si el mes tiene 30 días
                    // if ($columnasFechaTotal == 30) {
                    //     $columnas[31] = '';
                    // }
                    print_r($valor['estados']);
                    // Asignar los estados a las columnas correspondientes
                    foreach ($valor['estados'] as $fecha => $estado) {
                        $dia = date('d', strtotime($fecha));

                        if (isset($columnas[$dia])) {
                            if ($columnas[$dia] === '') {
                                $columnas[$dia] = $estado;
                            } else {
                                $columnas[$dia] .= '' . $estado;
                            }
                        }
                    }

                    // Imprimir los estados en las columnas correspondientes
                    foreach ($columnas as $columna) {
                        //$estadoClass = $columna !== '' ? 'estado-' . $columna : 'estado-vacio';
                        //echo '<td class="' . $estadoClass . '">' . $columna . '</td>';
                        echo '<td class="cabecera">' . $columna . '</td>';
                    }
                    //Colocar este td para que rellene de responsable de ejecucion
                    echo '<td></td>';
                    if ($index !== 0) {
                        echo '</tr>';
                    }
                }

                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <!-- Table colores-->
    <table style="margin-top: 50px; border:none;">
        <tbody>
            <tr>
                <td class="ancho"></td>
                <td class="ancho"></td>
                <td class="ancho"></td>
                <td class="ancho"></td>
                <td class="ancho"></td>
                <td class="ancho"></td>
                <td class="ancho"></td>
                <td class="ancho"></td>
                <td class="estado-R ancho"></td>
                <td class="mover-derecha ancho">L&D realizada</td>
                <td class="estado-NR ancho"></td>
                <td class="mover-derecha ancho">L&D pendiente</td>
                <td class="estado-O ancho"></td>
                <td class="mover-derecha ancho">L&D observado</td>
            </tr>
        </tbody>
    </table>
    <!-- Table observaciones-->
    <table style="margin-top: 50px;">
        <thead>
            <tr>
                <th>N°</th>
                <th>Fecha</th>
                <th>Área/ Zona identificada</th>
                <th>Hallazgo/ Observación</th>
                <th>Acción correctiva</th>
                <th>Verificación realizada</th>
                <th>V°b°Supervisor</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($datos as $fils) {
                echo '<tr>';
                echo '<td></td>';
                echo '<td class="cabecera">' . convFecSistema($fils['FECHA_TOTAL']) . '</td>';
                echo '<td class="cabecera">' . $fils['NOMBRE_T_ZONA_AREAS'] . '</td>';

                echo '<td class="cabecera">' . $fils['OBSERVACION'] . '</td>';
                echo '<td></td>';
                echo '<td></td>';
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
<?php
$html = ob_get_clean();


require_once '../assets/DomPDF/autoload.inc.php';

$dompdf = new Dompdf\Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A2', 'landscape');
$dompdf->render();
$dompdf->stream('tabla.pdf', array('Attachment' => 0));
?>