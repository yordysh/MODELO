<?php
require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

$anioSeleccionado = $_GET['anio'];
$mesSeleccionado = $_GET['mes'];
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

$mostrar = new m_almacen();
$dataControl = $mostrar->MostrarControlMaquinaPDF($anioSeleccionado, $mesSeleccionado);
// $dataLimpieza = $mostrar->MostrarLimpiezaPD();
$versionMuestra = $mostrar->VersionMostrar();


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
                    <!-- <td rowspan="4" style="text-align: center;"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/MASTER/control_alimento/images/logo-covifarmaRecorte.png" alt=""></td> -->
                    <td rowspan="4" style="text-align: center;"><img src="http://192.168.1.102/SISTEMA/control_alimento/images/logo-covifarmaRecorte.png" alt=""></td>
                    <td rowspan="4" style="text-align: center; font-size:25px; font-weigth:200;">LIMPIEZA Y DESINFECCIÓN DE UTENSILIOS DE LIMPIEZA - <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                    <td>LBS-PHS-FR-03</td>

                </tr>
                <tr>
                    <?php foreach ($versionMuestra as $version) { ?>
                        <td>Versión: <?php echo $version['VERSION'] ?> </td>
                    <?php
                    }
                    ?>

                </tr>
                <tr>
                    <td>Página:</td>
                </tr>
                <tr>
                    <td>Fecha: <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                </tr>


            </tbody>
        </table>
    </header>

    <!-- Table solucion y preparaciones-->
    <table style="margin-bottom: 70px;">

        <?php
        $grupos = array();
        $fechasEliminadas = array();

        foreach ($dataControl  as $filas) {
            $nombreZona = $filas['NOMBRE_T_ZONA_AREAS'];
            $nombreControl = $filas['NOMBRE_CONTROL_MAQUINA'];
            $fecha = $filas['FECHA_TOTAL'];

            if (!isset($grupos[$nombreZona][$nombreControl])) {
                $grupos[$nombreZona][$nombreControl] = array();
            }

            if (in_array($fecha, $grupos[$nombreZona][$nombreControl])) {
                $fechasEliminadas[] = $fecha;
            } else {
                $grupos[$nombreZona][$nombreControl][] = $fecha;
            }
        }
        echo "<thead>";
        $numeroDiasMes = date('t', strtotime($fecha));
        echo "<tr>";
        echo "<th class='cabecera-fila' rowspan='2'>N°</th>";
        echo "<th class='cabecera-fila' rowspan='2'>Máquinas,equipos y utensilios de trabajo</th>";
        echo "<th class='cabecera-fila' colspan='$numeroDiasMes'>Días</th>";
        echo "</tr>";

        echo "<tr>";

        for ($i = 1; $i <= $numeroDiasMes; $i++) {
            echo "<th style='text-align:center; width: 10px;'>" . $i . "</th>";
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $nContador = 1;
        foreach ($grupos as $nombreZona => $controles) {

            echo "<tr>";

            $numFilas = count($controles);
            // echo '<td rowspan="' . $numFilas . '">' . $nombreZona . '</td>';

            $firstRow = true;

            foreach ($controles as $nombreControl => $fechas) {
                if (!$firstRow) {
                    echo '<tr>';
                }
                echo '<td style="text-align:center;">' . $nContador . '</td>';
                $nContador++;

                echo "<td >" . $nombreControl  . "</td>";


                if (!empty($fechas)) {
                    $fecha = reset($fechas);
                    $numDias = date('t', strtotime($fecha));
                    $fechasArray = [];

                    foreach ($fechas as $fecha) {
                        $dias = date('d', strtotime($fecha));
                        $diasConver = intval($dias);
                        $fechasArray[] = $diasConver;
                    }

                    for ($i = 1; $i <= $numDias; $i++) {
                        if (in_array($i, $fechasArray)) {
                            //echo '<td style="text-align:center; max-width: 10px;"><img src="http://localhost:8080/MASTER/control_alimento/images/check.png" alt="" width="25"></td>';
                            echo '<td style="text-align:center; max-width: 10px;"><img src="http://192.168.1.102/SISTEMA/control_alimento/images/check.png" alt="" width="25"></td>';
                        } else {
                            echo "<td></td>";
                        }
                    }
                } else {
                    echo "<td>No hay fechas</td>";
                }

                $firstRow = false;
            }

            echo "</tr>";
        }


        echo "</tbody>";
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
                <th class="cabeceraOb">V°b° Supervisor</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                foreach ($dataControl as $row) {
                    echo '<tr>';
                    echo '<td style="text-align: center;">' . convFecSistema($row['FECHA_TOTAL']) . '</td>';
                    echo '<td style="text-align: center;">' . $row['NOMBRE_T_ZONA_AREAS'] . '</td>';
                    echo '<td style="text-align: center;">' . $row['OBSERVACION'] . '</td>';
                    echo '<td style="text-align: center;">' . $row['ACCION_CORRECTIVA'] . '</td>';
                    echo '<td></td>';
                    echo '</tr>';
                }
                ?>
            </tr>
        </tbody>
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