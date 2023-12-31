<?php

ob_start();
include "htmlRegistroProduccionPDF.php";

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
$dompdf->setPaper('A4', 'portrait');
// $options->set('margin-top', '10mm');
// $options->set('margin-right', '10mm');
// $options->set('margin-bottom', '80mm');
// $options->set('margin-left', '10mm');

$dompdf->render();
$canvas = $dompdf->getCanvas();
$font = $dompdf->getFontMetrics()->get_font("Arial", "normal");
$canvas->page_text(440, 59, "{PAGE_NUM}/{PAGE_COUNT}", $font, 8, array(0, 0, 0));

if ($dompdf) {
    $dompdf->stream('Registro-envases.pdf', array('Attachment' => 0));
} else {
    $dompdf->stream('Registro-envases.pdf', array('Attachment' => false));
}
