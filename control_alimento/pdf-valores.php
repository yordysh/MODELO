<?php

ob_start();
include "htmllistamaestra.php";

$html = ob_get_clean();

require_once '../DomPDF/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();

$options = new Options();

$options->setIsRemoteEnabled(true);
$options->set('isPhpEnabled', true);
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');


$dompdf->render();
$canvas = $dompdf->getCanvas();
$font = $dompdf->getFontMetrics()->get_font("Arial", "normal");
$canvas->page_text(1325, 80, "{PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0, 0, 0));

// if ($dompdf) {
//     $dompdf->stream('Registro-envases.pdf', array('Attachment' => 0));
// } else {
//     $dompdf->stream('Registro-envases.pdf', array('Attachment' => false));
// }
if ($dompdf) {
    $output = $dompdf->output();
    file_put_contents('Registro-envases.pdf', $output);
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="Registro-envases.pdf"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');

    echo $output;
} else {
    echo 'Error generating PDF';
}
