<?php
require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

$anioSeleccionado = $_GET['anio'];
$mesSeleccionado = $_GET['mes'];
/*convierte el valor en enetero*/
$mesNumerico = intval($mesSeleccionado);

$mostrar = new m_almacen();

$nombre = 'LBS-PHS-FR-01';
$versionMuestraFecha = $mostrar->MostrarVersionGeneralFecha($nombre);
$fechaDateTime = new DateTime($versionMuestraFecha);
$anio = $fechaDateTime->format('Y');
$mesExtra = intval($fechaDateTime->format('m'));

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
$mesversion = $mesesEnLetras[$mesExtra];


$datos = $mostrar->MostrarInfraestructuraPDF($anioSeleccionado, $mesSeleccionado);
$data = $mostrar->MostrarInfraestructuraEstadoPDF($anioSeleccionado, $mesSeleccionado);
$versionMuestra = $mostrar->VersionMostrar();

$versionMuestra = $mostrar->MostrarVersionGeneral($nombre);
$fecham = $anioSeleccionado . '-' . $mesSeleccionado;
//$alertapdf = $mostrar->Mostraralertainfrapdf($anioSeleccionado, $mesSeleccionado);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="http://192.168.1.102/SISTEMA/control_alimento/images/icon/covifarma-ico.ico" type="images/png">
    <title>LABSABELL</title>
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
            background-color: #c8faf6;
            text-align: center;
            font-size: 20px;
            font-weight: 200;
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
            background-color: #008000;
            /* color: #f2f2f2; */
            text-align: center;
            height: 30px;

        }

        /* 
        td.estado-NR {
            background-color: #FF0000;
            text-align: center;
            height: 30px;
        } */

        td.estado-OB {
            background-color: #ffff00;
            /* color: #f2f2f2; */
            text-align: center;
            height: 30px;
        }

        td.estado-PO {
            background-color: #FF0000;
            /* color: #f2f2f2; */
            text-align: center;
            height: 30px;
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

        td.cabecera-fila {
            width: 30px;
            height: 30px;
        }


        body {
            margin: 38mm 8mm 37mm 8mm;

        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        /* .salto {
            page-break-inside: avoid;
            page-break-before: auto;
            height: 15px;
        } */



        /* .tablaSeparada {
            page-break-inside: avoid;
            margin-top: 330px;
        } */
    </style>

    <!-- Table titulo-->
    <header>
        <table>

            <tr>
                <td rowspan="4" style="text-align: center;"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/logo-covifarmaRecorte.png')); ?>" alt=""></td>

                <td rowspan="4" style="text-align: center; font-size:25px; font-weigth:200;">MONITOREO DE L & D DE ESTRUCTURAS FISICAS Y ACCESORIOS - MES DE <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                <td>LBS-PHS-FR-01</th>
            </tr>
            <tr>
                <td>Versión: <?php echo $versionMuestra ?> </td>
            </tr>
            <tr>
                <td>Página:</td>
            </tr>
            <tr>
                <td>Fecha: <?php echo ($mesversion . ' ' . $anio); ?> </td>
            </tr>

        </table>
    </header>

    <!-- Table calendario-->
    <table>

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
        // $numeroDiasMe = date('t', strtotime($fecham));
        // $columnasFechaTotales = $numeroDiasMe;

        echo '<thead>';
        echo '<tr>';
        echo '<th class="cabecera-fila column-1" rowspan="2">Zonas/areas</th>';
        echo '<th class="cabecera-fila column-2" rowspan="2">Infraestructura, accesorios complementarios</th>';
        echo '<th class="cabecera-fila" rowspan="2">Frecuencia</th>';
        echo '<th class="cabecera-fila" colspan="' . $columnasFechaTotales . '" style="witdh:100px;">Dias</th>';
        echo '<th class="cabecera-fila" rowspan="2">Responsable de ejecucion</th>';
        echo '</tr>';

        echo '<tr>';

        for ($l = 1; $l <= $columnasFechaTotales; $l++) {
            if ($l == $columnasFechaTotales) {
                echo '<th class="cabecera-fila borde" style="width:30px;">' . $l . '</th>';
            } else {
                echo '<th class="cabecera-fila" style="width:30px;">' . $l . '</th>';
            }
        }

        echo '</tr>';
        echo '</thead>';

        $contadorF = -1;
        $filavacio = '';
        echo '<tbody >';

        foreach ($grupos as $nombreZona => $valores) {
            $contadorF++;
            if ($contadorF == 4) {
                echo '<tr style="page-break-before: always;">';
            } elseif ($contadorF > 4 && $contadorF % 4 == 0) {
                echo '<tr style="page-break-before: always;">';
            } else {
                echo '<tr>';
            }

            echo '<td  rowspan="' . count($valores) . '">' . $nombreZona . '</td>';

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
                $diasConver = intval($dias);

                $columnas = array();
                for ($i = 1; $i <= $columnasFechaTotal; $i++) {

                    if ($i == $diasConver) {
                        $columnas[$i] = '';
                    } else {
                        $columnas[$i] = '';
                    }
                }

                // print_r($valor['estados']);
                // Asignar los estados a las columnas correspondientes
                foreach ($valor['estados'] as $fecha => $estado) {
                    $dia = date('d', strtotime($fecha));
                    $diasCon = intval($dia);

                    if (isset($columnas[$diasCon])) {
                        if ($columnas[$diasCon] === '') {
                            $columnas[$diasCon] = $estado;
                        } else {
                            $columnas[$diasCon] .= '' . $estado;
                        }
                    }
                }

                // Imprimir los estados en las columnas correspondientes
                foreach ($columnas as $columna) {
                    $estadoClass = $columna !== '' ? 'estado-' . $columna : 'estado-vacio';
                    echo '<td class="' . $estadoClass . '"></td>';
                    //echo '<td class="' . $estadoClass . '">' . $columna . '</td>';
                }
                //Colocar este td para que rellene de responsable de ejecucion
                echo '<td style="text-align:center;">Operario</td>';
                // if ($index !== 0) {
                echo '</tr>';
                // }
            }
        }
        echo '</tbody>';
        ?>

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
                <!-- <td class="estado-NR ancho"></td> -->
                <td class="estado-PO ancho"></td>
                <td class="mover-derecha ancho">L&D pendiente</td>
                <td class="estado-OB ancho"></td>
                <td class="mover-derecha ancho">L&D observado</td>
                <!-- <td class="estado-PO ancho"></td>
                <td class="mover-derecha ancho">L&D postergado</td> -->
            </tr>
        </tbody>
    </table>
    <!-- Table observaciones-->
    <table style="margin-top: 50px; ">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: 200;">N°</th>
                <th style="text-align: center; font-weight: 200;">Fecha</th>
                <th style="text-align: center; font-weight: 200;">Área/ Zona identificada</th>
                <th style="text-align: center; font-weight: 200;">Hallazgo/ Observación</th>
                <th style="text-align: center; font-weight: 200;">Acción correctiva</th>
                <th style="text-align: center; font-weight: 200;">Verificación realizada</th>
                <th style="text-align: center; font-weight: 200;">V°b°Supervisor</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $nContador = 1;

            $fechas = array_column($datos, 'FECHA_TOTAL');
            array_multisort($fechas, SORT_ASC, $datos);


            foreach ($data as $fils) {
                $vb = $fils['VB'];
                if ($vb == "Seleccione V°B") {
                    $vb = '';
                }
                $vr = $fils['VERIFICACION_REALIZADA'];
                if ($vr == "Seleccione una verificacion") {
                    $vr = '';
                }

                echo '<tr>';

                echo '<td class="cabecera">' . $nContador . '</td>';
                $nContador++;

                echo '<td class="cabecera">' . convFecSistema($fils['FECHA_TOTAL']) . '</td>';
                echo '<td class="cabecera">' . $fils['NOMBRE_T_ZONA_AREAS'] . '</td>';
                echo '<td class="cabecera">' . $fils['OBSERVACION'] . '</td>';
                echo '<td class="cabecera">' . $fils['ACCION_CORRECTIVA'] . '</td>';
                echo '<td class="cabecera">' . $vr . '</td>';
                echo '<td class="cabecera">' . $vb . '</td>';

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
            <td style="padding-left: 400px; border:none; font-weight: 300; font-size:17px;">Fecha:</td>
            <td style="padding-left: 400px; border:none;"></td>
            <td style="padding-left: 800px; border:none;"></td>

        </tr>
        <tr>
            <td style="padding-left: 200px; border:none;"></td>
            <td style="border-left: none; border-bottom:none; border-right: none; font-weight: 300; font-size:17px;">Firma del jefe de Aseguramiento de la calidad</td>
            <td style="padding-left: 400px; border:none;"></td>
            <td style="padding-left: 400px;border-left: none; border-bottom:none; border-right: none;"></td>
            <td style="padding-left: 800px; border:none;"></td>

        </tr>
    </table>

</body>

</html>