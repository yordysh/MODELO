<?php

ob_start();
include "htmlControlRecepcion.php";

$html = ob_get_clean();

require_once '../DomPDF/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();

$options = new Options();
$options->setIsRemoteEnabled(true);

$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A1', 'landscape');

$dompdf->render();
$canvas = $dompdf->getCanvas();
$font = $dompdf->getFontMetrics()->get_font("Arial", "normal");
$canvas->page_text(2000, 81, "{PAGE_NUM}/{PAGE_COUNT}", $font, 12, array(0, 0, 0));

if ($dompdf) {
    $dompdf->stream('control-recepcion.pdf', array('Attachment' => 0));
} else {
    $dompdf->stream('control-recepcion.pdf', array('Attachment' => false));
}
