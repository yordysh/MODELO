<?php
require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

$requerimiento = $_GET['requerimiento'];

$mostrar = new m_almacen();

$totalproductos = $mostrar->MostrarListaRequerimiento($requerimiento);

$fechaDateTime = new DateTime();
$anio = $fechaDateTime->format('Y');
$mesExtra = intval($fechaDateTime->format('m'));
$dia = $fechaDateTime->format('d');

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

$mesversion = $mesesEnLetras[$mesExtra];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/img_lab.jpg')); ?>" type="images/png">
    <title>Lista de requerimiento</title>
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

        .cabecera-rigth {
            text-align: center;
            font-weight: 200;
            font-size: 16px;
            width: 20px;
            padding: 10px 98px;
        }

        .cabecera-version {
            background-color: #ffff;
            text-align: center;
            font-weight: 200;
            font-size: 16px;
            width: 20px;
            /* padding: 1px 98px; */

        }

        .cabecera {
            text-align: center;
            font-weight: 300;
        }

        body {
            margin: 20mm 1mm 2mm 1mm;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        .thlabsabell {
            background-color: #f3a6f5;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
            width: 20px;
            padding: 5px 0 5px 100px;
            /* border-right: none; */
        }

        .thlab {
            background-color: #f3a6f5;
            text-align: center;
            font-weight: 200;
            font-size: 16px;
            width: 20px;
            padding: 5px 28px 5px 0;
            border-left: none;
        }

        body {
            margin: 30mm 8mm 30mm 8mm;
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

            <tr>
                <td rowspan="3" style="text-align: center;"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/img_lab.jpg')); ?>" alt="" width="100" height="50"></td>

                <td rowspan="3" style="text-align: center; font-size:15px; font-weight:200; width:400px;">LISTA DE REQUERIMIENTO - <?php echo $anio; ?></td>
                <td>Requerimiento: <?php echo $requerimiento; ?></th>
            </tr>
            <tr>
                <td>Página:</td>
            </tr>
            </tr>
            <tr>
                <td>Fecha: <?php echo ($mesversion . ' ' . $anio); ?> </td>
            </tr>

        </table>
    </header>

    <!-- Table de requerimiento -->
    <table style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="">CODIGO</th>
                <th class="">PRODUCTO</th>
                <th class="">CANTIDAD EN KG</th>
                <th class="">CANTIDAD ENVASES</th>
            </tr>
        </thead>
        <?php
        echo "<tbody>";
        foreach ($totalproductos as $row) {
            echo '<tr>';
            echo '<td style="font-size:13px; text-align:center;">' . $row["COD_PRODUCCION"] . '</td>';
            echo '<td style="font-size:13px;">' . $row["DES_PRODUCTO"] . '</td>';
            echo '<td style="font-size:13px; text-align:center;">' . $row["CANTIDAD"] . '</td>';
            echo '<td style="font-size:13px; text-align:center;">' . $row["TOTAL_PRODUCTO"] . '</td>';
            echo '</tr>';
        }
        echo "</tbody>";
        ?>
    </table>
</body>

</html>