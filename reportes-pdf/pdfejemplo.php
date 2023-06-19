<?php

require_once '../assets/DomPDF/autoload.inc.php';

require_once "../php/m_almacen.php";
// require_once "../funciones/f_funcion.php";

$mostrar = new m_almacen();
$datos = $mostrar->MostrarInfraestructuraPDF();


// Generar el contenido HTML
$html = '<html>';
$html .= '<head><style>table {border-collapse: collapse;} td, th {border: 1px solid black; padding: 5px;}</style></head>';
$html .= '<body>';
$html .= '<table>';
//$html .= '<thead><tr><th>Columna 1</th></tr></thead>';
$html .= '<tbody>';


// $grupos = array();

// foreach ($datos as $fila) {
//     $nombreZona = $fila['NOMBRE_T_ZONA_AREAS'];
//     $nombreInfraestructura = $fila['NOMBRE_INFRAESTRUCTURA'];
//     $estado = $fila['ESTADO'];
//     $fechaTotal = $fila['FECHA_TOTAL'];

//     if (!isset($grupos[$nombreZona])) {
//         $grupos[$nombreZona] = array();
//     }

//     $grupos[$nombreZona][] = array(
//         'nombreInfraestructura' => $nombreInfraestructura,
//         'estado' => $estado,
//         'fechaTotal' => $fechaTotal
//     );
// }

// foreach ($grupos as $nombreZona => $valores) {
//     $html .= '<tr>';
//     $html .= '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';
//     $html .= '<td>' . $valores[0]['nombreInfraestructura'] . '</td>';
//     $html .= '<td>' . $valores[0]['estado'] . '</td>';
//     // $html .= '<td>' . ($valores[0]['fechaTotal'] !== null && $valores[0]['fechaTotal'] != "" ? $valores[0]['fechaTotal'] : '') . '</td>';
//     $html .= '</tr>';

//     for ($i = 1; $i < count($valores); $i++) {
//         $html .= '<tr>';
//         $html .= '<td>' . $valores[$i]['nombreInfraestructura'] . '</td>';
//         $html .= '<td>' . $valores[$i]['estado'] . '</td>';
//         // $html .= '<td>' . ($valores[$i]['fechaTotal'] !== null && $valores[$i]['fechaTotal'] != "" ? $valores[$i]['fechaTotal'] : '') . '</td>';
//         $html .= '</tr>';
//     }
// }

$grupos = array();

foreach ($datos as $fila) {
    $nombreZona = $fila['NOMBRE_T_ZONA_AREAS'];
    $nombreInfraestructura = $fila['NOMBRE_INFRAESTRUCTURA'];
    $estado = $fila['ESTADO'];
    $fechaTotal = $fila['FECHA_TOTAL'];

    if (!isset($grupos[$nombreZona])) {
        $grupos[$nombreZona] = array();
    }

    $grupos[$nombreZona][] = array(
        'nombreInfraestructura' => $nombreInfraestructura,
        'estado' => $estado,
        'fechaTotal' => $fechaTotal
    );
}

// foreach ($grupos as $nombreZona => $valores) {
//     $html .= '<tr>';
//     $html .= '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';
//     $html .= '<td>' . $valores[0]['nombreInfraestructura'] . '</td>';
//     $html .= '<td>' . $valores[0]['estado'] . '</td>';

//     // Obtener el mes y año de fechaTotal del primer valor
//     $fechaTotal = new DateTime($valores[0]['fechaTotal']);
//     $mes = $fechaTotal->format('m');
//     $anio = $fechaTotal->format('Y');

//     // Obtener el último día del mes
//     $ultimoDiaMes = (new DateTime($anio . '-' . $mes . '-01'))->format('t');

//     // Imprimir columnas adicionales a partir de la columna 4
//     for ($i = 4; $i <= ($ultimoDiaMes + 3); $i++) {
//         $html .= '<td>' . ($i - 3) . '</td>';
//     }

//     $html .= '</tr>';

//     for ($j = 1; $j < count($valores); $j++) {
//         $html .= '<tr>';
//         $html .= '<td>' . $valores[$j]['nombreInfraestructura'] . '</td>';
//         $html .= '<td>' . $valores[$j]['estado'] . '</td>';

//         // Obtener el mes y año de fechaTotal del valor actual
//         $fechaTotal = new DateTime($valores[$j]['fechaTotal']);
//         $mes = $fechaTotal->format('m');
//         $anio = $fechaTotal->format('Y');

//         // Obtener el último día del mes
//         $ultimoDiaMes = (new DateTime($anio . '-' . $mes . '-01'))->format('t');

//         // Imprimir columnas adicionales a partir de la columna 4
//         for ($k = 4; $k <= ($ultimoDiaMes + 3); $k++) {
//             $html .= '<td>' . ($k - 3) . '</td>';
//         }



//         $html .= '</tr>';
//     }
// }
foreach ($grupos as $nombreZona => $valores) {
    $html .= '<tr>';
    $html .= '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';
    $html .= '<td>' . $valores[0]['nombreInfraestructura'] . '</td>';
    $html .= '<td>' . $valores[0]['estado'] . '</td>';

    // Obtener el mes y año de fechaTotal del primer valor
    $fechaTotal = new DateTime($valores[0]['fechaTotal']);
    $mes = $fechaTotal->format('m');
    $anio = $fechaTotal->format('Y');

    // Obtener el último día del mes
    $ultimoDiaMes = (new DateTime($anio . '-' . $mes . '-01'))->format('t');

    // Calcular el número total de columnas
    $numColumnas = 3 + $ultimoDiaMes;

    // Imprimir columnas adicionales a partir de la columna 4
    for ($i = 4; $i <= $numColumnas; $i++) {
        $html .= '<td>' . ($i - 3) . '</td>';
    }

    // Completar las columnas faltantes hasta 31 días
    for ($i = $numColumnas + 1; $i <= 34; $i++) {
        $html .= '<td></td>';
    }

    $html .= '</tr>';

    for ($j = 1; $j < count($valores); $j++) {
        $html .= '<tr>';
        $html .= '<td>' . $valores[$j]['nombreInfraestructura'] . '</td>';
        $html .= '<td>' . $valores[$j]['estado'] . '</td>';

        // Obtener el mes y año de fechaTotal del valor actual
        $fechaTotal = new DateTime($valores[$j]['fechaTotal']);
        $mes = $fechaTotal->format('m');
        $anio = $fechaTotal->format('Y');

        // Obtener el último día del mes
        $ultimoDiaMes = (new DateTime($anio . '-' . $mes . '-01'))->format('t');

        // Calcular el número total de columnas
        $numColumnas = 3 + $ultimoDiaMes;

        // Imprimir columnas adicionales a partir de la columna 4
        for ($k = 4; $k <= $numColumnas; $k++) {
            $html .= '<td>' . ($k - 3) . '</td>';
        }

        // Completar las columnas faltantes hasta 31 días
        for ($k = $numColumnas + 1; $k <= 34; $k++) {
            $html .= '<td></td>';
        }

        $html .= '</tr>';
    }
}







$html .= '</tbody>';
$html .= '</table>';
$html .= '</body>';
$html .= '</html>';


// Generar el PDF con DOMPDF
$dompdf = new Dompdf\Dompdf();
$dompdf->loadHtml($html);

// Set the paper size and orientation
$dompdf->setPaper('A2', 'landscape');

$dompdf->render();

// Guardar el PDF en una ubicación deseada
$dompdf->stream('tabla.pdf', array('Attachment' => 0));
