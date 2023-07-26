<?php
ob_start();
include "htmlInsumosLabPDF.php";

$html = ob_get_clean();

require_once 'DomPDF/autoload.inc.php';

$dompdf = new Dompdf\Dompdf();
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);
$dompdf->loadHtml($html);
// $dompdf->setPaper('A2', 'landscape');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('InsumosLabsabell.pdf', array('Attachment' => 0));
