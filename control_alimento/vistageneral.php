<?php
session_start();

require_once "m_almacen.php";

$mostrar = new m_almacen();
$data = $mostrar->MostrarAlerta();

$fechaactual = date("d-m-Y");
$diastotales = date('t', strtotime($fechaactual));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="shortcut icon" href="./images/icon/covifarma-ico.ico" type="images/png">
    <link rel="stylesheet" href="./styleIcons/style.css">
    <link rel="stylesheet" href="./css/responsiveInfra.css">
    <title>Document</title>
</head>

<body>
    <main>
        <div id="tablaalerta" class="table-responsive " style="overflow: scroll;height: 800px; margin-top:20px; margin-bottom:30px;">
            <table id="tbalerta" class="table table-sm mb-3 table-hover">
                <?php
                echo '<thead>';
                echo '<tr>';
                echo '<th class="thtitulo" scope="col" rowspan="2">ZONA</th>';
                echo '<th class="thtitulo" scope="col" rowspan="2">INFRAESTRUCTURA</th>';
                echo '<th class="thtitulo" scope="col" rowspan="2">FRECUENCIA</th>';
                echo '<th class="thtitulo" scope="col" colspan="' . $diastotales . '">Dias</th>';
                echo '</tr>';
                echo '<tr>';
                for ($d = 1; $d <= $diastotales; $d++) {
                    echo '<th style="witdh:10px;">' . $d . '</th>';
                }
                echo '</tr>';
                echo '</thead>';
                echo '<tbody id="tablaalerta">';

                // Creamos un array para almacenar los datos agrupados por zona
                $datos_por_zona = array();

                foreach ($data as $datostotales) {
                    $codigozona = $datostotales->COD_ZONA;
                    $zona = $datostotales->NOMBRE_AREA;
                    $codigoinfra = $datostotales->COD_INFRAESTRUCTURA;
                    $infraestructura = $datostotales->NOMBRE_INFRAESTRUCTURA;
                    $frecuencia = $datostotales->NDIAS;
                    $fecha = $datostotales->FECHA_TOTAL;
                    $timestamp = strtotime($fecha);
                    $dia = date("d", $timestamp);

                    if ($frecuencia == '1') {
                        $frecuencianombre = 'Diario';
                    } elseif ($frecuencia == '2') {
                        $frecuencianombre = 'Inter-diario';
                    } elseif ($frecuencia == '7') {
                        $frecuencianombre = 'Semanal';
                    } elseif ($frecuencia == '15') {
                        $frecuencianombre = 'Quincenal';
                    } elseif ($frecuencia == '30') {
                        $frecuencianombre = 'Mensual';
                    }


                    if (isset($datos_por_zona[$zona])) {
                        // Si existe, simplemente agregamos los datos a la zona existente
                        $datos_por_zona[$zona][] = array('codigozona' => $codigozona, 'codigoinfra' => $codigoinfra, 'infraestructura' => $infraestructura, 'frecuencia' => $frecuencianombre, 'dia' => $dia);
                    } else {

                        $datos_por_zona[$zona] = array(array('codigozona' => $codigozona, 'codigoinfra' => $codigoinfra, 'infraestructura' => $infraestructura, 'frecuencia' => $frecuencianombre, 'dia' => $dia));
                    }
                }

                // Generamos la tabla a partir de los datos almacenados
                foreach ($datos_por_zona as $zona => $datos) {
                    echo '<tr>';
                    echo '<td rowspan="' . count($datos) . '">' . $zona . '</td>';

                    // Imprimimos la primera fila de datos para la zona
                    echo '<td codigozona="' . $datos[0]['codigozona'] . '" codigoinfra="' . $datos[0]['codigoinfra'] . '">' . $datos[0]['infraestructura'] . '</td>';
                    echo '<td>' . $datos[0]['frecuencia'] . '</td>';

                    for ($c = 1; $c <= $diastotales; $c++) {
                        if ($c == $datos[0]['dia']) {
                            echo '<td><input type="checkbox"/></td>';
                        } else {
                            echo '<td></td>';
                        }
                    }

                    echo '</tr>';

                    // Imprimimos las filas restantes para la zona (si las hay)
                    for ($i = 1; $i < count($datos); $i++) {
                        echo '<tr>';
                        echo '<td codigozona="' . $datos[0]['codigozona'] . '" codigoinfra="' . $datos[0]['codigoinfra'] . '">' . $datos[$i]['infraestructura'] . '</td>';
                        echo '<td>' . $datos[$i]['frecuencia'] . '</td>';
                        for ($c = 1; $c <= $diastotales; $c++) {
                            if ($c == $datos[$i]['dia']) {
                                echo '<td><input type="checkbox"/></td>';
                            } else {
                                echo '<td>' . $c . '</td>';
                            }
                        }
                        echo '</tr>';
                    }
                }


                echo '</tbody>';
                ?>
            </table>
        </div>
        <div class="btonguardar">
            <input type="hidden" id="task">
            <button id="botonalertaguardar" type="submit" name="insert" class="btn btn-primary estiloboton">Guardar </button>
        </div>
    </main>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.7.0.min.js"></script>
    <script src="./js/sweetalert2.all.min.js"></script>
    <script src="./js/alerta.js"></script>
</body>

</html>