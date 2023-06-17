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

    if (!isset($grupos[$nombreZona])) {
        $grupos[$nombreZona] = array();
    }

    $grupos[$nombreZona][] = $nombreInfraestructura;
}

foreach ($grupos as $nombreZona => $valores) {
    $html .= '<tr>';
    $html .= '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';
    $html .= '<td>' . $valores[0] . '</td>';
    $html .= '</tr>';

    for ($i = 1; $i < count($valores); $i++) {
        $html .= '<tr>';
        $html .= '<td>' . $valores[$i] . '</td>';
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
$dompdf->render();

// Guardar el PDF en una ubicación deseada
$dompdf->stream('tabla.pdf', array('Attachment' => 0));
