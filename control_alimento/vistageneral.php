<?php
session_start();

require_once "m_almacen.php";

$mostrar = new m_almacen();
$data = $mostrar->MostrarAlerta();

$fechaactualservidor = $mostrar->c_horaserversql('F');


// $fechaactual = date("d-m-Y");
// $diastotales = date('t', strtotime($fechaactual));

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
        <div id="tablaalerta" class="">
            <table id="tbalerta" class="table table-sm mb-3 table-hover">
                <?php
                echo '<thead>';
                echo '<tr>';
                echo '<th class="thtitulo" scope="col">ZONA</th>';
                echo '<th class="thtitulo" scope="col">INFRAESTRUCTURA</th>';
                echo '<th class="thtitulo" scope="col">FRECUENCIA</th>';
                echo '<th class="thtitulo" scope="col">FECHA ANTERIOR</th>';
                echo '<th class="thtitulo" scope="col">' . $fechaactualservidor . '</th>';
                echo '<th class="thtitulo" scope="col">OBSERVACION</th>';
                echo '<th class="thtitulo" scope="col">ACCION CORRECTIVA</th>';
                echo '<th class="thtitulo" scope="col">V°B°</th>';
                echo '</tr>';

                echo '</thead>';
                echo '<tbody id="tablaalerta">';



                foreach ($data as $datostotales) {
                    $codigoalerta = $datostotales->COD_ALERTA;
                    $codigozona = $datostotales->COD_ZONA;
                    $zona = $datostotales->NOMBRE_AREA;
                    $codigoinfra = $datostotales->COD_INFRAESTRUCTURA;
                    $infraestructura = $datostotales->NOMBRE_INFRAESTRUCTURA;
                    $frecuencia = $datostotales->NDIAS;
                    $frecuenciadias = $datostotales->NDIAS;
                    $fechacreacion = $datostotales->FECHA_CREACION;
                    $fecha = $datostotales->FECHA_TOTAL;
                    $estadoverifica = $datostotales->ESTADO;

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
                        $datos_por_zona[$zona][] = array('codigozona' => $codigozona, 'codigoinfra' => $codigoinfra, 'infraestructura' => $infraestructura, 'frecuencia' => $frecuencianombre, 'fechacreacion' => $fechacreacion, 'codigoalerta' => $codigoalerta, 'frecuenciadias' => $frecuenciadias, 'estadoverifica' => $estadoverifica);
                    } else {

                        $datos_por_zona[$zona] = array(array('codigozona' => $codigozona, 'codigoinfra' => $codigoinfra, 'infraestructura' => $infraestructura, 'frecuencia' => $frecuencianombre, 'fechacreacion' => $fechacreacion, 'codigoalerta' => $codigoalerta, 'frecuenciadias' => $frecuenciadias, 'estadoverifica' => $estadoverifica));
                    }
                }

                foreach ($datos_por_zona as $zona => $datos) {
                    echo '<tr>';
                    echo '<td ><input class="codigozona" type="text" value="' . $datos[0]['codigozona'] . '" /></td>';
                    echo '<td ><input class="codigoinfra" type="text" value="' . $datos[0]['codigoinfra'] . '" /></td>';
                    echo '<td ><input class="codigoalerta" type="text" value="' . $datos[0]['codigoalerta'] . '" /></td>';
                    echo '<td ><input class="frecuenciadias" type="text" value="' . $datos[0]['frecuenciadias'] . '" /></td>';
                    echo '<td ><input class="estadoverifica" type="text" value="' . $datos[0]['estadoverifica'] . '" /></td>';

                    echo '<td rowspan="' . count($datos) . '">' . $zona . '</td>';
                    echo '<td >' . $datos[0]['infraestructura'] . '</td>';
                    echo '<td>' . $datos[0]['frecuencia'] . '</td>';
                    echo '<td>' . $datos[0]['fechacreacion'] . '</td>';
                    echo '<td><input class="check" type="checkbox"/></td>';
                    echo '<td><textarea class="form-control observacion" id="observacion" rows="2"></textarea></td>';
                    echo '<td><textarea class="form-control accioncorrectiva" id="accioncorrectiva" rows="2"></textarea></td>';
                    echo '<td>
                    <select id="selectVerificacion" class="form-select selectVerificacion" style="width:150px;" aria-label="Default select example">
                            <option selected>Seleccione V°B</option>
                            <option value="1">J.A.C</option>
                            <option value="2">A.A.C</option>
                    </select></td>';

                    echo '</tr>';

                    for ($i = 1; $i < count($datos); $i++) {
                        echo '<tr>';
                        echo '<td ><input class="codigozona" type="text" value="' . $datos[$i]['codigozona'] . '" /></td>';
                        echo '<td ><input class="codigoinfra" type="text" value="' . $datos[$i]['codigoinfra'] . '" /></td>';
                        echo '<td ><input class="codigoalerta" type="text" value="' . $datos[$i]['codigoalerta'] . '" /></td>';
                        echo '<td ><input class="frecuenciadias" type="text" value="' . $datos[$i]['frecuenciadias'] . '" /></td>';
                        echo '<td ><input class="estadoverifica" type="text" value="' . $datos[$i]['estadoverifica'] . '" /></td>';


                        echo '<td style="visibility:collapse; display:none;"></td>';
                        echo '<td>' . $datos[$i]['infraestructura'] . '</td>';

                        echo '<td>' . $datos[$i]['frecuencia'] . '</td>';
                        echo '<td>' . $datos[$i]['fechacreacion'] . '</td>';
                        echo '<td><input class="check" type="checkbox"/></td>';
                        echo '<td><textarea class="form-control observacion" id="observacion" rows="2"></textarea></td>';
                        echo '<td><textarea class="form-control accioncorrectiva" id="accioncorrectiva" rows="2"></textarea></td>';
                        echo '<td>
                                 <select id="selectVerificacion" class="form-select selectVerificacion" style="width:150px;" aria-label="Default select example">
                                     <option selected>Seleccione V°B°</option>
                                     <option value="1">J.A.C</option>
                                     <option value="2">A.A.C</option>
                                 </select></td>';
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