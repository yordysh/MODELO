<?php
ob_start();

include "htmlLimpiezaPDF.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();

$options = new Options();
$options->setIsRemoteEnabled(true);

$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A2', 'landscape');
$dompdf->render();
$canvas = $dompdf->getCanvas();
$font = $dompdf->getFontMetrics()->get_font("Arial", "normal");
$canvas->page_text(10, 10, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 8, array(0, 0, 0));

$dompdf->stream('LimpiezayDesinfeccion.pdf', array('Attachment' => 0));
