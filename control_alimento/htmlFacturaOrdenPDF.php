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
$proveedor = $mostrar->MostrarFacturaProveedorPDF();
$productoscompra = $mostrar->MostrarFacturaPDF();
$nombre = 'LBS-OP-FR-01';
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

        /* 40mm bottom, 8mm right, 8mm left, 2mm top*/
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
            font-weight: 400;
            font-size: 20px;
        }

        .tdcentrado {
            text-align: center;
            font-weight: 300;
        }

        .tdcentrado-bold {
            text-align: center;
            font-weight: 400;
        }


        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
    <!--------------------------------------- Titulo header --------------------------------------->
    <header>
        <table>
            <tbody>
                <tr>

                    <td rowspan="4" style="text-align: center;"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/logo-covifarmaRecorte.png')); ?>" alt=""></td>
                    <td rowspan="4" style="text-align: center; font-size:30px; font-weigth:200;">FACTURA ORDEN COMPRA - <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                    <td class="estilotd">LBS-OP-FR-01</td>

                </tr>
                <tr>
                    <!-- <td class="estilotd">Versión: <?php echo $versionMuestra ?> </td> -->
                    <td class="estilotd">Versión: 02 </td>
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
    <!--------------------------------------- Table registro de envases----------------------->
    <?php
    foreach ($proveedor as $filasproveedor) {


        echo '<table style="margin-top: 50px;">';
        echo '<tbody>';

        echo '<tr>';
        echo '<td colspan="3" class="tdcentrado">PROVEEDOR : ' . $filasproveedor->NOM_PROVEEDOR . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td class="tdcentrado">PRODUCTO</td>';
        echo '<td class="tdcentrado">CANTIDAD</td>';
        echo '<td class="tdcentrado">PRECIO</td>';
        echo '</tr>';

        foreach ($productoscompra as $filadata) {
            if ($filadata->COD_TMPCOMPROBANTE == $filasproveedor->COD_TMPCOMPROBANTE) {
                echo '<tr>';
                echo '<td class="tdcentrado-bold">' . $filadata->DES_PRODUCTO . '</td>';
                echo '<td class="tdcentrado-bold">' . $filadata->CANTIDAD_MINIMA . '</td>';
                echo '<td class="tdcentrado-bold">' . $filadata->MONTO . '</td>';
                echo '</tr>';
            }
        }
        echo '</tbody>';
        echo '</table>';
    }
    ?>

</body>


</html>