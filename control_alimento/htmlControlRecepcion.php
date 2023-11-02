<?php
require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

// $anioSeleccionado = $_GET['anio'];
// $mesSeleccionado = $_GET['mes'];

$mostrar = new m_almacen();
$nombre = 'LBS-BPM-Fr-09';
$versionMuestraFecha = $mostrar->MostrarVersionGeneralFecha($nombre);
$fechaDateTime = new DateTime($versionMuestraFecha);
$anio = $fechaDateTime->format('Y');
$mesExtra = intval($fechaDateTime->format('m'));
// /*convierte el valor en enetero*/
// $mesNumerico = intval($mesSeleccionado);

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
// $mesConvert = $mesesEnLetras[$mesNumerico];
$mesversion = $mesesEnLetras[$mesExtra];


$datos = $mostrar->MostrarControlRecepcionPDF($anioSeleccionado, $mesSeleccionado);
// $versionMuestra = $mostrar->VersionMostrar();
$versionMuestra = $mostrar->MostrarVersionGeneral($nombre);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="http://192.168.1.102/SISTEMA/control_alimento/images/icon/covifarma-ico.ico" type="images/png">
    <title>Control y recepcion</title>
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
        }

        .cabecera-valores {
            background-color: #cee6ba;
            text-align: center;
            font-weight: 200;
            font-size: 20px;
        }

        .cabecera-fila td,
        .cabecera {
            text-align: center;
        }

        .column-1:nth-child(1),
        .column-2:nth-child(2) {
            width: 320px;

        }

        .mover-derecha {
            padding-left: 20px;
        }

        td.cabecera-fila {
            width: 30px;
            height: 30px;
        }

        .tdFecha::after {
            content: '';
            position: absolute;
            width: 120px;
            height: 0.5px;
            background-color: black;
            margin-top: 15px;
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

        .cabeceraPreparacion {
            text-align: center;
            max-width: 10px;
        }

        .checkmark {
            color: green;
            font-size: 20px;
        }

        .cross {
            color: red;
            font-size: 20px;
        }
    </style>
    <!-- Table titulo-->
    <header>
        <table>
            <tbody>
                <tr>
                    <td rowspan="4" class="cabecera"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/logo-covifarmaRecorte.png')); ?>" alt=""></td>
                    <td rowspan="4" style="text-align: center; font-size:25px; font-weight:200;"> CONTROL DE RECEPCIÓN DE MATERIA PRIMA E INSUMOS </td>
                    <td>LBS-BPM-FR-09</td>

                </tr>
                <tr>
                    <td>Versión: <?php echo $versionMuestra ?> </td>
                    <!-- <td>Versión: </td> -->
                </tr>
                <tr>
                    <td>Página:</td>
                </tr>

                <tr>
                    <td>Fecha: <?php echo ($mesversion . ' ' . $anio); ?> </td>
                    <!-- <td>Fecha:</td> -->
                </tr>


            </tbody>
        </table>
    </header>

    <!-- Table solucion y preparaciones-->
    <table style="margin-top: 10px;">
        <thead>
            <tr>
                <th rowspan="2">FECHA DE INGRESO</th>
                <th rowspan="2">HORA</th>
                <th rowspan="2">PRODUCTO</th>
                <th rowspan="2">CÓDIGO DE LOTE</th>
                <th rowspan="2">F.V</th>
                <th rowspan="2">PROVEEDOR</th>
                <th colspan="3" style="width: 30px;">GUÍA/BOLETA/ FACTURA</th>
                <th rowspan="2">N° GUÍA,BOLETA O FACTURA</th>
                <th colspan="2">Empaque</th>
                <th colspan="4">Presentación</th>
                <th rowspan="2">CANTIDAD (kg)</th>
                <th colspan="3">CONTROL DEL PRODUCTO</th>
                <th colspan="3">DEL PERSONAL DE TRANSPORTE</th>
                <th colspan="4">CONDICIONES DEL TRANSPORTE</th>
                <th rowspan="2">V°B°</th>
            </tr>
            <tr>
                <th class="vertical-text">G.Remisión</th>
                <th class="vertical-text">Boleta</th>
                <th class="vertical-text">Factura</th>
                <th class="vertical-text">Primario</th>
                <th class="vertical-text">Secundario</th>
                <th class="vertical-text">Saco</th>
                <th class="vertical-text">Caja</th>
                <th class="vertical-text">Cilindro</th>
                <th class="vertical-text">bolsa</th>
                <th class="vertical-text">Envase integro/ hermético</th>
                <th class="vertical-text">Certificado de calidad</th>
                <th class="vertical-text">Rotulación conforme</th>
                <th class="vertical-text">Aplicación de las BPD</th>
                <th class="vertical-text">Higiene & salud</th>
                <th class="vertical-text">Indumentaria completa y limpia</th>
                <th class="vertical-text">Limpio</th>
                <th class="vertical-text">Exclusivo</th>
                <th class="vertical-text">Hermético</th>
                <th class="vertical-text">Ausencia de plagas</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <!-- tabla de instrucciones-->
    <table>
        <tr>
            <td style="border:none;"><strong>Colocar:Conforme:</strong> <span class="checkmark">&#10004;</span>,
                <strong>No Conforme:</strong> <span class="cross">&#10006;</span>, <strong>Frecuencia:</strong> Cada recepción de materia,insumos,envases y embalajes.
                Indumentaria de la empresa:Polo,camisao casaca de la empresa,mascarilla.
                Salud: Sin enfermedades, sin cortes o heridas,
                Higiene: Cabello corto, rasurado,uñas cortas, sin objetos(anillos,aretes,etc)
            </td>
        </tr>
        <tr>
            <td style="border:none;padding-left: 85px;"><strong>ACCIÓN CORRECTIVA:</strong> Al detectar incumplimiento se procederá a corregir la observación.</td>
        </tr>
    </table>
    <!-------------------------->
    <!-- Table Observacion y otros-->
    <table style="margin-top: 5px;">
        <thead>
            <tr>
                <th>FECHA</th>
                <th>OBSERVACIÓN</th>
                <th>ACCIONES CORRECTIVA</th>
                <th>SUPERVISADO POR:</th>
            </tr>
        </thead>
        <tbody>
            <?php

            // foreach ($datos as $fils) {
            //     echo '<tr>';
            //     echo '<td class="cabecera">' . convFecSistema($fils['FECHA']) . '</td>';
            //     echo '<td class="cabecera">' . $fils['OBSERVACION'] . '</td>';
            //     echo '<td class="cabecera">' . $fils['ACCION_CORRECTIVA'] . '</td>';
            //     echo '<td class="cabecera">' . $fils['VERIFICACION'] . '</td>';
            //     echo '<td></td>';
            //     echo '</tr>';
            // }
            ?>

        </tbody>
    </table>
    <!-- Table firma y fecha-->
    <table style="margin-top: 50px; border:none;">
        <tr>
            <td style="padding-left: 500px; border:none;"></td>
            <td style="padding-left: 200px; border:none;"></td>
            <td style="padding-left: 200px; border-left: none; border-bottom:none; border-right: none; font-weight: 300; font-size:17px;">JEFE DE ASEGURAMIENTO DE LA CALIDAD</td>
            <td style="padding-left: 700px; border:none;"></td>
        </tr>
        <tr>
            <td style="padding-left: 500px; border:none;"></td>
            <td style="padding-left: 200px; border:none;"></td>
            <td class="tdFecha" style="margin-top:10px; padding-left: 300px; border:0; display:inline-block; font-weight: 300; font-size:17px;">Fecha: </td>
            <td style="padding-left: 700px; border:none;"></td>
        </tr>
    </table>
</body>

</html>