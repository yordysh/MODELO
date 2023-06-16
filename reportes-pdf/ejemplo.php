<?php
require_once '../assets/DomPDF/autoload.inc.php';

use Dompdf\Dompdf;

$num_filas = 7; // Número total de filas
$rowspan_variable = 2; // Valor variable para rowspan
$rowspan = 3; // Valor variable para rowspan

// Crea una instancia de Dompdf
$dompdf = new Dompdf();

$html = '<table>';
for ($i = 1; $i <= $num_filas; $i++) {
    $html .= '<tr>';
    if ($rowspan_variable) {
        if ($i === 1 || ($i - 1) % $rowspan_variable === 0) {
            $html .= "<td rowspan=\"$rowspan_variable\">FilaX $i</td>";
            for ($j = 1; $j < 7; $j++) {
                $html .= "<td >FilaJ $j</td>";
            }
        } else {
            for ($j = 1; $j < 7; $j++) {
                $html .= "<td >Fila $j</td>";
            }
            // $html .= "<td>Filax $i</td>";
        }
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
