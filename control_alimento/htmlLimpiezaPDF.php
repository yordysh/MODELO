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
$dataLimpieza = $mostrar->MostrarLimpiezaPDF($anioSeleccionado, $mesSeleccionado);

// $versionMuestra = $mostrar->VersionMostrar();
$versionMuestra = $mostrar->MostrarVersionGeneral($nombre);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="http://192.168.1.102/SISTEMA/control_alimento/images/icon/covifarma-ico.ico" type="images/png">
    <title>Limpieza y desinfección</title>
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
                    <td>LBS-PHS-FR-04</td>

                </tr>
                <tr>
                    <td>Versión: <?php echo $versionMuestra ?> </td>
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
    <!-- Table Firma y año-->
    <table style="margin-bottom: 50px;">
        <tbody>
            <tr>
                <td style="padding-left: 50px; border:none;"></td>
                <td style="padding-left: 50px; border:none;"></td>
                <td class='tdRaya' style="padding-left: 30px; border:none; font-size:23px; display:inline-block; font-weight:200;">Mes/Año:</td>
                <td style="padding-left: 50px;  border:none"></td>
                <td style="padding-left: 50px; border:none;"></td>
                <td style="padding-left: 50px; border:none;"></td>
                <td class='tdRaya' style="padding-left: 10px; border:none; font-size:23px;  display:inline-block; font-weight:200;">Responsable:</td>
                <td style="padding-left: 50px; border: none;"></td>
            </tr>
        </tbody>
    </table>
    <!-- Table solucion y preparaciones-->
    <table style="margin-bottom: 70px;">

        <?php
        $grupos = array();
        $fechasEliminadas = array();

        foreach ($dataLimpieza as $filas) {
            $nombreZona = $filas['NOMBRE_T_ZONA_AREAS'];
            $nombreFrecuencia = $filas['NOMBRE_FRECUENCIA'];
            $fecha = $filas['FECHA'];

            if (!isset($grupos[$nombreZona][$nombreFrecuencia])) {
                $grupos[$nombreZona][$nombreFrecuencia] = array();
            }

            if (in_array($fecha, $grupos[$nombreZona][$nombreFrecuencia])) {
                $fechasEliminadas[] = $fecha;
            } else {
                $grupos[$nombreZona][$nombreFrecuencia][] = $fecha;
            }
        }
        echo "<thead>";
        $numeroDiasMes = date('t', strtotime($fecha));
        echo "<tr>";
        echo "<th class='cabecera-fila' rowspan='2'>ÁREA</th>";
        echo "<th class='cabecera-fila' rowspan='2'>ÍTEM(FRECUENCIA)</th>";
        echo "<th class='cabecera-fila' colspan='$numeroDiasMes'>VERIFICACIÓN DE LA LIMPIEZA Y DESINFECCIÓN DE UTENSILIOS PARA HEGIENIZACIÓN</th>";
        echo "</tr>";

        echo "<tr>";

        for ($i = 1; $i <= $numeroDiasMes; $i++) {
            echo "<th style='text-align:center; width: 10px;'>" . $i . "</th>";
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($grupos as $nombreZona => $frecuencias) {
            echo "<tr>";

            $numFilas = count($frecuencias);
            echo '<td rowspan="' . $numFilas . '">' . $nombreZona . '</td>';

            $firstRow = true;

            foreach ($frecuencias as $nombreFrecuencia => $fechas) {
                if (!$firstRow) {
                    echo '<tr>';
                }

                echo "<td>" . $nombreFrecuencia . "</td>";


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
                <th class="cabeceraOb">FECHA</th>
                <th class="cabeceraOb">OBSERVACIÓN</th>
                <th class="cabeceraOb">ACCIÓN CORRECTIVA</th>
                <th class="cabeceraOb">VERIFICACIÓN</th>
                <th class="cabeceraOb">V°B°</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                foreach ($dataLimpieza as $row) {
                    echo '<tr>';
                    echo '<td style="text-align: center;">' . convFecSistema($row['FECHA']) . '</td>';
                    echo '<td style="text-align: center;">' . $row['OBSERVACION'] . '</td>';
                    echo '<td style="text-align: center;">' . $row['ACCION_CORRECTIVA'] . '</td>';
                    echo '<td style="text-align: center;">' . $row['VERIFICACION'] . '</td>';
                    echo '<td></td>';
                    echo '</tr>';
                }
                ?>
            </tr>
        </tbody>
    </table>

    <!-- Table firma y fecha-->
    <table style="margin-top: 50px; border:none;">
        <tr>
            <td style="padding-left: 500px; border:none;"></td>
            <td style="padding-left: 200px; border:none;"></td>
            <td style="padding-left: 100px; border-left: none; border-bottom:none; border-right: none; font-weight: 300; font-size:17px;">JEFE DE ASEGURAMIENTO DE LA CALIDAD</td>
            <td style="padding-left: 700px; border:none;"></td>
        </tr>
        <tr>
            <td style="padding-left: 500px; border:none;"></td>
            <td style="padding-left: 200px; border:none;"></td>
            <td class="tdFecha" style="margin-top:10px; padding-left: 150px; border:0; display:inline-block; font-weight: 300; font-size:17px;">FECHA </td>
            <td style="padding-left: 700px; border:none;"></td>
        </tr>
    </table>
</body>

</html>