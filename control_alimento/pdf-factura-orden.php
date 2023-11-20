<?php

ob_start();

include "htmlFacturaPlantilla.php";

$html = ob_get_clean();

require_once '../DomPDF/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

if ($dompdf) {
    $dompdf->stream('Factura.pdf', ['Attachment' => 0]);
} else {
    $dompdf->stream('Factura.pdf', ['Attachment' => false]);
}
