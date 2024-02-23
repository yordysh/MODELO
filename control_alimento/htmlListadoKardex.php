<?php
require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

$codigoproducto = $_GET['codigo'];
$fechainicio = $_GET['fechainicio'];
$fechafin = $_GET['fechafin'];
$mostrar = new m_almacen();
$totalkardexmostrar = $mostrar->MostrarListaKardexProducto($codigoproducto, $fechainicio, $fechafin);
$titulo = $mostrar->MostrarProducto($codigoproducto);
$totallote = $mostrar->m_total_x_lote($codigoproducto, '');
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
    <title>Lista de kardex</title>
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
                <td rowspan="2" style="text-align: center;"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/img_lab.jpg')); ?>" alt="" width="100" height="50"></td>
                <td rowspan="2" style="text-align: center; font-size:15px; font-weight:200; width:400px;">LISTA DE KARDEX - <?php echo $anio; ?></td>
                <td>Página:</td>
            </tr>
            <tr>
                <td>Fecha: <?php echo ($mesversion . ' ' . $anio); ?> </td>
            </tr>

        </table>
    </header>
    <?php echo "<h1 style='text-align:center;font-size:15px;'>" . $titulo[0]["COD_PRODUCCION"] . "- " . $titulo[0]["DES_PRODUCTO"] . "</h1>"; ?>
    <!-- Table de requerimiento -->
    <table style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="" style="font-size:12px;">FECHA</th>
                <th class="" style="font-size:12px;">CÓDIGO PRODUCTO</th>
                <th class="" style="font-size:12px;">INSUMO</th>
                <th class="" style="font-size:12px;">LOTE</th>
                <th class="" style="font-size:12px;">OBASERVACIÓN</th>
                <th class="" style="font-size:12px;">INGRESO</th>
                <th class="" style="font-size:12px;">SALIDA</th>
                <th class="" style="font-size:12px;">SALDO</th>
            </tr>
        </thead>
        <?php
        echo "<tbody>";
        foreach ($totalkardexmostrar as $row) {
            if ($row["ESTADO"] == 'I') {

                echo '<tr style="background-color: #c6efce;">';
                echo '<td style="font-size:11px; text-align:center;">' . convFecSistema($row["FEC_REGISTRO"]) . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["COD_PRODUCCION"] . "- " . $row["ABR_PRODUCTO"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["DES_PRODUCTO"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["LOTE"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["DESCRIPCION"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . ($row["CANT_INGRESO"] != NULL ? $row["CANT_INGRESO"] : "0") . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' .  ($row["CANT_EGRESO"] != NULL ? $row["CANT_EGRESO"] : "0") . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . number_format($row["SALDO"], 2) . '</td>';
                echo '</tr>';
            } else if ($row["ESTADO"] == 'F') {
                echo '<tr style="background-color: #ffc7ce;">';
                echo '<td style="font-size:11px; text-align:center;">' . convFecSistema($row["FEC_REGISTRO"]) . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["COD_PRODUCCION"] . "- " . $row["ABR_PRODUCTO"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["DES_PRODUCTO"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["LOTE"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["DESCRIPCION"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . ($row["CANT_INGRESO"] != NULL ? $row["CANT_INGRESO"] : "0") . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . ($row["CANT_EGRESO"] != NULL ? $row["CANT_EGRESO"] : "0") . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . number_format($row["SALDO"], 2) . '</td>';
                echo '</tr>';
            } else if ($row["ESTADO"] == 'S') {
                echo '<tr>';
                echo '<td style="font-size:11px; text-align:center;">' . convFecSistema($row["FEC_REGISTRO"]) . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["COD_PRODUCCION"] . "- " . $row["ABR_PRODUCTO"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">'  . $row["DES_PRODUCTO"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["LOTE"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">' . $row["DESCRIPCION"] . '</td>';
                echo '<td style="font-size:11px; text-align:center;">-</td>';
                echo '<td style="font-size:11px; text-align:center;">-</td>';
                echo '<td style="font-size:11px; text-align:center;">' . number_format($row["SALDO"], 2) . '</td>';
                echo '</tr>';
            }
        }
        echo '<tr>';
        echo '<td colspan="6" style="text-align:center;font-size:11px">TOTAL</td>';
        echo '<td colspan="2" style="text-align:center;font-size:11px">' . $totallote[0][0] . '</td>';
        echo '</tr>';
        echo "</tbody>";
        ?>
    </table>
</body>

</html>