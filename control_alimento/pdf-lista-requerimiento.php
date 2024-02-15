<?php

ob_start();
include "htmlListadoRquerimiento.php";

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

$dompdf->render();
$canvas = $dompdf->getCanvas();
$font = $dompdf->getFontMetrics()->get_font("Arial", "normal");
$canvas->page_text(470, 54, "{PAGE_NUM}/{PAGE_COUNT}", $font, 11, array(0, 0, 0));

if ($dompdf) {
    $dompdf->stream('Lista-requerimiento.pdf', array('Attachment' => 0));
} else {
    $dompdf->stream('Lista-requerimiento.pdf', array('Attachment' => false));
}
