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
$data = $mostrar->MostrarLimpiezaPDF($anioSeleccionado, $mesSeleccionado);
$dataLimpieza = $mostrar->MostrarLimpiezaPD();
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

        .cabecera-valores {
            background-color: #cee6ba;
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
    </style>
    <!-- Table titulo-->
    <table style="margin-bottom: 50px;">
        <tbody>
            <tr>
                <td rowspan="4" class="cabecera"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/MASTER/images/logo-covifarmaRecorte.png" alt=""></td>
                <td rowspan="4" style="text-align: center;">LIMPIEZA Y DESINFECCIÓN DE UTENSILIOS DE LIMPIEZA - <?php echo ($mesConvert . ' ' . $anioSeleccionado); ?> </td>
                <td>LBS-PHS-FR-04</td>

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
            <tr>
                <td class="cabecera-fila" rowspan="2">ÁREA</td>
                <td class="cabecera-fila" rowspan="2">ÍTEM</td>
                <td class="cabecera-fila" colspan="30">VERIFICACIÓN DE LA LIMPIEZA Y DESINFECCIÓN DE UTENSILIOS PARA HEGIENIZACIÓN</td>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
                <td>11</td>
                <td>12</td>
                <td>13</td>
                <td>14</td>
                <td>15</td>
                <td>16</td>
                <td>17</td>
                <td>18</td>
                <td>19</td>
                <td>20</td>
                <td>21</td>
                <td>22</td>
                <td>23</td>
                <td>24</td>
                <td>25</td>
                <td>26</td>
                <td>27</td>
                <td>28</td>
                <td>29</td>
                <td>30</td>
            </tr>
            <tr>
                <?php
                $grupos = array();

                foreach ($dataLimpieza as $filas) {

                    $nombreZona = $filas['NOMBRE_T_ZONA_AREAS'];
                    $nombreFrecuencia = $filas['NOMBRE_FRECUENCIA'];
                    $fecha = $filas['FECHA'];

                    if (!isset($grupos[$nombreZona])) {
                        $grupos[$nombreZona] = array();
                    }
                    // $grupos[$nombreZona][] = $nombreFrecuencia;
                    $grupos[$nombreZona][] = array(
                        'nombreFrecuencia' => $nombreFrecuencia,
                        'fecha' => $fecha
                    );
                }


                foreach ($grupos as $nombreZona => $frecuencias) {
                    echo "<tr>";
                    echo "<td rowspan='" . count($frecuencias) . "'>" . $nombreZona . "</td>";

                    foreach ($frecuencias as $indice => $frecuencia) {
                        var_dump($frecuencia);
                        if ($indice > 0) {
                            echo "<tr>";
                        }
                        echo "<td>" . $frecuencia['nombreFrecuencia'] . "</td>";

                        // Crear array con columnas de acuerdo a la FECHA_TOTAL
                        // $fecha = $dataLimpieza[$nombreZona][$frecuencia]['FECHA'];
                        // $numeroDiasMes = date('t', strtotime($fecha));
                        // $columnasFechaTotal = $numeroDiasMes;
                        // $dias = date('d', strtotime($fecha));
                        // $diasConver = intval($dias);

                        // $columnas = array();

                        // for ($i = 1; $i <= $columnasFechaTotal; $i++) {

                        //     if ($i == $diasConver) {
                        //         $columnas[$i] = '';
                        //     } else {
                        //         $columnas[$i] = '';
                        //     }
                        // }
                        // // Imprimir los estados en las columnas correspondientes
                        // foreach ($columnas as $columna) {

                        //     echo '<td class="cabecera">' . $columna . '</td>';
                        // }
                        // //Colocar este td para que rellene de responsable de ejecucion
                        // echo '<td></td>';
                        // if ($indice !== 0) {
                        //     echo '</tr>';
                        // }
                        echo "</tr>";
                    }
                }
                ?>

            </tr>
        </tbody>
    </table>


</body>

</html>