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



$grupos = array();

foreach ($datos as $fila) {
    $nombreZona = $fila['NOMBRE_T_ZONA_AREAS'];
    $nombreInfraestructura = $fila['NOMBRE_INFRAESTRUCTURA'];
    $estado = $fila['ESTADO'];
    $fechaTotal = $fila['FECHA_TOTAL'];

    if (!isset($grupos[$nombreZona])) {
        $grupos[$nombreZona] = array();
    }

    // Agregar la condición para omitir los estados 'P'
    if ($estado != 'P') {
        $grupos[$nombreZona][] = array(
            'nombreInfraestructura' => $nombreInfraestructura,
            'estado' => $estado,
            'fechaTotal' => $fechaTotal
        );
    }
}

foreach ($grupos as $nombreZona => $valores) {
    $html .= '<tr>';
    $html .= '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';
    $html .= '<td>' . $valores[0]['nombreInfraestructura'] . '</td>';

    // Obtener el mes y año de fechaTotal del primer valor
    $fechaTotal = new DateTime($valores[0]['fechaTotal']);
    $mes = $fechaTotal->format('m');
    $anio = $fechaTotal->format('Y');

    // Imprimir columnas para los días del mes
    for ($dia = 1; $dia <= 31; $dia++) {
        $html .= '<td>' . ($mes == $fechaTotal->format('m') && $anio == $fechaTotal->format('Y') && $dia == $fechaTotal->format('d') ? $valores[0]['estado'] : '') . '</td>';
    }

    $html .= '</tr>';

    for ($j = 1; $j < count($valores); $j++) {
        $html .= '<tr>';
        $html .= '<td>' . $valores[$j]['nombreInfraestructura'] . '</td>';

        // Obtener el mes y año de fechaTotal del valor actual
        $fechaTotal = new DateTime($valores[$j]['fechaTotal']);
        $mes = $fechaTotal->format('m');
        $anio = $fechaTotal->format('Y');

        // Imprimir columnas para los días del mes
        for ($dia = 1; $dia <= 31; $dia++) {
            $html .= '<td>' . ($mes == $fechaTotal->format('m') && $anio == $fechaTotal->format('Y') && $dia == $fechaTotal->format('d') ? $valores[$j]['estado'] : '') . '</td>';
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
