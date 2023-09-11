<?php
require_once "m_almacen.php";
// require_once "../funciones/f_funcion.php";

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
$datos = $mostrar->MostrarRegistroProduccionPDF();
// $datos = $mostrar->MostrarPreparacionSolucionPDF($anioSeleccionado, $mesSeleccionado);
// $versionMuestra = $mostrar->MostrarVersionGeneral($nombre);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de envases</title>
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

        body {
            margin: 40mm 8mm 2mm 8mm;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        .estilotd {
            font-weight: 200;
            font-size: 20px;
        }
    </style>
    <!--------------------------------------- Titulo header --------------------------------------->
    <header>
        <table>
            <tbody>
                <tr>
                    <!-- <td rowspan="4" style="text-align: center;"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/MODELO/control_alimento/images/logo-covifarmaRecorte.png" alt=""></td> -->
                    <!-- <td rowspan="4" class="cabecera"><img src="http://192.168.1.102/SISTEMA/control_alimento/images/logo-covifarmaRecorte.png" alt=""></td> -->
                    <td rowspan="4" style="text-align: center;"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/logo-covifarmaRecorte.png')); ?>" alt=""></td>
                    <td rowspan="4" style="text-align: center; font-size:30px; font-weigth:400;">REGISTRO DE ENVASES - <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                    <td class="estilotd">LBS-OP-FR-01</td>

                </tr>
                <tr>
                    <td class="estilotd">Versión: 01 </td>
                </tr>
                <tr>
                    <td class="estilotd">Página:</td>
                </tr>

                <tr>
                    <td class="estilotd">Fecha: <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                </tr>


            </tbody>
        </table>
    </header>
    <!--------------------------------------- Table solucion y preparaciones----------------------->
    <table style="margin-top: 10px;">
        <?php
        foreach ($datos as $filas) {
            echo '<tbody>';
            echo '<tr>';
            echo '<td>FECHA:</td>';
            echo '<td>X</td>';
            echo '<td>N° BACHADA</td>';
            echo '<td>X</td>';
            echo '</tr>';
            echo '</tbody>';
        }
        ?>

    </table>
</body>

</html>