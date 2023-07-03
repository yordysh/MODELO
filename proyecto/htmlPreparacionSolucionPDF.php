<?php
require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

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
$datos = $mostrar->MostrarPreparacionSolucionPDF($anioSeleccionado, $mesSeleccionado);
$versionMuestra = $mostrar->VersionMostrar();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preparacion y soluciones</title>
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
        }

        .cabecera-fila td,
        .cabecera {
            text-align: center;
        }

        .column-1:nth-child(1),
        .column-2:nth-child(2) {
            width: 320px;

        }

        td.estado-vacio {
            background-color: #f2f2f2;

        }

        td.estado-R {
            background-color: #0a5e9c;
            color: #f2f2f2;
            text-align: center;
            height: 30px;

        }

        td.estado-NR {
            background-color: #E72b3c;
            color: #f2f2f2;
            text-align: center;
            height: 30px;
        }

        td.estado-OB {
            background-color: #F39A11;
            color: #f2f2f2;
            text-align: center;
            height: 30px;
        }

        td.estado-PO {
            background-color: #27a121;
            color: #f2f2f2;
            text-align: center;
            height: 30px;
        }

        .mover-derecha {
            padding-left: 20px;
        }

        .ancho {
            padding-left: 10px;
            border: none;
        }

        .borde {
            border-right: 2.4px solid #000;

        }

        td.cabecera-fila {
            width: 30px;
            height: 30px;
        }
    </style>
    <!-- Table titulo-->
    <table style="margin-bottom: 50px;">
        <tbody>
            <tr>
                <td rowspan="4" class="cabecera"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/MASTER/images/logo-covifarmaRecorte.png" alt=""></td>
                <td rowspan="4" style="text-align: center;">PREPARACIÓN DE SOLUCIÓN DE LIMPIEZA Y DESINFECCIÓN - <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                <td>LBS-PHS-FR-02</td>

            </tr>
            <tr>
                <?php foreach ($versionMuestra as $version) { ?>
                    <td>Versión: <?php echo $version['VERSION'] ?> </td>
                <?php
                }
                ?>

            </tr>
            <tr>
                <td>Página:01</td>
            </tr>
            <tr>
                <td>Fecha: <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
            </tr>


        </tbody>
    </table>

    <!-- Table solucion y preparaciones-->
    <table>
        <tbody>
            <!-- <tr>
                <td class="cabecera-fila " rowspan="2">FECHA DE PREPARACIÓN</td>
                <td>xx</td>
            
            </tr>
            <tr>
                <td class="cabecera-fila ">Hipoclorito de Sodio/Detergente/Desinfectante</td>
                <td>xx</td>
            </tr>
            <tr>
                <td class="cabecera-fila ">Agua(L)</td>
                <td>xx</td>
            </tr> -->
            <tr>
                <th>Columna 1</th>
                <th>Columna 2</th>
            </tr>
            <tr>
                <td>Fila 1,1</td>
                <td rowspan="3">Fila 1,2,1</td>
            </tr>
            <tr>
                <td>Fila 2,1</td>
            </tr>
            <tr>
                <td>Fila 3,1</td>
            </tr>
            <tr>
                <td>Fila 2,1</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>