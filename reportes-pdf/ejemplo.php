<?php
require_once '../assets/DomPDF/autoload.inc.php';

use Dompdf\Dompdf;

$num_filas = 8; // Número total de filas
$rowspan_variable = 4; // Valor variable para rowspan

// Crea una instancia de Dompdf
$dompdf = new Dompdf();


$html = '<table>';
for ($i = 1; $i <= $num_filas; $i++) {
    $html .= '<tr>';

    if ($i === 1 || $i === ($rowspan_variable + 1)) {
        $html .= "<td rowspan=\"$rowspan_variable\">Fila $i</td>";
    } else {
        $html .= "<td>Fila $i</td>";
    }

    $html .= '</tr>';
}
$html .= '</table>';


$dompdf->loadHtml($html);

$dompdf->render();

// Display the PDF in the browser
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="profesionales.pdf"');
header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
header('Pragma: public');
header('Content-Length: ' . $dompdf->output(null, true));

echo $dompdf->output(null, true);
