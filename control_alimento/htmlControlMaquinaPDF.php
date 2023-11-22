<?php
require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

$anioSeleccionado = $_GET['anio'];
$mesSeleccionado = $_GET['mes'];

$mostrar = new m_almacen();
$nombre = 'LBS-PHS-FR-03';
$versionMuestraFecha = $mostrar->MostrarVersionGeneralFecha($nombre);
$fechaDateTime = new DateTime($versionMuestraFecha);
$anio = $fechaDateTime->format('Y');
$mesExtra = intval($fechaDateTime->format('m'));
/*convierte el valor en entero*/
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
$mesversion = $mesesEnLetras[$mesExtra];


$dataControl = $mostrar->MostrarControlMaquinaPDF($anioSeleccionado, $mesSeleccionado);
$data = $mostrar->MostrarControlMaquinaOBPDF($anioSeleccionado, $mesSeleccionado);
$fecha = $anioSeleccionado . '-' . $mesSeleccionado;

// $versionMuestra = $mostrar->VersionMostrar();
$versionMuestra = $mostrar->MostrarVersionGeneral($nombre);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="http://192.168.1.102/SISTEMA/control_alimento/images/icon/covifarma-ico.ico" type="images/png">
    <title>Control de maquinas</title>
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
            font-weight: 200;
            font-size: 20px;
            width: 20px;

        }

        .cabecera-valores {
            background-color: #cee6ba;
            text-align: center;
        }


        .cabeceraOb {
            text-align: center;
            background-color: #a3a0a0;
        }

        .mover-derecha {
            padding-left: 20px;
        }

        td.cabecera-fila {
            width: 30px;
            height: 30px;
        }

        .tdRaya::after {
            content: '';
            position: absolute;
            width: 220px;
            height: 0.5px;
            background-color: black;
            margin-top: 18px;
        }

        .tdFecha::after {
            content: '';
            position: absolute;
            width: 220px;
            height: 0.5px;
            background-color: black;
            margin-top: 18px;
        }

        body {
            margin: 50mm 8mm 2mm 8mm;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }
    </style>
    <!-- Table titulo-->
    <header>
        <table>
            <tbody>
                <tr>
                    <td rowspan="4" style="text-align: center;"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/logo-covifarmaRecorte.png')); ?>" alt=""></td>
                    <!-- <td rowspan="4" style="text-align: center;"><img src="http://192.168.1.102/SISTEMA/control_alimento/images/logo-covifarmaRecorte.png" alt=""></td> -->
                    <td rowspan="4" style="text-align: center; font-size:25px; font-weigth:200;">LIMPIEZA Y DESINFECCIÓN DE UTENSILIOS DE LIMPIEZA - <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                    <td>LBS-PHS-FR-03</td>

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


            </tbody>
        </table>
    </header>

    <!-- Table solucion y preparaciones-->
    <table style="margin-bottom: 70px;">

        <?php
        echo '<thead>';
        echo '<tr>';
        $numeroDiasMes = date('t', strtotime($fecha));

        echo '<th rowspan="2">N°</th>';
        echo '<th rowspan="2">Máquina,equipos y utensilios de trabajo</th>';
        echo '<th rowspan="2">Frecuencia</th>';
        echo "<th colspan='$numeroDiasMes'>Dias</th>";
        echo "<th rowspan='2'>Responsable de ejecución</th>";
        echo '</tr>';
        echo "<tr>";
        for ($i = 1; $i <= $numeroDiasMes; $i++) {
            echo "<th style='text-align:center; width: 10px;'>" . $i . "</th>";
        }
        echo "</tr>";
        echo '</thead>';

        $datosAgrupados = array();
        foreach ($dataControl as $row) {
            $nombre = $row['NOMBRE_CONTROL_MAQUINA'];
            $frecuencia = $row['FRECUENCIA'];
            $fecha = $row['FECHA_TOTAL'];
            $fechaObj = DateTime::createFromFormat('d/m/Y', $fecha);
            $dia = $fechaObj->format('d');

            $estado = trim($row['ESTADO']);
            if (!isset($datosAgrupados[$nombre])) {
                $datosAgrupados[$nombre] = array();
            }
            if (!isset($datosAgrupados[$nombre][$dia])) {
                $datosAgrupados[$nombre][$dia] = array('estado' => $estado, 'frecuencia' => $frecuencia);
            }
        }
        echo '<tbody>';
        $con = 1;
        foreach ($datosAgrupados as $nombre => $dias) {

            echo '<tr>';
            echo '<td>' . $con . '</td>';
            echo '<td>' . $nombre . '</td>';
            echo '<td>' . $dias[array_key_first($dias)]['frecuencia'] . '</td>';

            for ($i = 1; $i <= $numeroDiasMes; $i++) {
                // echo '<td>';
                // if (isset($dias[$i])) {
                //     echo $dias[$i]['estado'];
                // }
                // echo '</td>';
                echo '<td style="background-color:';

                // Set color based on estado value
                if (isset($dias[$i])) {
                    $estado = $dias[$i]['estado'];
                    switch ($estado) {
                        case 'PO':
                            echo 'red';
                            break;
                        case 'OB':
                            echo 'yellow';
                            break;
                        case 'R':
                            echo 'blue';
                            break;
                        default:
                            echo 'white';
                            break;
                    }
                } else {
                    echo 'white';
                }
                echo '">';


                echo '</td>';

                // if (isset($dias[$i])) {
                //     echo $dias[$i]['estado'];
                // }
            }
            echo '<td style="text-align:center;">Operario</td>';
            $con++;
            echo '</tr>';
        }
        echo '</tbody>';
        ?>



    </table>

    <!-- Table observacion-->
    <table style="margin-bottom: 50px;">
        <thead>
            <tr>
                <th class="cabeceraOb">Fecha</th>
                <th class="cabeceraOb">Area/Zona identificada</th>
                <th class="cabeceraOb">Hallazgo/Observacion</th>
                <th class="cabeceraOb">Acción correctiva</th>
                <th class="cabeceraOb">V°b° Supervisor</th>
            </tr>
        </thead>
        <?php
        echo "<tbody>";
        foreach ($data as $datos) {
            $vb = $datos['VB'];
            if ($vb == 'Seleccione V°B°') {
                $vb = '';
            }
            echo '<tr>';
            echo '<td style="text-align: center;">' . $datos['FECHA_TOTAL'] . '</td>';
            echo '<td style="text-align: center;"></td>';
            echo '<td style="text-align: center;">' . $datos['OBSERVACION'] . '</td>';
            echo '<td style="text-align: center;">' . $datos['ACCION_CORRECTIVA'] . '</td>';
            echo '<td style="text-align: center;">' . $vb . '</td>';
            echo '</tr>';
        }
        echo "</tbody>";
        ?>
    </table>

    <!-- Table firma y fecha-->
    <table style="margin-top: 80px; border:none;">
        <tr>
            <td style="padding-left: 100px; border:none;"></td>
            <td style="padding-left: 100px; border-left:none; border-top:none; border-right:none;"></td>
            <td style="padding-left: 200px; text-align:right; border:none; font-weight: 300; font-size:17px;">Fecha:</td>
            <td style="padding-left: 200px; border-left:none; border-top:none; border-right:none;"></td>
            <td style="padding-left: 300px; border:none;"></td>

        </tr>
        <tr>
            <td style="padding-left: 100px; border:none;"></td>
            <td style="padding-left: 100px; text-align:center; border-left:none; border-bottom:none; border-right:none; font-weight: 300; font-size:17px;">Firma del jefe de Aseguramiento de la calidad</td>
            <td style="padding-left: 200px; border:none;"></td>
            <td style="padding-left: 200px; border-left:none; border-bottom:none; border-right:none;"></td>
            <td style="padding-left: 300px; border:none;"></td>

        </tr>
    </table>
</body>

</html>