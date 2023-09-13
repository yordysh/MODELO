<?php

ob_start();
include "htmlRegistroProduccionPDF.php";

$html = ob_get_clean();

require_once 'DomPDF/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();

$options = new Options();

$options->setIsRemoteEnabled(true);
$options->set('isPhpEnabled', true);
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A2', 'landscape');
// $options->set('margin-top', '10mm');
// $options->set('margin-right', '10mm');
// $options->set('margin-bottom', '80mm');
// $options->set('margin-left', '10mm');

$dompdf->render();
$canvas = $dompdf->getCanvas();
$font = $dompdf->getFontMetrics()->get_font("Arial", "normal");
$canvas->page_text(1325, 80, "{PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0, 0, 0));

$dompdf->stream('Registro-envases.pdf', array('Attachment' => 0));
