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
$dataCod = $mostrar->MostrarRegistroProduccionPorCodInsumoPDF($anioSeleccionado, $mesSeleccionado);
$datos = $mostrar->MostrarRegistroProduccionPDF();
$nombre = 'LBS-OP-FR-01';
$versionMuestra = $mostrar->MostrarVersionGeneral($nombre);

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
            margin: 10mm 5mm 2mm 2mm;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        .estilotd {
            font-weight: 400;
            font-size: 10px;
        }

        .tdcentrado {
            text-align: center;
            font-weight: 250;
            font-size: 9px;
        }

        .tdcentrado-bold {
            text-align: center;
            font-weight: 400;
            font-size: 8px;
        }


        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

        /* .column-1:nth-child(1) {
            width: 100px;
        }

        .column-2:nth-child(5) {
            width: 200px;

        }

        .column-3:nth-child(6) {
            width: 500px;

        } */
    </style>
    <!--------------------------------------- Titulo header --------------------------------------->
    <header>
        <table>
            <tbody>
                <tr>
                    <!-- <td rowspan="4" style="text-align: center;"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/MODELO/control_alimento/images/logo-covifarmaRecorte.png" alt=""></td> -->
                    <!-- <td rowspan="4" class="cabecera"><img src="http://192.168.1.102/SISTEMA/control_alimento/images/logo-covifarmaRecorte.png" alt=""></td> -->
                    <td rowspan="4" style="text-align: center;"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/img_lab.jpg')); ?>" style="width: 80px; height: 50px;" alt=""></td>
                    <td rowspan="4" style="text-align: center; font-size:10px; font-weigth:400;">REGISTRO DE ENVASES - <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                    <td class="estilotd">LBS-OP-FR-01</td>

                </tr>
                <tr>
                    <td class="estilotd">Versión: <?php echo $versionMuestra ?> </td>
                    <!-- <td class="estilotd">Versión: 02 </td> -->
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
    $divCount = -1;

    foreach ($dataCod as $filas) {
        $divCount++;
        if ($divCount == 4) {
            echo '<div style="page-break-before: always;">';
        } elseif ($divCount > 4 && $divCount % 4 == 0) {
            echo '<div style="page-break-before: always;">';
        } else {
            echo '<div>';
        }

        echo '<table style="margin-top: 40px;">';
        echo '<tr>';
        echo '<td colspan="2" class="tdcentrado">FECHA:</td>';
        echo '<td colspan="2" class="tdcentrado">' . $filas->FECHA . '</td>';
        echo '<td colspan="2" class="tdcentrado">N° BACHADA</td>';
        echo '<td colspan="2" class="tdcentrado">' . $filas->N_BACHADA . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td class="tdcentrado">PRODUCTO</td>';
        echo '<td class="tdcentrado">' . $filas->ABR_PRODUCTO . '</td>';
        echo '<td class="tdcentrado">PRESENTACION</td>';
        echo '<td class="tdcentrado">' . $filas->PESO_NETO . ' gr' . '</td>';
        echo '<td class="tdcentrado">CANTIDAD(Unid.)</td>';
        echo '<td class="tdcentrado">' . $filas->CANTIDAD . '</td>';
        echo '<td class="tdcentrado">PESO TOTAL:</td>';
        echo '<td class="tdcentrado">' . $filas->CANT_INSUMOS . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td colspan="4" class="tdcentrado">MATERIALES ENVASES/OTROS</td>';
        echo '<td  class="tdcentrado">CANTIDAD(Unid.)</td>';
        echo '<td  class="tdcentrado">LOTE</td>';
        echo '<td class="tdcentrado" >RECIBIDO POR</td>';
        echo '<td class="tdcentrado">FIRMA</td>';
        echo '</tr>';


        foreach ($datos as $filadata) {
            if ($filadata->COD_AVANCE_INSUMOS == $filas->COD_AVANCE_INSUMOS) {
                echo '<tr>';
                echo '<td class="tdcentrado-bold" style="width:200px;">' . $filadata->DES_PRODUCTO . '</td>';
                echo '<td  class="tdcentrado-bold" colspan="3" style="background-color:#60fc60;font-weight:600;">' . $filadata->ABR_PRODUCTO . '</td>';
                echo '<td class="tdcentrado-bold">' . $filadata->CANTIDAD . '</td>';
                echo '<td  class="tdcentrado-bold" style="width:100px;">' . $filadata->LOTE . '</td>';
                // echo '<td style="border-bottom:none; border-top:none;"></td>';
                echo '<td></td>';
                echo '<td style="width:90px;"></td>';
                echo '</tr>';
            }
        }
        echo '<tr>';
        echo '<td style="border-left:none; border-right:none; border-bottom:none;"></td>';
        echo '<td style="border-left:none; border-right:none; border-bottom:none;"></td>';
        echo '<td style="border-left:none; border-right:none; border-bottom:none;"></td>';
        echo '<td style="border-left:none; border-right:none; border-bottom:none;"></td>';
        echo '<td style="border-left:none; border-right:none; border-bottom:none;"></td>';
        echo '<td style="border-left:none; border-right:none; border-bottom:none;"></td>';
        echo '<td style="border-left:none; border-right:none; border-bottom:none;"></td>';
        echo '<td style="border-left:none; border-right:none; border-bottom:none;"></td>';
        echo '</tr>';
        echo '</table>';
        echo '<table style="margin-top:20px;">';
        echo '<tr>';
        echo '<td style="font-size: 9px; border:none;">Observaciones:</td>';
        echo '<td style="padding-left:120px; border-right:none; border-left:none; border-top:none;"></td>';
        echo '<td style="padding-left:30px; border:none;"></td>';
        echo '<td style="font-size: 9px; border:none;">Acciones correctivas:</td>';
        echo '<td style="padding-left:120px; border-right:none; border-left:none; border-top:none;"></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td style="padding-top:5px; padding-bottom:5px; border-right:none; border-left:none; border-top:none;"></td>';
        echo '<td style="border-right:none; border-left:none;"></td>';
        echo '<td style="border:none;"></td>';
        echo '<td style="border-right:none; border-left:none; border-top:none;"></td>';
        echo '<td style="border-right:none; border-left:none;"></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td style="padding-top:5px; padding-bottom:5px; border-right:none; border-left:none;"></td>';
        echo '<td style="border-right:none;border-left:none;"></td>';
        echo '<td style="border:none;"></td>';
        echo '<td style="border-right:none; border-left:none;"></td>';
        echo '<td style="border-right:none; border-left:none;"></td>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
        echo '<div class="footer">';
        echo '<table>';
        echo '<tr>';
        echo '<td style="border:none; font-size:8px;">Donde ME: Material de envase(bolsas,frascos);Otros:cucharitas,etiquetas,alupol,etc.</td>';
        echo '<td style="padding-left: 100px; padding-right:100px;border:none;"></td>';
        echo '<td style="padding-left: 100px; padding-right:100px;border:none;"></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td style="padding-top:30px; border-top:none;border-left:none;border-right:none;"></td>';
        echo '<td style="padding-left: 400px; padding-right:400px;border:none;"></td>';
        echo '<td style="padding-left: 100px; padding-right:100px;border-top:none;border-left:none;border-right:none;"></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td style="padding-top:10px; border-left:none;border-right:none;border-bottom:none;text-align:center; font-size:8px;">Firma del Asistente de calidad</td>';
        echo '<td style="padding-left: 100px; padding-right:100px;border:none;"></td>';
        echo '<td style="padding-left: 100px; padding-right:100px;border-left:none;border-right:none;border-bottom:none; font-size:8px;">Jefe de Aseguramiento de la calidad</td>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
    }
    ?>

</body>


</html>