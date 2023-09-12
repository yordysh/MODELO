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
$dataCod = $mostrar->MostrarRegistroProduccionPorCodInsumoPDF();
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
    </style>
    <!--------------------------------------- Titulo header --------------------------------------->
    <header>
        <table>
            <tbody>
                <tr>
                    <!-- <td rowspan="4" style="text-align: center;"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/MODELO/control_alimento/images/logo-covifarmaRecorte.png" alt=""></td> -->
                    <!-- <td rowspan="4" class="cabecera"><img src="http://192.168.1.102/SISTEMA/control_alimento/images/logo-covifarmaRecorte.png" alt=""></td> -->
                    <td rowspan="4" style="text-align: center;"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/logo-covifarmaRecorte.png')); ?>" alt=""></td>
                    <td rowspan="4" style="text-align: center; font-size:30px; font-weigth:200;">REGISTRO DE ENVASES - <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
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

    <?php
    foreach ($dataCod as $filas) {


        echo '<table style="margin-top: 50px;">';
        echo '<tbody>';

        echo '<tr>';
        echo '<td colspan="2" class="tdcentrado">FECHA:</td>';
        echo '<td colspan="2" class="tdcentrado">' . $filas->FECHA . '</td>';
        echo '<td colspan="2" class="tdcentrado">N° BACHADA</td>';
        echo '<td colspan="2" class="tdcentrado">' . $filas->N_BACHADA . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td class="tdcentrado">PRODUCTO</td>';
        echo '<td class="tdcentrado">' . $filas->NUM_PRODUCION_LOTE . '</td>';
        echo '<td class="tdcentrado">PRESENTACION</td>';
        echo '<td class="tdcentrado">' . $filas->DES_PRODUCTO . '</td>';
        echo '<td class="tdcentrado">CANTIDAD(Unid.)</td>';
        echo '<td class="tdcentrado">' . $filas->CANTIDAD . '</td>';
        echo '<td class="tdcentrado">RECIBIDO POR</td>';
        echo '<td class="tdcentrado">FIRMA</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="2" class="tdcentrado">MATERIALES ENVASES/OTROS</td>';
        echo '<td colspan="2" class="tdcentrado">CANTIDAD(Unid.)</td>';
        echo '<td  colspan="2" class="tdcentrado">LOTE</td>';
        echo '<td style="border-bottom:none; border-right:none;"></td>';
        echo '<td style="border-bottom:none; "></td>';
        echo '</tr>';


        foreach ($datos as $filadata) {
            if ($filadata->COD_AVANCE_INSUMOS == $filas->COD_AVANCE_INSUMOS) {
                echo '<tr>';
                echo '<td colspan="2" class="tdcentrado-bold">' . $filadata->DES_PRODUCTO . '</td>';
                echo '<td colspan="2" class="tdcentrado-bold">' . $filadata->CANTIDAD . '</td>';
                echo '<td colspan="2" class="tdcentrado-bold">' . $filadata->LOTE . '</td>';
                echo '<td style="border-bottom:none; border-top:none;"></td>';
                echo '<td style="border-bottom:none; border-top:none;"></td>';
                echo '</tr>';
            }
        }
        echo '<tr>';
        echo '<td colspan="2" style="border-bottom:none; border-left:none; border-right:none;"></td>';
        echo '<td colspan="2" style="border-bottom:none; border-left:none; border-right:none;"></td>';
        echo '<td colspan="2" style="border-bottom:none; border-left:none; border-right:none;"></td>';
        echo '< style="border-bottom:none; border-left:none; border-right:none:none;"></td>';
        echo '<td style="border-bottom:none; border-left:none; border-right:none;"></td>';
        echo '<td style="border-bottom:none; border-left:none; border-right:none;"></td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '<table style="margin-top:30px;">';
        echo '<tr>';
        echo '<td style="padding-left:180px;">Observaciones:</td>';
        echo '<td style="padding-left:400px;padding-rigth:50px;"></td>';
        echo '<td style="border:none; padding-left:600px;"></td>';
        echo '<td style="padding-left:280px;">Acciones correctivas:</td>';
        echo '<td style="padding-left:300px; padding-rigth:80px;"></td>';
        echo '</tr>';
        echo '</table>';
    }
    ?>

</body>

</html>