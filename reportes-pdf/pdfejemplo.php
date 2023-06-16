<?php
require_once '../assets/DomPDF/autoload.inc.php';

require_once "../php/registrar.php";
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

foreach ($datos as $fila) {
    $html .= '<tr>
    <td >' . $fila->NOMBRE_T_ZONA_AREAS .  '</td>
    <td>' . $fila->NOMBRE_INFRAESTRUCTURA .  '</td>
    </tr>';
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
